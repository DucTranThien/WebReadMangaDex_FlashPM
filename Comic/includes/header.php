<?php
// Include database connection (needed for consistency, even if not used here)
include __DIR__ . "/db.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kiểm tra nếu người dùng đã đăng nhập
if (isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];

    // Truy vấn lấy avatar và username
    $stmt = $conn->prepare("SELECT username, avatar_url FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($username, $avatar_url);
    $stmt->fetch();
    $stmt->close();

    // Lưu username vào session nếu chưa có (để đồng bộ)
    if (!isset($_SESSION["username"])) {
        $_SESSION["username"] = $username;
    }

    if (empty($avatar_url)) {
        $avatar_url = "http://localhost/Comic/assets/images/default_avatar.jpg";
    }
} else {
    $avatar_url = "http://localhost/Comic/assets/images/default_avatar.jpg";
}


// Fetch categories from local API
$categories = [];
$categoryJson = @file_get_contents('http://localhost/Comic/api/get_categories.php');
if ($categoryJson !== false) {
    $categoryData = json_decode($categoryJson, true);
    if (isset($categoryData['status']) && $categoryData['status'] === 'success' && !empty($categoryData['data'])) {
        $categories = $categoryData['data'];
    } else {
        $categories = [
            "Action", "Comedy", "Drama", "Fantasy", "Horror", "Romance"
        ];
    }
} else {
    $categories = [
        "Action", "Comedy", "Drama", "Fantasy", "Horror", "Romance"
    ];
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
                <?php
                foreach ($categories as $category) {
                    echo "<a href='#'>$category</a>";
                }
                ?>
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
                    <a href="../users/dashboard.php" class="btn">Trang Cá Nhân</a>
                    <a href="../users/logout.php" class="btn logout">Đăng Xuất</a>
                </div>
            <?php else: ?>
                <a href="../users/login.php" class="btn">Đăng Nhập</a>
                <a href="../users/register.php" class="btn register">Đăng Ký</a>
            <?php endif; ?>
        </div>
    </nav>
</header>