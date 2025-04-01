<?php
if (!isset($_SESSION)) session_start();
include_once __DIR__ . '/../includes/db.php';

$userId = $_SESSION['user_id'] ?? null;
$history_result = null;

if ($userId) {
    $stmt = $conn->prepare("SELECT manga_id, title, cover_url, last_read, chapter_id, title 
                        FROM reading_history 
                        WHERE user_id = ? 
                        ORDER BY last_read DESC 
                        LIMIT 10");

    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $history_result = $stmt->get_result();
}
?>

<style>
.history-horizontal {
    display: flex;
    overflow-x: auto;
    gap: 16px;
    padding: 10px 0;
}

.history-horizontal::-webkit-scrollbar {
    height: 8px;
}
.history-horizontal::-webkit-scrollbar-thumb {
    background-color: #555;
    border-radius: 4px;
}

.manga-card {
    min-width: 140px;
    background-color: #222;
    border-radius: 10px;
    padding: 10px;
    text-align: center;
    flex-shrink: 0;
    box-shadow: 0 4px 10px rgba(0,0,0,0.3);
}

.manga-card img {
    width: 100%;
    height: 180px;
    object-fit: cover;
    border-radius: 6px;
    margin-bottom: 6px;
}

.manga-card .title {
    font-weight: bold;
    font-size: 14px;
    color: #ffcc00;
    margin-bottom: 4px;
}

.manga-card .time {
    font-size: 12px;
    color: #ccc;
}
</style>

<div class="reading-history-section">   
    <?php if ($history_result && $history_result->num_rows > 0): ?>
        <div class="history-horizontal">
            <?php while ($row = $history_result->fetch_assoc()): ?>
                <div class="manga-card">
                <a href="/Comic/pages/readingpage.php?mangadex_id=<?= $row['manga_id'] ?>&chapter_id=<?= $row['chapter_id'] ?>">
                    <img src="<?= htmlspecialchars($row['cover_url']) ?>" alt="cover">
                    <p class="title"><?= htmlspecialchars($row['title']) ?></p>
                    <p class="time">🕒 <?= date("d/m/Y H:i", strtotime($row['last_read'])) ?></p>
                </a>

                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p>Chưa có truyện nào được đọc gần đây.</p>
    <?php endif; ?>
</div>
