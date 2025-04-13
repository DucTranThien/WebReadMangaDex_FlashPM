<?php
session_start();
include __DIR__ . "/../includes/db.php";
require_once __DIR__ . '/../includes/JWTHandler.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input = trim($_POST["email"]); // Có thể là email hoặc username
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT id, username, email, password, avatar_url FROM users WHERE email = ? OR username = ?");
    $stmt->bind_param("ss", $input, $input);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($user_id, $username, $email, $hashed_password, $avatar_url);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && password_verify($password, $hashed_password)) {
        $token = JWTHandler::generateToken([
            "user_id" => $user_id,
            "username" => $username,
            "email" => $email,
            "avatar_url" => $avatar_url,
            $_SESSION["login_method"] = "manual"
        ]);

        // Lưu vào SESSION và COOKIE
        $_SESSION["user_id"] = $user_id;
        $_SESSION["username"] = $username;
        $_SESSION["email"] = $email;
        $_SESSION["avatar_url"] = $avatar_url ?: "http://localhost/Comic/assets/images/default_avatar.jpg";
        $_SESSION["login_method"] = "manual";
        setcookie("jwt_token", $token, time() + 86400, "/");

        header("Location: ../pages/index.php");
        exit();
    } else {
        echo "<script>alert('Sai email/tên đăng nhập hoặc mật khẩu!');</script>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng Nhập</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/style2.css">
</head>
<body>

<?php include __DIR__ . '/../includes/header.php'; ?>
<div class="container">
    <h2>Đăng Nhập</h2>
    <form method="post">
        <input type="text" name="email" placeholder="Email hoặc Tên đăng nhập" required>
        <input type="password" name="password" placeholder="Mật khẩu" required>
        <button type="submit">Đăng Nhập</button>
    </form>

    <div class="social-login">
        <a class="social-button google-btn" href="google-login.php">
            <img src="../assets/images/google-icon.png" alt="Google"> Đăng nhập với Google
        </a>
        <a class="social-button facebook-btn" href="facebook-login.php">
            <img src="../assets/images/facebook_icon.png" alt="Facebook"> Đăng nhập với Facebook
        </a>
    </div>

    <div class="register-link">
        Chưa có tài khoản? <a href="register.php">Đăng ký</a>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
