<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "../includes/db.php";
include "../includes/header.php";


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

file_put_contents(__DIR__ . '/../logs/debug.log', "Chapter ID: $chapterId\nImage Server Data: " . print_r($imageServerData, true) . "\n\n", FILE_APPEND);


$imageUrls = [];
if (is_array($dataSaver) && !empty($dataSaver) && $baseUrl && $hash) {
    $imageUrls = array_map(function($filename) use ($baseUrl, $hash) {
        return "$baseUrl/data-saver/$hash/$filename";
    }, $dataSaver);
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đọc Truyện - ComicBase</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        .chapter-reader { max-width: 800px; margin: 0 auto; padding: 20px; text-align: center; }
        .chapter-reader h1 { font-size: 28px; margin-bottom: 10px; }
        .chapter-reader .title { font-size: 20px; color: #666; margin-bottom: 20px; }
        .chapter-reader .pages { font-size: 16px; color: #888; margin-bottom: 20px; }
        .chapter-reader .images { display: flex; flex-direction: column; gap: 10px; }
        .chapter-reader .images .page-image { width: 100%; border-radius: 5px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); }
        .navigation-buttons { display: flex; justify-content: space-between; margin-top: 20px; }
        .navigation-buttons button { background-color: #1e90ff; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-size: 16px; }
        .navigation-buttons button:hover { background-color: #0077cc; }
    </style>
</head>
<body>

<main class="chapter-reader">
    <h1>Chương <?php echo htmlspecialchars($chapterData['data']['attributes']['chapter'] ?? $chapterNumber ?: 'N/A'); ?></h1>
    <p class="title"><?php echo htmlspecialchars($chapterData['data']['attributes']['title'] ?? ''); ?></p>
    <p class="pages">Số trang: <?php echo htmlspecialchars($chapterData['data']['attributes']['pages'] ?? count($imageUrls)); ?></p>

    <div class="images">
        <?php
        if (!empty($imageUrls)) {
            foreach ($imageUrls as $index => $imageUrl) {
                echo "<img src='$imageUrl' alt='Page " . ($index + 1) . "' class='page-image' data-page='$index'>";
            }
        } else {
            echo "<p>No images available for this chapter. Check logs for details.</p>";
        }
        ?>
    </div>

    <div class="navigation-buttons">
        <button onclick="window.history.back()">Quay Lại</button>
        <button onclick="window.location.reload()">Tải Lại</button>
    </div>
</main>


<script>
    const chapterId = '<?php echo $chapterId; ?>';


    function saveReadingProgress() {
        const images = document.querySelectorAll('.page-image');
        if (images.length === 0) {
            console.error('No images to save progress for chapter:', chapterId);
            return;
        }

        let currentPage = 0;
        let maxVisibleHeight = 0;

        images.forEach((img, index) => {
            const rect = img.getBoundingClientRect();
            const visibleHeight = Math.min(rect.bottom, window.innerHeight) - Math.max(rect.top, 0);
            if (visibleHeight > maxVisibleHeight && visibleHeight > 0) {
                maxVisibleHeight = visibleHeight;
                currentPage = index;
            }
        });

        const progressKey = `readingProgress_${chapterId}`;
        const progress = { chapterId: chapterId, page: currentPage, timestamp: Date.now() };
        localStorage.setItem(progressKey, JSON.stringify(progress));
        console.log('Saved progress for chapter:', chapterId, 'at page:', currentPage);
    }


    function restoreReadingProgress() {
        const progressKey = `readingProgress_${chapterId}`;
        const progress = JSON.parse(localStorage.getItem(progressKey));
        if (!progress) {
            console.log('No saved progress found for chapter:', chapterId);
            return;
        }

        if (progress.chapterId === chapterId) {
            const pageIndex = progress.page;
            const images = document.querySelectorAll('.page-image');
            if (pageIndex < images.length && images[pageIndex]) {
                images[pageIndex].scrollIntoView({ behavior: 'smooth', block: 'start' });
                console.log('Restored to page:', pageIndex, 'for chapter:', chapterId);
            } else {
                console.error('Saved page index', pageIndex, 'invalid for', images.length, 'images');
            }
        } else {
            console.warn('Progress chapterId mismatch:', progress.chapterId, 'vs', chapterId);
        }
    }


    let timeout;
    window.addEventListener('scroll', () => {
        clearTimeout(timeout);
        timeout = setTimeout(saveReadingProgress, 250);
    });

    window.addEventListener('beforeunload', saveReadingProgress);


    window.addEventListener('load', () => {
        console.log('Page loaded for chapter:', chapterId, 'Image count:', document.querySelectorAll('.page-image').length);
        restoreReadingProgress();
    });


    document.addEventListener('DOMContentLoaded', () => {
        const images = document.querySelectorAll('.page-image');
        Promise.all(Array.from(images).map(img => {
            if (img.complete) return Promise.resolve();
            return new Promise(resolve => img.onload = resolve);
        })).then(() => {
            console.log('All images loaded, restoring progress for chapter:', chapterId);
            restoreReadingProgress();
        }).catch(err => console.error('Image load error:', err));
    });
</script>

</body>
</html>