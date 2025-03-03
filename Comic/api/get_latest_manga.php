<?php
header('Content-Type: application/json');
include "../includes/db.php";

function fetchLatestFromMangaDex($limit = 6) {
    $url = "https://api.mangadex.org/manga?" . http_build_query([
        'limit' => $limit,
        'includedTagsMode' => 'AND',
        'excludedTagsMode' => 'OR',
        'contentRating' => ['safe', 'suggestive', 'erotica'],
        'order' => ['latestUploadedChapter' => 'desc'],
        'includes' => ['cover_art']
    ]);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'ComicBase/1.0 (http://localhost; contact@example.com)'); // Added User-Agent
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
        $mangaList[] = [
            'id' => $manga['id'],
            'name' => $manga['attributes']['title']['en'] ?? 'Unknown',
            'chapter' => $manga['attributes']['lastChapter'] ?? 'N/A',
            'newest_upload_date' => $manga['attributes']['updatedAt'] ?? null
        ];
    }
    return $mangaList;
}


$query = "SELECT mangadex_id AS id, title AS name, latest_chapter AS chapter, newest_upload_date 
          FROM manga 
          ORDER BY newest_upload_date DESC 
          LIMIT 6";
$result = $conn->query($query);

$localManga = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $localManga[] = $row;
    }
}


$remaining = 6 - count($localManga);
if ($remaining > 0) {
    $mangaDexData = fetchLatestFromMangaDex($remaining);
    if (isset($mangaDexData['error'])) {
        $response = [
            'status' => 'error',
            'data' => $localManga,
            'message' => $mangaDexData['error'],
            'debug' => $mangaDexData['debug'] ?? 'No debug info'
        ];
    } else {
        $localManga = array_merge($localManga, $mangaDexData);
        $response = ['status' => 'success', 'data' => array_slice($localManga, 0, 6)];
    }
} else {
    $response = ['status' => 'success', 'data' => $localManga];
}

echo json_encode($response, JSON_PRETTY_PRINT);
$conn->close();
?>