<?php
session_start();
include __DIR__ . "/../includes/db.php";

if (!isset($_SESSION["user_id"])) {
    echo "Lỗi: Bạn chưa đăng nhập!";
    exit();
}

$user_id = $_SESSION["user_id"];
$username = trim($_POST["username"]);
$email = trim($_POST["email"]);
$password = !empty($_POST["password"]) ? password_hash($_POST["password"], PASSWORD_DEFAULT) : null;

// Cập nhật thông tin
if ($password) {
    $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, password = ? WHERE id = ?");
    $stmt->bind_param("sssi", $username, $email, $password, $user_id);
} else {
    $stmt = $conn->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
    $stmt->bind_param("ssi", $username, $email, $user_id);
}

if ($stmt->execute()) {
    $_SESSION["username"] = $username;
    echo "Cập nhật thành công!";
} else {
    echo "Lỗi: " . $stmt->error;
}
$stmt->close();
?>
