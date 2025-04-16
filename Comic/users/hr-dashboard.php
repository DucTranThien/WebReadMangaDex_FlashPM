<?php
if (!isset($_SESSION)) session_start();
include_once __DIR__ . '/../includes/db.php';

$userId = $_SESSION['user_id'] ?? null;
$history_result = null;

$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$limit = 10;
$offset = ($page - 1) * $limit;
$totalPages = 1;

if ($userId) {
    $countStmt = $conn->prepare("SELECT COUNT(*) FROM reading_history WHERE user_id = ?");
    $countStmt->bind_param("i", $userId);
    $countStmt->execute();
    $countStmt->bind_result($totalRecords);
    $countStmt->fetch();
    $countStmt->close();

    $totalPages = ceil($totalRecords / $limit);

    $stmt = $conn->prepare("SELECT manga_id, title, cover_url, last_read, chapter_id 
                            FROM reading_history 
                            WHERE user_id = ? 
                            ORDER BY last_read DESC 
                            LIMIT ? OFFSET ?");
    $stmt->bind_param("iii", $userId, $limit, $offset);
    $stmt->execute();
    $history_result = $stmt->get_result();
}
?>

<style>
.reading-history-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 20px;
    padding: 20px 10px;
}
.manga-card {
    background-color: #222;
    border-radius: 10px;
    padding: 10px;
    text-align: center;
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
.pagination {
    text-align: center;
    margin: 20px 0;
}
.pagination a {
    display: inline-block;
    margin: 0 4px;
    padding: 6px 12px;
    background-color: #333;
    color: #fff;
    border-radius: 4px;
    text-decoration: none;
}
.pagination a.active {
    background-color: #ffcc00;
    color: #000;
    font-weight: bold;
}
</style>

<div class="reading-history-section">
    <?php if ($history_result && $history_result->num_rows > 0): ?>
        <div class="reading-history-grid">
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

        <?php if ($totalPages > 1): ?>
            <div class="pagination">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?page=<?= $i ?>" class="<?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <p style="padding: 15px;">Chưa có truyện nào được đọc gần đây.</p>
    <?php endif; ?>
</div>
