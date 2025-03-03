<?php
include "../includes/db.php";

$query = "SELECT * FROM manga ORDER BY rating DESC LIMIT 10";
$result = $conn->query($query);

if (!$result) {
    die("SQL Error: " . $conn->error);
}
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

<header>
    <div><span style="font-size: 27px; font-weight: bold;">📚</span><span class="logo">ComicBase</span></div>
    <nav>
        <a href="index.php">Trang Chủ</a>
        <a href="#">Thể Loại</a>
        <a href="#">Xếp Hạng</a>
    </nav>
</header>

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
<script src="../assets/script.js"></script>

<!-- 🟠 Truyện Mới Cập Nhật -->
<h2>🟠 Truyện Mới Cập Nhật</h2>
<div class="comic-list">
    <?php
    $latestMangaJson = file_get_contents('http://localhost/Comic/WebReadMangaDex_FlashPM/Comic/api/get_latest_manga.php');
    if ($latestMangaJson === false) {
        echo "<p>Error: Unable to fetch latest manga (API unreachable).</p>";
    } else {
        $latestManga = json_decode($latestMangaJson, true) ?? ['status' => 'error', 'message' => 'Invalid JSON response'];
        
        if (!isset($latestManga['status']) || $latestManga['status'] === 'error') {
            $errorMsg = $latestManga['message'] ?? 'Unknown error';
            echo "<p>Error: $errorMsg</p>";
            if (isset($latestManga['debug'])) {
                echo "<pre>Debug Info: " . htmlspecialchars($latestManga['debug']) . "</pre>";
            }
        } elseif (!isset($latestManga['data']) || empty($latestManga['data'])) {
            echo "<p>No manga found.</p>";
        } else {
            foreach ($latestManga['data'] as $manga):
                $coverJson = @file_get_contents("http://localhost/Comic/WebReadMangaDex_FlashPM/Comic/api/get_cover.php?id=" . urlencode($manga['id']));
                $coverUrl = '../assets/images/default.jpg';
                if ($coverJson !== false) {
                    $coverData = json_decode($coverJson, true);
                    if (isset($coverData['status']) && $coverData['status'] === 'success') {
                        $coverUrl = $coverData['data']['cover_url'];
                    }
                }
    ?>
                <div class="comic">
                    <a href="manga_detail.php?mangadex_id=<?php echo $manga['id']; ?>">
                        <img src="<?php echo $coverUrl; ?>" alt="<?php echo $manga['name']; ?>">
                        <p><?php echo $manga['name']; ?></p>
                        <small>📅 <?php echo date("d/m/Y", strtotime($manga['newest_upload_date'])); ?> | Chương <?php echo $manga['chapter']; ?></small>
                    </a>
                </div>
    <?php
            endforeach;
        }
    }
    ?>
</div>

<!-- 🔄 Lịch Sử Đọc Truyện -->
<h2>🔄 Lịch Sử Đọc Truyện</h2>
<div class="histor