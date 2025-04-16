<?php
session_start();
include __DIR__ . "/../includes/db.php";
require_once __DIR__ . '/../includes/JWTHandler.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $avatar_url = '';

    // Kiểm tra email đã tồn tại chưa
    $check_stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        echo "<script>alert('Email đã được sử dụng. Vui lòng chọn email khác!'); window.history.back();</script>";
        exit();
    }
    $check_stmt->close();

    // Xử lý upload ảnh đại diện
    $avatar_url = '';
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['avatar']['tmp_name'];
        $fileName = $_FILES['avatar']['name'];
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array(strtolower($fileExtension), $allowedExtensions)) {
            $newFileName = 'avatar_' . time() . '.' . $fileExtension;
            $uploadFileDir = __DIR__ . '/../assets/avatars/';
            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0777, true);
            }
            $destPath = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $destPath)) {
                $avatar_url = 'http://localhost/Comic/assets/avatars/' . $newFileName;
            } else {
                echo "<script>alert('Lỗi khi upload ảnh.');</script>";
            }
        } else {
            echo "<script>alert('Chỉ cho phép upload file JPG, JPEG, PNG, GIF.');</script>";
        }
    }

    $stmt = $conn->prepare("INSERT INTO users (username, email, password, avatar_url) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $password, $avatar_url);

    if ($stmt->execute()) {
        $user_id = $stmt->insert_id;
        $jwt = new JWTHandler();
        $token = JWTHandler::generateToken([
            "user_id" => $user_id,
            "username" => $username,
            "email" => $email,
            "avatar_url" => $avatar_url
        ]);
        
        // Lưu vào cookie và session
        $_SESSION["user_id"] = $user_id;
        $_SESSION["username"] = $username;
        $_SESSION["email"] = $email;
        $_SESSION["avatar_url"] = $avatar_url ?: "http://localhost/Comic/assets/images/default_avatar.jpg";
        setcookie("jwt_token", $token, time() + 86400, "/");


        echo "<script>alert('Đăng ký thành công!'); window.location.href='../pages/index.php';</script>";
    } else {
        echo "<script>alert('Lỗi: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng Ký</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/style2.css">
</head>

<?php include __DIR__ . '/../includes/header.php'; ?>
<body>
<div class="container">
    <h2>Đăng Ký Tài Khoản</h2>
    <form method="post" enctype="multipart/form-data">
        <input type="text" name="username" placeholder="Tên đăng nhập" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Mật khẩu" required>
        <div class="avatar-upload">
            <label for="avatar">Chọn ảnh đại diện:</label>
            <input type="file" name="avatar" id="avatarInput" accept="image/*">
            <img id="avatarPreview" src="../assets/default-avatar.png" style="display: block; width: 80px; height: 80px; object-fit: cover; margin: 10px auto; border-radius: 50%; border: 2px solid #fff;">
        </div>
        <button type="submit">Đăng Ký</button>
    </form>
    <p>Đã có tài khoản? <a href="../users/login.php">Đăng nhập</a></p>
</div>

<script>
 const avatarInput = document.getElementById('avatarInput');
    const preview = document.getElementById('avatarPreview');

    avatarInput.addEventListener('change', function () {
        const file = this.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            preview.src = '';
            preview.style.display = 'none';
        }
    });
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
