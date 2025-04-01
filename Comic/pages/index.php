<?php
include "../includes/db.php";

session_start();

// // Kiểm tra đăng nhập bằng Google
// if (!isset($_SESSION["user_id"])) {
//     header("Location: ../users/login.php");
//     exit();
// }


// // Define the full path to the PHP executable
// $phpExecutable = 'C:/xampp/php/php.exe';
// if (!file_exists($phpExecutable)) {
//     die("Error: PHP executable not found at $phpExecutable. Please update the path.");
// }

// // Trigger fetch_popular_manga.php in the background
// $scriptPath = __DIR__ . '/../api/fetch_popular_manga.php';
// $logFile = __DIR__ . '/../logs/fetch_popular_manga.log';
// $logDir = dirname($logFile);
// if (!is_dir($logDir) && !mkdir($logDir, 0777, true)) {
//     die("Error: Could not create logs directory at $logDir");
// }

// if (PHP_OS_FAMILY === 'Windows') {
//     // Use popen to avoid focus stealing
//     $command = "\"$phpExecutable\" \"$scriptPath\" > \"$logFile\" 2>&1";
//     $handle = popen($command, 'r');
//     if ($handle === false) {
//         file_put_contents($logFile, "Failed to start background script: $command\n", FILE_APPEND);
//     } else {
//         pclose($handle);
//     }
// } else {
//     // Linux/Unix command
//     exec("php \"$scriptPath\" > \"$logFile\" 2>&1 &");
// }

// // Fetch top-rated manga for the recommendation section
// $query = "SELECT * FROM manga ORDER BY content_rating DESC LIMIT 10";
// $result = $conn->query($query);

// if (!$result) {
//     die("SQL Error: " . $conn->error);
// }

// // Get the current page from query parameter
// $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;


// Giới hạn lịch sử đọc truyện 10 truyện
if (!isset($_SESSION['reading_history'])) {
    $_SESSION['reading_history'] = [];
}

// Tự động gọi script fetch mới nhất
$phpExecutable = 'C:/xampp/php/php.exe';
$scriptPath = __DIR__ . '/../api/fetch_popular_manga.php';
$logFile = __DIR__ . '/../logs/fetch_popular_manga.log';
$logDir = dirname($logFile);
if (!is_dir($logDir)) mkdir($logDir, 0777, true);

if (PHP_OS_FAMILY === 'Windows') {
    $command = "\"$phpExecutable\" \"$scriptPath\" > \"$logFile\" 2>&1";
    $handle = popen($command, 'r');
    if ($handle) pclose($handle);
} else {
    exec("php \"$scriptPath\" > \"$logFile\" 2>&1 &");
}

// Lấy danh sách truyện đề cử (theo follow nhiều nhất)
$query = "SELECT * FROM manga ORDER BY followed_count DESC LIMIT 10";
$result = $conn->query($query); 
if (!$result) {
    die("SQL Error: " . $conn->error);
}

$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MangaFlashPM - Trang Chủ</title>
    <link rel="stylesheet" href="../assets/style.css">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

    <!-- <base href="http://localhost/Comic/WebReadMangaDex_FlashPM/Comic/pages/"> -->
</head>
<body>
<?php include '../includes/header.php'; ?>

<div class="recommend-section">
    <h2>🔥 Truyện Đề Cử</h2>
    <div class="swiper recommend-swiper">
    <div class="swiper-wrapper">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="swiper-slide">
                <div class="manga-container"
                     style="background-image: url('../assets/gif/<?php echo htmlspecialchars($row['background_gif'] ?? 'default.gif'); ?>')"
                     title="<?php echo htmlspecialchars($row['description'] ?? 'Không có mô tả'); ?>">
                     <a href="manga_detail.php?mangadex_id=<?php echo htmlspecialchars($row['mangadex_id']); ?>">

                        <img src="<?php echo htmlspecialchars($row['cover_url']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
                        <p class="title"><?php echo htmlspecialchars($row['title']); ?></p>
                        <p class="details">⭐ <?php echo number_format($row['average_rating'] ?? 0, 1); ?> | 👥 <?php echo $row['followed_count'] ?? 0; ?></p>
                    </a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>


<div class="main-content">
    <div class="latest-section">
        <h2>🟠 Truyện Mới Cập Nhật</h2>
        <div class="latest-wrapper">
            <div class="latest-container" id="latest-manga-container">
                <!-- Manga will be loaded via JavaScript -->
            </div>
        </div>
        <div class="pagination">
            <button id="prev-page" disabled>⬅️Trang Trước</button>
            <span id="current-page"><?php echo $page; ?></span>
            <button id="next-page">➡️Trang Sau</button>
        </div>
    </div>

    <div class="sidebar">
        <div class="histor-section">
            <?php include '../pages/reading_history.php'; ?>

        </div>
        <div class="ranking-section">
            <h2>⭐ Xếp Hạng</h2>
            <p>Placeholder for ranking content.</p>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?> 
<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
  const swiper = new Swiper('.recommend-swiper', {
  slidesPerView: 'auto',
  spaceBetween: 12, // khoảng cách nhỏ giữa truyện
  loop: true,
  speed: 4000,
  autoplay: {
    delay: 0,
    disableOnInteraction: false,
  },
  freeMode: true,
  freeModeMomentum: false,
});



</script>

<script src="../assets/script.js"></script>
</body>
</html>