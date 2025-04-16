<?php

ini_set('max_execution_time', 300);
header("Content-Type: application/json");
$limit = 100; 

function fetchJson($url) {
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_USERAGENT => 'MangaRankingBot/1.0',
        CURLOPT_TIMEOUT => 10
    ]);
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}


$url = "https://api.mangadex.org/manga?limit=$limit&order[followedCount]=desc&includes[]=cover_art&availableTranslatedLanguage[]=en";
$mangaRes = fetchJson($url);
if (!$mangaRes || !isset($mangaRes['data'])) {
    echo json_encode(['error' => 'Không lấy được danh sách manga.']);
    exit;
}

$results = [];
foreach ($mangaRes['data'] as $manga) {
    $id = $manga['id'];
    $title = $manga['attributes']['title']['en'] ?? 'Unknown';
    $updatedAt = $manga['attributes']['updatedAt'] ?? null;
    $latestChapterId = $manga['attributes']['latestUploadedChapter'] ?? null;

    // Cover
    $coverFile = 'no-cover.jpg';
    foreach ($manga['relationships'] as $rel) {
        if ($rel['type'] === 'cover_art') {
            $coverFile = $rel['attributes']['fileName'];
            break;
        }
    }
    $coverUrl = "https://uploads.mangadex.org/covers/$id/$coverFile.256.jpg";

   
    $statUrl = "https://api.mangadex.org/statistics/manga/$id";
    $statData = fetchJson($statUrl);
    $stats = $statData['statistics'][$id] ?? [];

    $rating = round($stats['rating']['average'] ?? 0, 2);
    $follows = $stats['follows'] ?? 0;
    $likes = $stats['reactions']['👍'] ?? 0;

    
    $chapterTitle = '';
    $chapterNumber = '';
    if ($latestChapterId) {
        $chapterRes = fetchJson("https://api.mangadex.org/chapter/$latestChapterId");
        if ($chapterRes && isset($chapterRes['data']['attributes'])) {
            $chapterTitle = $chapterRes['data']['attributes']['title'] ?? '';
            $chapterNumber = $chapterRes['data']['attributes']['chapter'] ?? '';
        }
    }

    $results[] = [
        'id' => $id,
        'title' => $title,
        'rating' => $rating,
        'followed' => $follows,
        'likes' => $likes,
        'latest_chapter' => $latestChapterId ?? '??',
        'chapter_number' => $chapterNumber,
        'chapter_title' => $chapterTitle,
        'updatedAt' => $updatedAt,
        'cover' => $coverUrl
    ];

    // Sleep nhẹ để tránh rate-limit
    usleep(200000); // 0.2 giây
}

$savePath = __DIR__ . '/popular_manga.json';
$success = file_put_contents($savePath, json_encode($results, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

if ($success === false) {
    echo json_encode(['error' => 'Không thể ghi vào popular_manga.json tại ' . $savePath]);
} else {
    echo json_encode([
        'result' => 'ok',
        'total' => count($results),
        'message' => 'popular_manga.json đã được cập nhật tại ' . $savePath
    ]);
}
