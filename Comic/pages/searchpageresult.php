<?php
include "../includes/db.php";
include "../includes/header.php"; 

$query = "SELECT * FROM manga ORDER BY rating DESC LIMIT 10";
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
</head>
<body>


<div class="recommend-section">
    <h2>Truyện Đề Cử</h2>
    <div class="recommend-wrapper">
        <div class="recommend-container">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="manga-container" 
                     data-summary="<?php echo htmlspecialchars($row['content_summary']); ?>"
                     data-gif="../assets/<?php echo $row['background_gif']; ?>">
                    <a href="comic.php?id=<?php echo $row['id']; ?>">
                        <img src="<?php echo $row['cover_url']; ?>" alt="<?php echo $row['title']; ?>">
                        <p class="title"><?php echo $row['title']; ?></p>
                        <p class="details">⭐ <?php echo $row['rating']; ?> | ❤️ <?php echo $row['likes']; ?></p>
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