<?php
session_start();
include __DIR__ . "/../includes/db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

// Lấy thông tin người dùng
$stmt = $conn->prepare("SELECT username, email, avatar_url, login_method, created_at FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username, $email, $avatar_url, $login_method, $created_at);
$stmt->fetch();
$stmt->close();

// Nếu không có avatar, dùng ảnh mặc định
if (empty($avatar_url)) {
    $avatar_url = "http://localhost/Comic/assets/images/default_avatar.jpg";
}

// Lấy lịch sử đọc truyện
$history_query = "SELECT manga.id, manga.title, manga.cover_url, history.last_read 
                  FROM history 
                  JOIN manga ON history.manga_id = manga.id 
                  WHERE history.user_id = ? ORDER BY history.last_read DESC LIMIT 10";
$history_stmt = $conn->prepare($history_query);
$history_stmt->bind_param("i", $user_id);
$history_stmt->execute();
$history_result = $history_stmt->get_result();

// Lấy danh sách truyện yêu thích
$fav_query = "SELECT manga.id, manga.title, manga.cover_url 
              FROM favorites 
              JOIN manga ON favorites.manga_id = manga.id 
              WHERE favorites.user_id = ? ORDER BY favorites.added_at DESC LIMIT 10";
$fav_stmt = $conn->prepare($fav_query);
$fav_stmt->bind_param("i", $user_id);
$fav_stmt->execute();
$fav_result = $fav_stmt->get_result();
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
            <img id="avatar-preview" src="<?php echo htmlspecialchars($avatar_url); ?>" alt="Avatar" class="profile-avatar">
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
        <input type="password" id="password" name="password" placeholder="Nhập mật khẩu mới (bỏ trống nếu không đổi)">
        <div class="form-buttons">
            <button type="submit" class="btn">💾 Lưu</button>
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

    <!-- Truyện yêu thích -->
    <h3>❤️ Truyện Yêu Thích</h3>
    <div class="favorites">
        <?php while ($row = $fav_result->fetch_assoc()): ?>
            <div class="manga-item">
                <a href="../manga_detail.php?id=<?php echo $row['id']; ?>">
                    <img src="<?php echo htmlspecialchars($row['cover_url']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
                    <p><?php echo htmlspecialchars($row['title']); ?></p>
                </a>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<script>
$(document).ready(function() {
    // Hiển thị form khi bấm vào nút
    $("#edit-profile-btn").click(function() {
        $("#edit-profile-form").removeClass("hidden").addClass("show");
        $("#overlay").addClass("show");
    });
 // Đóng form khi click nút Hủy
 $("#cancel-edit").click(function() {
        $("#edit-profile-form").removeClass("show").addClass("hidden");
        $("#overlay").removeClass("show");
    });

    // Đóng form khi click ra ngoài overlay
    $("#overlay").click(function() {
        $("#edit-profile-form").removeClass("show").addClass("hidden");
        $(this).removeClass("show");
    });
    // Xử lý AJAX cập nhật thông tin
    $("#update-profile").submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "../users/update_profile.php",
            data: $(this).serialize(),
            success: function(response) {
                $("#update-message").text(response);
                setTimeout(() => location.reload(), 1000);
            }
        });
    });

     // Xử lý thay đổi avatar
     $("#avatar-upload").change(function(event) {
        let file = event.target.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function(e) {
                $("#avatar-preview").attr("src", e.target.result); // Hiển thị ảnh xem trước
            }
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
                success: function(response) {
                    if (response.status === "success") {
                        alert(response.message);
                        $("#avatar-preview").attr("src", response.avatar_url); // Cập nhật ảnh trên dashboard
                        $("#header-avatar").attr("src", response.avatar_url); // Cập nhật avatar trên header
                    } else {
                        alert(response.message);
                    }
                }
            });
        }
    });
});
</script>

</body>
</html>
