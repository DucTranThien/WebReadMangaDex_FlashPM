<?php
session_start();
require_once "../includes/JWTHandler.php";
require_once "../includes/db.php";

// Tự động đăng nhập lại bằng JWT nếu có
if (!isset($_SESSION["user_id"]) && isset($_COOKIE["jwt_token"])) {
    try {
        $decoded = JWTHandler::decodeToken($_COOKIE["jwt_token"]);
        $_SESSION["user_id"] = $decoded->user_id;
        $_SESSION["username"] = $decoded->username;
        $_SESSION["email"] = $decoded->email;
        $_SESSION["avatar_url"] = $decoded->avatar_url ?? "http://localhost/Comic/assets/images/default_avatar.jpg";
    } catch (Exception $e) {
        setcookie("jwt_token", "", time() - 3600, "/");
        header("Location: login.php");
        exit();
    }
}

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];

// Lấy thông tin người dùng từ database
$stmt = $conn->prepare("SELECT username, email, avatar_url, login_method, created_at FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username, $email, $avatar_url_db, $login_method, $created_at);
$stmt->fetch();
$stmt->close();

// Cập nhật avatar_url từ DB vào session nếu khác
if (!empty($avatar_url_db)) {
    $_SESSION["avatar_url"] = $avatar_url_db;
} elseif (!isset($_SESSION["avatar_url"])) {
    $_SESSION["avatar_url"] = "http://localhost/Comic/assets/images/default_avatar.jpg";
}

// Lấy lịch sử đọc truyện
$history_query = "SELECT manga.id, manga.title, manga.cover_url, reading_history.last_read 
                  FROM reading_history 
                  JOIN manga ON reading_history.manga_id = manga.id 
                  WHERE reading_history.user_id = ? ORDER BY reading_history.last_read DESC LIMIT 10";
$history_stmt = $conn->prepare($history_query);
$history_stmt->bind_param("i", $user_id);
$history_stmt->execute();
$history_result = $history_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Tài Khoản</title>
    <link rel="stylesheet" href="../assets/css/style3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<div class="container">
<a href="../pages/index.php" class="btn back">⬅️ Quay lại Trang Chủ</a>
<div class="dashboard-container">
    <h2>👤 Tài Khoản Cá Nhân</h2>
    <div class="profile-header">
        <div class="avatar-wrapper">
            <img id="avatar-preview" src="<?php echo htmlspecialchars($_SESSION['avatar_url']); ?>" alt="Avatar" class="profile-avatar">
            <label for="avatar-upload" class="avatar-edit">🖼️ Chọn ảnh đại diện mới</label>
            <input type="file" id="avatar-upload" accept="image/*">
        </div>
        <div class="profile-info">
            <p><strong>Tên:</strong> <span id="display-username"><?php echo htmlspecialchars($username); ?></span></p>
            <p><strong>Email:</strong> <span id="display-email"><?php echo htmlspecialchars($email); ?></span></p>
            <p><strong>Hình thức đăng nhập:</strong> 
                <span style="color: #0ff; font-weight: bold;"><?php echo strtoupper($login_method); ?></span>
            </p>
            <p><strong>Thành viên từ:</strong> <?php echo date("d/m/Y", strtotime($created_at)); ?></p>
            <button id="edit-profile-btn" class="btn">✏️ Chỉnh sửa thông tin</button>
            <a href="../users/logout.php" class="btn logout">🚪 Đăng Xuất</a>
        </div>
    </div>

    <!-- Form chỉnh sửa -->
<div id="edit-profile-form" class="edit-form hidden">
    <h3>✏️ Chỉnh Sửa Thông Tin</h3>
    <form id="update-profile">
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>

        <?php if ($_SESSION["login_method"] === "manual"): ?>
                <!-- Cho phép nhập -->
                <input type="password" id="password" name="password" placeholder="Nhập mật khẩu mới (bỏ trống nếu không đổi)">
            <?php else: ?>
                <!-- Chặn -->
            <p style="color: red; font-style: italic;">
                🔒 Bạn đã đăng nhập bằng <?php echo ucfirst($_SESSION["login_method"]); ?> nên không thể thay đổi thông tin cá nhân ở đây.
            </p>
        <?php endif; ?>


        <div class="form-buttons">
        <button type="submit" class="btn"><i class="fas fa-save"></i> Lưu</button>
            <button type="button" id="cancel-edit" class="btn cancel">❌ Hủy</button>
        </div>
    </form>
    <p id="update-message"></p>
</div>

    
    <!-- Lịch sử đọc truyện -->
    <h3>📖 Lịch Sử Đọc Truyện</h3>
    <div class="history">
    <?php include '../users/hr-dashboard.php'; ?>

    </div>
</div>
</div>

<script>
$(document).ready(function() {
    $("#edit-profile-btn").click(function () {
        $("#edit-profile-form").removeClass("hidden").addClass("show");
        $("#overlay").addClass("show");
    });

    // Hủy chỉnh sửa
    $("#cancel-edit, #overlay").click(function () {
        $("#edit-profile-form").removeClass("show").addClass("hidden");
        $("#overlay").removeClass("show");
    });

    // Gửi form cập nhật thông tin cá nhân
    $("#update-profile").submit(function (e) {
    e.preventDefault();

    const loginMethod = "<?php echo $_SESSION['login_method']; ?>";

    if (loginMethod === "google" || loginMethod === "facebook") {
        $("#update-message").html(
            "<span style='color: orange;'>🔒 Bạn đã đăng nhập bằng <strong>" +
            loginMethod.toUpperCase() + "</strong> nên không thể chỉnh sửa thông tin cá nhân.</span>"
        );
        setTimeout(() => location.reload(), 2000);
        return;
    }

    const formData = $(this).serialize();

    $.ajax({
        type: "POST",
        url: "./users/update_profile.php",
        data: formData,
        contentType: "application/x-www-form-urlencoded",
        beforeSend: function (xhr) {
            const token = getCookie("jwt_token");
            if (token) {
                xhr.setRequestHeader("Authorization", "Bearer " + token);
            }
        },
        success: function (response) {
            $("#update-message").html("<span style='color: limegreen;'>✅ " + response + "</span>");
            setTimeout(() => location.reload(), 1000);
        },
        error: function () {
            $("#update-message").html("<span style='color: red;'>❌ Đã xảy ra lỗi khi gửi yêu cầu.</span>");
        }
    });
});

    $("#avatar-upload").change(function(event) {
        let file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = e => {
                $("#avatar-preview").attr("src", e.target.result);
            };
            reader.readAsDataURL(file);

            let formData = new FormData();
            formData.append("avatar", file);

            $.ajax({
                type: "POST",
                url: "../users/update_avatar.php",
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json",
                beforeSend: function(xhr) {
                    const token = getCookie("jwt_token");
                    if (token) {
                        xhr.setRequestHeader("Authorization", "Bearer " + token);
                    }
                },
                success: function(response) {
                    if (response.status === "success") {
                        alert(response.message);
                        $("#avatar-preview").attr("src", response.avatar_url);
                        $("#header-avatar").attr("src", response.avatar_url);
                    } else {
                        alert(response.message);
                    }
                }
            });
        }
    });

    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(";").shift();
    }
});

</script>

</body>
</html>
