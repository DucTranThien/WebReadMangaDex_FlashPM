<?php
session_start(); // Start session to store fetched manga batches
header('Content-Type: application/json');
include "../includes/db.php";

function fetchLatestFromMangaDex($limit = 50, $offset = 0) {
    $url = "https://api.mangadex.org/manga?" . http_build_query([
        'limit' => $limit,
        'offset' => $offset,
        'includedTagsMode' => 'AND',
        'excludedTagsMode' => 'OR',
        'contentRating' => ['safe', 'suggestive', 'erotica'],
        'order' => ['latestUploadedChapter' => 'desc'],
        'includes' => ['cover_art', 'author'] // Include author relationship
    ]);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)');
    curl_setopt($ch, CURLOPT_USERAGENT, 'ComicBase/1.0 (http://localhost; contact@example.com)');
    curl_setopt($ch, CURLOPT_VERBOSE, true);
    $verbose = fopen('php://temp', 'w+');
    curl_setopt($ch, CURLOPT_STDERR, $verbose);

    $response = curl_exec($ch);
    $error = curl_error($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    rewind($verbose);
    $verboseLog = stream_get_contents($verbose);
    fclose($verbose);
    curl_close($ch);

    if ($response === false || $httpCode !== 200) {
        return ['error' => "Failed to fetch MangaDex API: $error (HTTP $httpCode)", 'debug' => $verboseLog];
    }

    $data = json_decode($response, true);
    if (isset($data['result']) && $data['result'] === 'error') {
        return ['error' => $data['errors'][0]['detail'], 'debug' => $verboseLog];
    }

    $mangaList = [];
    foreach ($data['data'] as $manga) {
        $authorId = null;
        foreach ($manga['relationships'] as $rel) {
            if ($rel['type'] === 'author') {
                $authorId = $rel['id'];
                break;
            }
        }

        $mangaList[] = [
            'id' => $manga['id'],
            'name' => $manga['attributes']['title']['en'] ?? 'Unknown',
            'chapter' => $manga['attributes']['lastChapter'] ?? 'N/A',
            'newest_upload_date' => $manga['attributes']['updatedAt'] ?? null,
            'altTitles' => $manga['attributes']['altTitles'] ?? [], // Fixed: Removed ['ja-ro']
            'description' => $manga['attributes']['description']['en'] ?? 'No description available',
            'status' => $manga['attributes']['status'] ?? 'Unknown',
            'authorId' => $authorId
        ];
    }

    // Return $mangaList with a debug flag
    return ['status' => 'success', 'data' => $mangaList];
}

// Initialize session storage for manga batches
if (!isset($_SESSION['manga_batches'])) {
    $_SESSION['manga_batches'] = [];
}

// Get the requested page
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$perPage = 20; // Manga per page
$batchSize = 40; // Manga per API fetch
$batchIndex = floor(($page - 1) * $perPage / $batchSize); // Which batch we need
$offset = $batchIndex * $batchSize; // Offset for MangaDex API

// Check if we have the batch in session
if (!isset($_SESSION['manga_batches'][$batchIndex])) {
    // Fetch from local database first
    $query = "SELECT mangadex_id AS id, title AS name, latest_chapter AS chapter, newest_upload_date 
              FROM manga 
              ORDER BY newest_upload_date DESC 
              LIMIT $batchSize OFFSET $offset";
    $result = $conn->query($query);

    $localManga = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Add default values for fields not in DB
            $row['altTitles'] = [];
            $row['description'] = 'No description available';
            $row['status'] = 'Unknown';
            $row['authorId'] = null;
            $localManga[] = $row;
        }
    }

    // Supplement with MangaDex if needed
    $remaining = $batchSize - count($localManga);
    if ($remaining > 0) {
        $mangaDexData = fetchLatestFromMangaDex($remaining, $offset);
        if (isset($mangaDexData['error'])) {
            $_SESSION['manga_batches'][$batchIndex] = $localManga;
            $response = [
                'status' => 'error',
                'data' => $localManga,
                'message' => $mangaDexData['error'],
                'debug' => $mangaDexData['debug'] ?? 'No debug info'
            ];
            echo json_encode($response, JSON_PRETTY_PRINT);
            $conn->close();
            exit;
        } else {
            $localManga = array_merge($localManga, $mangaDexData['data']); // Updated to use $mangaDexData['data']
        }
    }

    // Store the batch in session
    $_SESSION['manga_batches'][$batchIndex] = $localManga;
}

// Get the current page's manga
$allManga = $_SESSION['manga_batches'][$batchIndex];
$startIndex = (($page - 1) * $perPage) % $batchSize;
$currentPageManga = array_slice($allManga, $startIndex, $perPage);

$response = [
    'status' => 'success',
    'data' => $currentPageManga,
    'page' => $page,
    'per_page' => $perPage, 
    'total_fetched' => count($allManga),
    'debug_manga_list' => $allManga // Include the full batch for debugging
];

echo json_encode($response, JSON_PRETTY_PRINT);
$conn->close();
?>