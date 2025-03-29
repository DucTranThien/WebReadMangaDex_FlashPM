<?php
include __DIR__ . "/../includes/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

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
                $avatar_url = '/assets/avatars/' . $newFileName;
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
        echo "<script>alert('Đăng ký thành công! Đăng nhập ngay.'); window.location.href='../users/login.php';</script>";
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
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="stylesheet" href="../assets/style2.css">
</head>
<body class="register-page">
<?php include __DIR__ . '/../includes/header.php'; ?>

<div class="container">
    <h2>Đăng Ký Tài Khoản</h2>
    <form method="post" enctype="multipart/form-data">
        <input type="text" name="username" placeholder="Tên đăng nhập" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Mật khẩu" required>
        <div class="avatar-upload">
            <label for="avatar">Chọn ảnh đại diện:</label>
            <input type="file" name="avatar" id="avatar" accept="image/*" required onchange="previewAvatar(event)">
            <img id="avatar-preview" src="/assets/default-avatar.png" alt="Ảnh đại diện" class="avatar-preview">
        </div>
        <button type="submit">Đăng Ký</button>
    </form>
    <p>Đã có tài khoản? <a href="../users/login.php">Đăng nhập</a></p>
</div>

<script>
function previewAvatar(event) {
    const reader = new FileReader();
    reader.onload = function () {
        const preview = document.getElementById('avatar-preview');
        preview.src = reader.result;
        preview.style.display = 'block';
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
