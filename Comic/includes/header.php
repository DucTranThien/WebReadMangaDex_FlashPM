<?php

    include __DIR__ . "/db.php";

require_once __DIR__ . "/JWTHandler.php";
autoSyncCategoriesIfMissing($conn);

//session + JWT xử lý user
if (!isset($_SESSION["user_id"]) && isset($_COOKIE["jwt_token"])) {
    try {
        $decoded = JWTHandler::decodeToken($_COOKIE["jwt_token"]);
        $_SESSION["user_id"] = $decoded->user_id ?? null;
        $_SESSION["username"] = $decoded->username ?? null;
        $_SESSION["email"] = $decoded->email ?? null;
        $_SESSION["avatar_url"] = $decoded->avatar_url ?? "http://localhost/Comic/assets/images/default_avatar.jpg";
    } catch (Exception $e) {
        setcookie("jwt_token", "", time() - 3600, "/");
        $_SESSION = [];
    }
}
$avatar_url = $_SESSION["avatar_url"] ?? "http://localhost/Comic/assets/images/default_avatar.jpg";


$headerCategories = [];

$check = $conn->query("SELECT COUNT(*) AS total FROM categories");
$row = $check->fetch_assoc();
if ($row['total'] > 0) {
    $catresult = $conn->query("SELECT mangadex_tag_id AS id, name FROM categories ORDER BY name ASC");
    while ($cat = $catresult->fetch_assoc()) {
        $headerCategories[] = $cat;
    }
} else {
    //fallback nếu DB rỗng
    $headerCategories = [
        ["id" => "action", "name" => "Action"],
        ["id" => "comedy", "name" => "Comedy"],
        ["id" => "drama", "name" => "Drama"],
        ["id" => "fantasy", "name" => "Fantasy"],
        ["id" => "horror", "name" => "Horror"],
        ["id" => "romance", "name" => "Romance"]
    ];
}
    function autoSyncCategoriesIfMissing(mysqli $conn) {
    // Lấy số tag từ database
    $dbCount = 0;
    $result = $conn->query("SELECT COUNT(*) AS total FROM categories");
    if ($result && $row = $result->fetch_assoc()) {
        $dbCount = (int)$row['total'];
    }

    // Lấy số tag thực tế từ MangaDex API
    $apiCount = 0;
    $url = "https://api.mangadex.org/manga/tag";
    $options = [
        "http" => [
            "method" => "GET",
            "header" => "User-Agent: ComicBase/1.0\r\nAccept: application/json\r\n"
        ]
    ];
    $context = stream_context_create($options);
    $response = @file_get_contents($url, false, $context);

    if ($response !== false) {
        $data = json_decode($response, true);
        if (isset($data['data']) && is_array($data['data'])) {
            $apiCount = count($data['data']);
        }
    }

    // Nếu thiếu tag → gọi file sync
    if ($apiCount > 0 && $dbCount < $apiCount) {
        @file_get_contents("http://localhost/Comic/api/sync_categories.php");
    }
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
                <?php foreach ($headerCategories as $category): ?>
                    <?php if (!empty($category['id']) && !empty($category['name'])): ?>
                        <a href="/Comic/pages/search.php?genre=<?= urlencode($category['id']) ?>">
                            <?= htmlspecialchars($category['name']) ?>
                        </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="user-section">
            <?php if (isset($_SESSION["user_id"])): ?>
                <div class="user-info">
                    <img src="<?= htmlspecialchars($avatar_url) ?>" alt="Avatar" class="header-avatar" id="header-avatar">
                    <?php if (isset($_SESSION["username"])): ?>
                        <span>👋 Xin chào, <strong><?= htmlspecialchars($_SESSION["username"]) ?></strong>!</span>
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
<style>
    .dropdown-content {
        display: grid;
        grid-template-columns: repeat(5, minmax(100px, 1fr));
        gap: 8px;
        max-height: 300px;
        overflow-y: auto;
        background-color: #222;
        padding: 10px;
        border-radius: 6px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.5);
        width: 800px;
    }

    .dropdown-content a {
        display: block;
        color: white;
        text-decoration: none;
        padding: 6px 8px;
        border-radius: 4px;
        transition: background 0.2s;
        font-size: 14px;
    }

    .dropdown-content a:hover {
        background-color: #00aa55;
    }
    .dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        z-index: 999;
    }

    .dropdown:hover .dropdown-content {
        display: grid;
    }

</style>
