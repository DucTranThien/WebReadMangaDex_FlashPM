<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
date_default_timezone_set('Asia/Ho_Chi_Minh');

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
$jwt = new JWTHandler();
$token = $_COOKIE[  'jwt_token'] ?? '';
$decoded = $jwt->decodeToken($token);
$user_id = $_SESSION["user_id"];
$username = $decoded->data->username ?? null;
$chapterId = $_GET['chapter_id'] ?? '';
$mangadexId = $_GET['mangadex_id'] ?? '';

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
$chapterNumber = $chapterData['data']['attributes']['chapter'] 
    ?? ($_GET['chapter'] ?? 'N/A');

//lưu lịch sử
if ($user_id && $mangadexId && $chapterId) {
    //lấy thông tin truyện từ API
    $mangaInfoUrl = "https://api.mangadex.org/manga/$mangadexId?includes[]=cover_art";
    $mangaResponse = fetchUrl($mangaInfoUrl);
    $mangaData = json_decode($mangaResponse, true);

    if (isset($mangaData['data'])) {
        $title = $mangaData['data']['attributes']['title']['en']
            ?? $mangaData['data']['attributes']['title']['ja-ro']
            ?? $mangaData['data']['attributes']['title']['ko']
            ?? 'Không rõ tên';

        $coverFile = null;
        foreach ($mangaData['data']['relationships'] as $rel) {
            if ($rel['type'] === 'cover_art') {
                $coverFile = $rel['attributes']['fileName'] ?? null;
                break;
            }
        }

        $coverUrl = $coverFile
            ? "https://uploads.mangadex.org/covers/$mangadexId/$coverFile.256.jpg"
            : "https://mangadex.org/img/cover-placeholder.png";

        $chapterTitle = "Chương $chapterNumber";
        $now = date('Y-m-d H:i:s');
        

        //kiểm tra đã có trong bảng chưa
        $stmt = $conn->prepare("SELECT id FROM reading_history WHERE user_id = ? AND manga_id = ?");
        $stmt->bind_param("is", $user_id, $mangadexId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            //update nếu đã có
            $stmt = $conn->prepare("UPDATE reading_history SET chapter_id = ?, title = ?, cover_url = ?, last_read = ? WHERE user_id = ? AND manga_id = ?");
            $stmt->bind_param("ssssis", $chapterId, $chapterTitle, $coverUrl, $now, $user_id, $mangadexId);
        } else {
            //insert nếu chưa có
            $stmt = $conn->prepare("INSERT INTO reading_history (user_id, manga_id, title, cover_url, last_read, chapter_id) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("isssss", $user_id, $mangadexId, $chapterTitle, $coverUrl, $now, $chapterId);
        }

        $stmt->execute();
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đọc Truyện - MangaFlashPM</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .chapter-reader { max-width: 800px; margin: 0 auto; padding: 20px; text-align: center;padding-bottom: 70px; }
        .chapter-reader h1 { font-size: 28px; margin-bottom: 10px; }
        .chapter-reader .title { font-size: 20px; color: #666; margin-bottom: 20px; }
        .chapter-reader .pages { font-size: 16px; color: #888; margin-bottom: 20px; }
        .chapter-reader .images { display: flex; flex-direction: column; gap: 10px; }
        .chapter-reader .images .page-image { width: 100%; border-radius: 5px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); }
        .chapter-nav { margin: 20px auto; display: flex; justify-content: center; align-items: center; gap: 15px; }
        .chapter-nav select, .chapter-nav a { padding: 10px; font-size: 16px; border-radius: 5px; border: 1px solid #ccc; text-decoration: none; }
        .no-content { text-align: center; background-color: #fff3cd; color: #856404; padding: 30px; margin: 20px auto; border-radius: 8px; border: 1px solid #ffeeba; max-width: 700px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
    
        .chapter-nav-fixed {
            position: fixed;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            background: #1f1f1f;
            padding: 8px 16px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.4);
            z-index: 999;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            min-width: 320px;
            max-width: 600px;
            opacity: 0.95;
        }
        .chapter-btn {
            color: white;
        }

        .chapter-nav-fixed a.chapter-btn,
        .chapter-nav-fixed select {
            padding: 8px 14px;
            font-size: 14px;
            border-radius: 8px;
            background-color: #292929;
            color: #eee;
            border: 1px solid #444;
            transition: 0.2s ease;
            text-decoration: none;
            min-width: 110px;
            text-align: center;
        }

        .chapter-nav-fixed a.chapter-btn:hover,
        .chapter-nav-fixed select:hover {
            background-color:rgb(88, 108, 161);
            color: white;
            border-color:rgb(88, 108, 161);
            cursor: pointer;
        }

        .chapter-nav-fixed select {
            appearance: none;
            background-image: url('data:image/svg+xml;utf8,<svg fill="%23aaa" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/></svg>');
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 16px;
            padding-right: 30px;
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
            <a href="?chapter_id=<?= $prevChapter ?>&mangadex_id=<?= $mangadexId ?>" class="chapter-btn" 
   style="color: white;">⬅️ Chương trước</a>
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
            <a href="?chapter_id=<?= $nextChapter ?>&mangadex_id=<?= $mangadexId ?>"class="chapter-btn"style="color: white;">Chương sau ➡️</a>
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
//ghi nhớ trang đã đọc trong localStorage
const chapterId = "<?= $chapterId ?>";
const pageImages = document.querySelectorAll('.page-image');

//khi cuộn, lưu lại trang đang xem
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

//khi load lại trang, cuộn về trang đã đọc
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
<script>
document.addEventListener('DOMContentLoaded', () => {
    const payload = {
        chapter_id: <?= json_encode($chapterId) ?>,
        mangadex_id: <?= json_encode($mangadexId) ?>,
        chapter_number: <?= json_encode($chapterNumber) ?>
    };
    

    fetch('/Comic/api/save_history.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(payload)
    })
    .then(res => res.json())
});
</script>

</body>
</html>
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