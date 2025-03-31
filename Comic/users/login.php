<?php
session_start(); 
include __DIR__ . "/../includes/db.php"; 

$login_method = 'manual';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input = trim($_POST["email"]); // Có thể là email hoặc username
    $password = $_POST["password"];

    // Truy vấn theo username hoặc email
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ? OR username = ?");
    $stmt->bind_param("ss", $input, $input);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $username, $hashed_password);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && password_verify($password, $hashed_password)) {
        $_SESSION["user_id"] = $id;
        $_SESSION["username"] = $username;
        $_SESSION["login_method"] = 'manual';

        header("Location: ../pages/index.php");
        exit();
    } else {
        echo "<script>alert('Sai email/tên đăng nhập hoặc mật khẩu!');</script>";
    }

    $stmt->close();
}

if (isset($_SESSION["login_method"])) {
    $login_method = $_SESSION["login_method"];
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng Nhập</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="stylesheet" href="../assets/style2.css">
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
        Chưa có tài khoản? <a href="../users/register.php">Đăng ký</a>
    </div>
</div>

</body>
<?php include __DIR__ . '/../includes/footer.php'; ?>
</html>