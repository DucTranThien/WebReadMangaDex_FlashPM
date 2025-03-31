<?php
include __DIR__ . "/db.php";
require_once __DIR__ . "/JWTHandler.php";

if (session_status() === PHP_SESSION_NONE) session_start();

// Nếu chưa có thông tin user trong session, lấy từ JWT nếu có
if (!isset($_SESSION["user_id"]) && isset($_COOKIE["jwt_token"])) {
    try {
        $decoded = JWTHandler::decodeToken($_COOKIE["jwt_token"]);

        $_SESSION["user_id"] = $decoded->user_id ?? null;
        $_SESSION["username"] = $decoded->username ?? null;
        $_SESSION["email"] = $decoded->email ?? null;
        $_SESSION["avatar_url"] = $decoded->avatar_url ?? "http://localhost/Comic/assets/images/default_avatar.jpg";

    } catch (Exception $e) {
        setcookie("jwt_token", "", time() - 3600, "/"); // Xóa token nếu lỗi
        $_SESSION = [];
    }
}

// Gán avatar để sử dụng trong giao diện
$avatar_url = $_SESSION["avatar_url"] ?? "http://localhost/Comic/assets/images/default_avatar.jpg";


// Fetch thể loại từ API nội bộ
$categories = [];
$categoryJson = @file_get_contents('http://localhost/Comic/api/get_categories.php');
if ($categoryJson !== false) {
    $categoryData = json_decode($categoryJson, true);
    if (isset($categoryData['status']) && $categoryData['status'] === 'success' && !empty($categoryData['data'])) {
        $categories = $categoryData['data'];
    }
}
if (empty($categories)) {
    $categories = ["Action", "Comedy", "Drama", "Fantasy", "Horror", "Romance"];
}
?>

<header>
    <div><span style="font-size: 27px; font-weight: bold;">📚</span><span class="logo">MangaFlashPM</span></div>
    <nav>
        <a href="/Comic/pages/index.php">Trang Chủ</a>
        <a href="/Comic/pages/search.php">Tìm Kiếm</a>
        <div class="dropdown">
            <a href="/Comic/pages/categories.php">Thể Loại ▼</a>
            <div class="dropdown-content">
                <?php foreach ($categories as $category): ?>
                    <a href="#"><?php echo htmlspecialchars($category); ?></a>
                <?php endforeach; ?>
            </div>
        </div>
        <a href="#">Xếp Hạng</a>

        <div class="user-section">
            <?php if (isset($_SESSION["user_id"])): ?>
                <div class="user-info">
                    <img src="<?php echo htmlspecialchars($avatar_url); ?>" alt="Avatar" class="header-avatar" id="header-avatar">
                    <?php if (isset($_SESSION["username"])): ?>
                        <span>👋 Xin chào, <strong><?php echo htmlspecialchars($_SESSION["username"]); ?></strong>!</span>
                    <?php endif; ?>
                    <a href="/Comic/users/dashboard.php" class="btn">Trang Cá Nhân</a>
                    <a href="/Comic/users/logout.php" class="btn logout">Đăng Xuất</a>
                </div>
            <?php else: ?>
                <a href="/Comic/users/login.php" class="btn">Đăng Nhập</a>
                <a href="/Comic/users/register.php" class="btn register">Đăng Ký</a>
            <?php endif; ?>
        </div>
    </nav>
</header>
