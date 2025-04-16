<?php
include_once __DIR__ . '/../includes/db.php';

if (!isset($_SESSION['user_id']) && isset($_COOKIE['jwt_token'])) {
    require_once __DIR__ . '/../includes/JWTHandler.php';
    $decoded = JWTHandler::decodeToken($_COOKIE['jwt_token']);
    if ($decoded && isset($decoded->user_id)) {
        $_SESSION['user_id'] = $decoded->user_id;
        $_SESSION['username'] = $decoded->username;
        $_SESSION['email'] = $decoded->email;
        $_SESSION['avatar_url'] = $decoded->avatar_url ?? '';
        $_SESSION['login_method'] = $decoded->login_method ?? 'manual';
    }
}

$userId = $_SESSION['user_id'] ?? null;
if ($userId):
    $stmt = $conn->prepare("SELECT manga_id, title, cover_url, last_read, chapter_id, title 
                        FROM reading_history 
                        WHERE user_id = ? 
                        ORDER BY last_read DESC 
                        LIMIT 3");

    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
?>
<style>
    
    .history-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
    max-height: none !important;
    overflow-y: auto;
    padding-right: 10px;
}

    .history-item {
        background-color: #1f1f1f;
        padding: 12px;
        border-radius: 8px;
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 15px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.3);
        transition: background 0.3s;
    }

    .history-item:hover {
        background-color: #2a2a2a;
    }

    .history-cover {
        width: 80px;
        height: 110px;
        border-radius: 6px;
        object-fit: cover;
        flex-shrink: 0;
    }

    .history-content {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .history-content .title {
        color: #4db8ff;
        font-weight: bold;
        font-size: 16px;
        margin: 0 0 6px 0;
    }

    .history-content .time {
        color: #ccc;
        font-size: 14px;
    }

    .history-item a {
        display: flex;
        align-items: center;
        color: inherit;
        text-decoration: none;
        gap: 15px;
        width: 100%;
    }
</style>

<h2>🕓 Lịch sử đọc gần đây</h2>
<?php if ($result->num_rows > 0): ?>
    <div class="history-list">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="history-item">
                <a href="/Comic/pages/readingpage.php?mangadex_id=<?= $row['manga_id'] ?>&chapter_id=<?= $row['chapter_id'] ?>">
                    <img src="<?= htmlspecialchars($row['cover_url']) ?>" alt="cover" class="history-cover">
                    <div class="history-content">
                        <p class="title"><?= htmlspecialchars($row['title']) ?></p>
                        <p class="time">🕒 <?= date("d/m/Y H:i", strtotime($row['last_read'])) ?></p>
                    </div>
                </a>
            </div>
        <?php endwhile; ?>
    </div>
<?php else: ?>
    <p>Chưa có truyện nào.</p>
<?php endif; ?>



<?php endif; ?>
