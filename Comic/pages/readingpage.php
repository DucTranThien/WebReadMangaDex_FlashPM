<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "../includes/db.php";
include "../includes/header.php";
require_once '../includes/JWTHandler.php';

function fetchUrl($url, $maxRetries = 3, $retryDelay = 2) {
    $attempt = 0;
    $ch = curl_init();

    while ($attempt < $maxRetries) {
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'ComicBase/1.0 (http://localhost; contact@example.com)');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); 
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); 
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch) === 0 && $httpCode === 200) {
            curl_close($ch);
            return $response;
        }

        $error = curl_error($ch);
        $attempt++;
        file_put_contents(__DIR__ . '/../logs/curl_errors.log', "Attempt $attempt failed for $url: $error (HTTP $httpCode)\n", FILE_APPEND);

        if ($attempt < $maxRetries) {
            sleep($retryDelay); 
        }
    }

    curl_close($ch);
    die("cURL Error after $maxRetries attempts: $error for URL: $url (HTTP $httpCode)");
}

$chapterId = $_GET['chapter_id'] ?? '';
$mangadexId = $_GET['mangadex_id'] ?? '';
$chapterNumber = $_GET['chapter'] ?? '';

if (empty($chapterId)) {
    die("Error: Chapter ID is required. URL parameters: " . htmlspecialchars(print_r($_GET, true)));
}

$chapterUrl = "https://api.mangadex.org/chapter/$chapterId";
$chapterResponse = fetchUrl($chapterUrl);
$chapterData = json_decode($chapterResponse, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    die("JSON Error decoding chapter data: " . json_last_error_msg() . "<br>Raw response: " . htmlspecialchars($chapterResponse));
}

if (isset($chapterData['result']) && $chapterData['result'] === 'error') {
    die("Chapter API Error: " . ($chapterData['errors'][0]['detail'] ?? 'Unknown error') . "<br>Raw response: " . htmlspecialchars($chapterResponse));
}

$imageServerUrl = "https://api.mangadex.org/at-home/server/$chapterId";
$imageServerResponse = fetchUrl($imageServerUrl);
$imageServerData = json_decode($imageServerResponse, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    die("JSON Error decoding image server data: " . json_last_error_msg() . "<br>Raw response: " . htmlspecialchars($imageServerResponse));
}

if (isset($imageServerData['result']) && $imageServerData['result'] === 'error') {
    die("Image Server API Error: " . ($imageServerData['errors'][0]['detail'] ?? 'Unknown error') . "<br>Raw response: " . htmlspecialchars($imageServerResponse));
}

$baseUrl = $imageServerData['baseUrl'] ?? '';
$hash = $imageServerData['chapter']['hash'] ?? '';
$dataSaver = $imageServerData['chapter']['dataSaver'] ?? [];

$imageUrls = [];
if (is_array($dataSaver) && !empty($dataSaver) && $baseUrl && $hash) {
    $imageUrls = array_map(function($filename) use ($baseUrl, $hash) {
        return "$baseUrl/data-saver/$hash/$filename";
    }, $dataSaver);
}

$chapterListUrl = "https://api.mangadex.org/manga/$mangadexId/feed?translatedLanguage[]=en&order[chapter]=asc&limit=500";
$chapterListResponse = fetchUrl($chapterListUrl);
$chapterListData = json_decode($chapterListResponse, true);
$allChapters = $chapterListData['data'] ?? [];
$currentIndex = array_search($chapterId, array_column($allChapters, 'id'));
$prevChapter = $allChapters[$currentIndex - 1]['id'] ?? null;
$nextChapter = $allChapters[$currentIndex + 1]['id'] ?? null;

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đọc Truyện - MangaFlashPM</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .chapter-reader { max-width: 800px; margin: 0 auto; padding: 20px; text-align: center; }
        .chapter-reader h1 { font-size: 28px; margin-bottom: 10px; }
        .chapter-reader .title { font-size: 20px; color: #666; margin-bottom: 20px; }
        .chapter-reader .pages { font-size: 16px; color: #888; margin-bottom: 20px; }
        .chapter-reader .images { display: flex; flex-direction: column; gap: 10px; }
        .chapter-reader .images .page-image { width: 100%; border-radius: 5px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); }
        .chapter-nav { margin: 20px auto; display: flex; justify-content: center; align-items: center; gap: 15px; }
        .chapter-nav select, .chapter-nav a { padding: 10px; font-size: 16px; border-radius: 5px; border: 1px solid #ccc; text-decoration: none; }
        .no-content { text-align: center; background-color: #fff3cd; color: #856404; padding: 30px; margin: 20px auto; border-radius: 8px; border: 1px solid #ffeeba; max-width: 700px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
    
        .chapter-nav-fixed {
    position: sticky;
    top: 0;
    background: #1a1a1a;
    z-index: 999;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 15px;
    padding: 12px 0;
    border-bottom: 1px solid #333;
    box-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

.chapter-nav-fixed select,
.chapter-nav-fixed a.chapter-btn {
    padding: 8px 14px;
    font-size: 14px;
    border-radius: 6px;
    border: 1px solid #444;
    background: #222;
    color: #fff;
    text-decoration: none;
}

.chapter-nav-fixed a.chapter-btn:hover,
.chapter-nav-fixed select:hover {
    background: #333;
}

    </style>
</head>
<body>

<main class="chapter-reader">
    <h1>Chương <?= htmlspecialchars($chapterData['data']['attributes']['chapter'] ?? $chapterNumber ?: 'N/A') ?></h1>
    <p class="title"><?= htmlspecialchars($chapterData['data']['attributes']['title'] ?? '') ?></p>
    <p class="pages">Số trang: <?= htmlspecialchars($chapterData['data']['attributes']['pages'] ?? count($imageUrls)) ?></p>

    <div class="chapter-nav-fixed">
    <div class="chapter-nav">
        <?php if ($prevChapter): ?>
            <a href="?chapter_id=<?= $prevChapter ?>&mangadex_id=<?= $mangadexId ?>">⬅️ Chương trước</a>
        <?php endif; ?>

        <select onchange="location.href=this.value">
            <?php foreach ($allChapters as $ch):
                $cid = $ch['id'];
                $label = $ch['attributes']['chapter'] ?? 'Chương ?';
                $selected = $cid === $chapterId ? 'selected' : '';
            ?>
                <option value="?chapter_id=<?= $cid ?>&mangadex_id=<?= $mangadexId ?>" <?= $selected ?>>
                    Chương <?= htmlspecialchars($label) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <?php if ($nextChapter): ?>
            <a href="?chapter_id=<?= $nextChapter ?>&mangadex_id=<?= $mangadexId ?>">Chương sau ➡️</a>
        <?php endif; ?>
    </div>
</div>

    <div class="images">
        <?php if (!empty($imageUrls)): ?>
            <?php foreach ($imageUrls as $index => $imageUrl): ?>
                <img src="<?= $imageUrl ?>" alt="Page <?= $index + 1 ?>" class="page-image" data-page="<?= $index ?>">
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-content">
                <h2>📭 Không có hình ảnh cho chương này</h2>
                <p>Rất tiếc, chương bạn chọn hiện chưa có nội dung hình ảnh hiển thị.</p>
                <p>Chương này có thể đang cập nhật hoặc chưa khả dụng. Vui lòng quay lại hoặc thử chương khác.</p>
            </div>
        <?php endif; ?>
    </div>
</main>

<script>
// Ghi nhớ trang đã đọc trong localStorage
const chapterId = "<?= $chapterId ?>";
const pageImages = document.querySelectorAll('.page-image');

// Khi cuộn, lưu lại trang đang xem
window.addEventListener('scroll', () => {
    for (let i = pageImages.length - 1; i >= 0; i--) {
        const img = pageImages[i];
        const rect = img.getBoundingClientRect();
        if (rect.top < window.innerHeight * 0.5) {
            localStorage.setItem('readPage_' + chapterId, i);
            break;
        }
    }
});

// Khi load lại trang, cuộn về trang đã đọc
window.addEventListener('load', () => {
    const savedPage = localStorage.getItem('readPage_' + chapterId);
    if (savedPage !== null) {
        const targetImg = document.querySelector(`.page-image[data-page='${savedPage}']`);
        if (targetImg) {
            setTimeout(() => {
                targetImg.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 500);
        }
    }
});
</script>

</body>
</html>
