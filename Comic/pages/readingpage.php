<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database connection and header
include "../includes/db.php";
include "../includes/header.php";

// Function to fetch data from a URL using cURL
function fetchUrl($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'ComicBase/1.0 (http://localhost; contact@example.com)');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL verification for local testing
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        die("cURL Error: " . curl_error($ch));
    }
    curl_close($ch);
    return $response;
}

// Get the chapter ID from the URL
$chapterId = $_GET['chapter_id'] ?? '';
if (empty($chapterId)) {
    die("Chapter ID is required.");
}

// Fetch chapter details from MangaDex API
$chapterUrl = "https://api.mangadex.org/chapter/$chapterId";
$chapterResponse = fetchUrl($chapterUrl);

// Decode the chapter data
$chapterData = json_decode($chapterResponse, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    die("JSON Error: " . json_last_error_msg());
}

if (isset($chapterData['result']) && $chapterData['result'] === 'error') {
    die("API Error: " . $chapterData['errors'][0]['detail']);
}

// Fetch image URLs for the chapter
$imageServerUrl = "https://api.mangadex.org/at-home/server/$chapterId";
$imageServerResponse = fetchUrl($imageServerUrl);

// Decode the image server data
$imageServerData = json_decode($imageServerResponse, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    die("JSON Error: " . json_last_error_msg());
}

if (isset($imageServerData['result']) && $imageServerData['result'] === 'error') {
    die("API Error: " . $imageServerData['errors'][0]['detail']);
}

// Extract base URL, hash, and dataSaver
$baseUrl = $imageServerData['baseUrl'];
$hash = $imageServerData['chapter']['hash'];
$dataSaver = $imageServerData['chapter']['dataSaver']; // Use 'data' for full-quality images

// Build image URLs
$imageUrls = array_map(function($filename) use ($baseUrl, $hash) {
    return "$baseUrl/data-saver/$hash/$filename";
}, $dataSaver);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đọc Truyện - ComicBase</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        /* Chapter Reader Styles */
        .chapter-reader {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
        }

        .chapter-reader h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .chapter-reader .title {
            font-size: 20px;
            color: #666;
            margin-bottom: 20px;
        }

        .chapter-reader .pages {
            font-size: 16px;
            color: #888;
            margin-bottom: 20px;
        }

        .chapter-reader .images {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .chapter-reader .images .page-image {
            width: 100%;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Navigation Buttons */
        .navigation-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .navigation-buttons button {
            background-color: #1e90ff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .navigation-buttons button:hover {
            background-color: #0077cc;
        }
    </style>
</head>
<body>

<main class="chapter-reader">
    <h1>Chương <?php echo htmlspecialchars($chapterData['data']['attributes']['chapter'] ?? 'N/A'); ?></h1>
    <p class="title"><?php echo htmlspecialchars($chapterData['data']['attributes']['title'] ?? ''); ?></p>
    <p class="pages">Số trang: <?php echo htmlspecialchars($chapterData['data']['attributes']['pages'] ?? 'N/A'); ?></p>

    <div class="images">
        <?php
        foreach ($imageUrls as $imageUrl) {
            echo "<img src='$imageUrl' alt='Page' class='page-image'>";
        }
        ?>
    </div>

    <!-- Navigation Buttons -->
    <div class="navigation-buttons">
        <button onclick="window.history.back()">Quay Lại</button>
        <button onclick="window.location.reload()">Tải Lại</button>
    </div>
</main>

</body>
</html>