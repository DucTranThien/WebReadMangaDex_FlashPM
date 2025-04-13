<?php
require_once "../includes/db.php";
require_once "../includes/JWTHandler.php";

header("Content-Type: text/plain");

// Kiểm tra token
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

// Lấy login_method từ DB
$stmtMethod = $conn->prepare("SELECT login_method FROM users WHERE id = ?");
$stmtMethod->bind_param("i", $user_id);
$stmtMethod->execute();
$stmtMethod->bind_result($login_method);
$stmtMethod->fetch();
$stmtMethod->close();

// Chặn chỉnh sửa nếu không phải manual
if ($login_method !== 'manual') {
    echo "Bạn đã đăng nhập bằng $login_method nên không thể chỉnh sửa thông tin.";
    exit;
}

// Thực hiện cập nhật
if ($password) {
    $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, password = ? WHERE id = ?");
    $stmt->bind_param("sssi", $username, $email, $password, $user_id);
} else {
    $stmt = $conn->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
    $stmt->bind_param("ssi", $username, $email, $user_id);
}

if ($stmt->execute()) {
    $stmt->close();

    // Lấy lại avatar sau cập nhật
    $stmt = $conn->prepare("SELECT avatar_url FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($avatar_url);
    $stmt->fetch();
    $stmt->close();

    // Cập nhật session + JWT
    session_start();
    $_SESSION["user_id"] = $user_id;
    $_SESSION["username"] = $username;
    $_SESSION["email"] = $email;
    $_SESSION["avatar_url"] = $avatar_url ?: "http://localhost/Comic/assets/images/default_avatar.jpg";
    $_SESSION["login_method"] = $login_method;

    $new_token = JWTHandler::generateToken([
        "user_id" => $user_id,
        "username" => $username,
        "email" => $email,
        "avatar_url" => $_SESSION["avatar_url"]
    ]);
    setcookie("jwt_token", $new_token, time() + 86400, "/");

    echo "Cập nhật thông tin cá nhân thành công!";
} else {
    $error = $stmt->error;
    $stmt->close();
    echo "Lỗi khi cập nhật: $error";
}
?>
