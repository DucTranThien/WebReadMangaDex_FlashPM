<?php
require_once "../includes/db.php";
require_once "../includes/JWTHandler.php";

header("Content-Type: text/plain");

$headers = getallheaders();
if (!isset($headers['Authorization'])) {
    echo "Thiếu token xác thực.";
    exit;
}

$token = str_replace("Bearer ", "", $headers['Authorization']);
$jwt = new JWTHandler();
$decoded = $jwt->decodeToken($token);

if (!$decoded || !isset($decoded->user_id)) {
    echo "Token không hợp lệ hoặc đã hết hạn.";
    exit;
}

$user_id = $decoded->user_id;
$username = trim($_POST["username"]);
$email = trim($_POST["email"]);
$password = !empty($_POST["password"]) ? password_hash($_POST["password"], PASSWORD_DEFAULT) : null;

// Kiểm tra login_method
$stmt = $conn->prepare("SELECT login_method FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($login_method);
$stmt->fetch();
$stmt->close();

// Cập nhật DB
if ($login_method !== 'google' && $password) {
    $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, password = ? WHERE id = ?");
    $stmt->bind_param("sssi", $username, $email, $password, $user_id);
} else {
    $stmt = $conn->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
    $stmt->bind_param("ssi", $username, $email, $user_id);
}

if ($stmt->execute()) {
    // Lấy lại avatar_url sau khi update
    $stmt = $conn->prepare("SELECT avatar_url FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($avatar_url);
    $stmt->fetch();
    $stmt->close();

    // Cập nhật session
    session_start();
    $_SESSION["user_id"] = $user_id;
    $_SESSION["username"] = $username;
    $_SESSION["email"] = $email;
    $_SESSION["avatar_url"] = $avatar_url ?: "http://localhost/Comic/assets/images/default_avatar.jpg";
    $_SESSION["login_method"] = $login_method;

    // Tạo JWT mới
    $new_token = JWTHandler::generateToken([
        "user_id" => $user_id,
        "username" => $username,
        "email" => $email,
        "avatar_url" => $_SESSION["avatar_url"]
    ]);
    setcookie("jwt_token", $new_token, time() + 86400, "/");

    echo "Cập nhật thông tin cá nhân thành công!";
} else {
    echo "Lỗi khi cập nhật: " . $stmt->error;
}
$stmt->close();
?>
