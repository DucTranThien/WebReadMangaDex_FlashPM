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
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Tài Khoản</title>
    <link rel="stylesheet" href="../assets/style3.css">
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

        <?php if ($_SESSION["login_method"] !== "google"): ?>
            <input type="password" id="password" name="password" placeholder="Nhập mật khẩu mới (bỏ trống nếu không đổi)">
        <?php else: ?>
            <p style="color: gray; font-style: italic;">🔒 Bạn đã đăng nhập bằng Google nên không thể thay đổi mật khẩu ở đây.</p>
        <?php endif; ?>

        <div class="form-buttons">
            <button type="submit" class="btn">📎 Lưu</button>
            <button type="button" id="cancel-edit" class="btn cancel">❌ Hủy</button>
        </div>
    </form>
    <p id="update-message"></p>
</div>

    <!-- Lịch sử đọc truyện -->
    <h3>📖 Lịch Sử Đọc Truyện</h3>
    <div class="history">
        <?php
        $history_stmt = $conn->prepare("SELECT manga.id, manga.title, manga.cover_url, history.last_read 
                                        FROM history JOIN manga ON history.manga_id = manga.id 
                                        WHERE history.user_id = ? 
                                        ORDER BY history.last_read DESC LIMIT 10");
        $history_stmt->bind_param("i", $user_id);
        $history_stmt->execute();
        $history_result = $history_stmt->get_result();
        while ($row = $history_result->fetch_assoc()):
        ?>
            <div class="manga-item">
                <a href="../manga_detail.php?id=<?php echo $row['id']; ?>">
                    <img src="<?php echo htmlspecialchars($row['cover_url']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
                    <p><?php echo htmlspecialchars($row['title']); ?></p>
                    <p>🕒 Đọc lần cuối: <?php echo date("d/m/Y H:i", strtotime($row['last_read'])); ?></p>
                </a>
            </div>
        <?php endwhile; ?>
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

        const formData = $(this).serialize();

        $.ajax({
            type: "POST",
            url: "../users/update_profile.php",
            data: formData,
            contentType: "application/x-www-form-urlencoded",
            beforeSend: function (xhr) {
                const token = getCookie("jwt_token");
                if (token) {
                    xhr.setRequestHeader("Authorization", "Bearer " + token);
                }
            },
            success: function (response) {
                $("#update-message").text(response);
                setTimeout(() => location.reload(), 1000);
            },
            error: function () {
                $("#update-message").text("Đã xảy ra lỗi khi gửi yêu cầu.");
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
