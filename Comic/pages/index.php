<?php
include "../includes/db.php";

// Define the full path to the PHP executable
$phpExecutable = 'C:/xampp/php/php.exe';
if (!file_exists($phpExecutable)) {
    die("Error: PHP executable not found at $phpExecutable. Please update the path.");
}

// Trigger fetch_popular_manga.php in the background
$scriptPath = __DIR__ . '/../api/fetch_popular_manga.php';
$logFile = __DIR__ . '/../logs/fetch_popular_manga.log';
$logDir = dirname($logFile);
if (!is_dir($logDir) && !mkdir($logDir, 0777, true)) {
    die("Error: Could not create logs directory at $logDir");
}

if (PHP_OS_FAMILY === 'Windows') {
    // Use popen to avoid focus stealing
    $command = "\"$phpExecutable\" \"$scriptPath\" > \"$logFile\" 2>&1";
    $handle = popen($command, 'r');
    if ($handle === false) {
        file_put_contents($logFile, "Failed to start background script: $command\n", FILE_APPEND);
    } else {
        pclose($handle);
    }
} else {
    // Linux/Unix command
    exec("php \"$scriptPath\" > \"$logFile\" 2>&1 &");
}

// Fetch top-rated manga for the recommendation section
$query = "SELECT * FROM manga ORDER BY content_rating DESC LIMIT 10";
$result = $conn->query($query);

if (!$result) {
    die("SQL Error: " . $conn->error);
}

// Get the current page from query parameter
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ComicBase - Trang Chủ</title>
    <link rel="stylesheet" href="../assets/style.css">
    <base href="http://localhost/Comic/WebReadMangaDex_FlashPM/Comic/pages/">
</head>
<body>
<?php include '../includes/header.php'; ?>

<div class="recommend-section">
    <h2>Truyện Đề Cử</h2>
    <div class="recommend-wrapper">
        <div class="recommend-container">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="manga-container" 
                     data-summary="<?php echo htmlspecialchars($row['content_summary']); ?>"
                     data-gif="../assets/<?php echo $row['background_gif']; ?>">
                    <a href="manga_detail.php?id=<?php echo htmlspecialchars($row['id']); ?>">
                        <img src="<?php echo htmlspecialchars($row['cover_url']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
                        <p class="title"><?php echo htmlspecialchars($row['title']); ?></p>
                        <p class="details">⭐ <?php echo $row['content_rating']; ?> | ❤️ <?php echo $row['likes']; ?></p>
                    </a>
                </div>
            <?php endwhile; ?>
        </div>
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
            <button id="prev-page" disabled>Trang Trước</button>
            <span id="current-page"><?php echo $page; ?></span>
            <button id="next-page">Trang Sau</button>
        </div>
    </div>

    <div class="sidebar">
        <div class="histor-section">
            <h2>🔄 Lịch Sử Đọc Truyện</h2>
            <p>Placeholder for reading history content.</p>
        </div>
        <div class="ranking-section">
            <h2>⭐ Xếp Hạng</h2>
            <p>Placeholder for ranking content.</p>
        </div>
    </div>
</div>

<script src="../assets/script.js"></script>
</body>
</html>