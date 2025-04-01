<?php
// fetch_popular_manga.php - Tối ưu hiệu suất

$cacheFile = __DIR__ . '/cache/popular_manga.json';
$cacheTime = 900; // 15 phút

// Nếu cache tồn tại và còn hiệu lực → load từ cache
if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) < $cacheTime) {
    $output = json_decode(file_get_contents($cacheFile), true);
    echo json_encode($output);
    exit;
}

// Nếu không có cache → gọi API
$baseUrl = "https://api.mangadex.org";
$userAgent = 'MangaFlashPM/1.0 (+http://localhost)';
$limit = 10;

// Gọi danh sách manga phổ biến
$popularUrl = "$baseUrl/manga?order[followedCount]=desc&limit=$limit&includes[]=cover_art&includes[]=author&contentRating[]=safe";
$context = stream_context_create(['http' => ['header' => "User-Agent: $userAgent"]]);
$response = file_get_contents($popularUrl, false, $context);
$data = json_decode($response, true);

$popular = [];
$mangaIds = [];

foreach ($data['data'] as $manga) {
    $id = $manga['id'];
    $attributes = $manga['attributes'];
    $title = $attributes['title']['en'] ?? 'No Title';
    $description = $attributes['description']['en'] ?? '';
    $status = $attributes['status'];
    $year = $attributes['year'] ?? '';
    $tags = array_map(fn($t) => $t['attributes']['name']['en'] ?? '', $manga['attributes']['tags']);
    
    // Cover
    $cover = '';
    foreach ($manga['relationships'] as $rel) {
        if ($rel['type'] === 'cover_art') {
            $cover = "https://uploads.mangadex.org/covers/{$id}/{$rel['attributes']['fileName']}.256.jpg";
            break;
        }
    }

    // Author
    $author = '';
    foreach ($manga['relationships'] as $rel) {
        if ($rel['type'] === 'author') {
            $author = $rel['attributes']['name'] ?? '';
            break;
        }
    }

    $popular[$id] = [
        'id' => $id,
        'title' => $title,
        'description' => $description,
        'status' => $status,
        'year' => $year,
        'cover' => $cover,
        'author' => $author,
        'tags' => $tags,
        'followed' => 0,
        'rating' => 0
    ];
    $mangaIds[] = $id;
}

// Gọi API statistics một lần cho tất cả manga
$statUrl = $baseUrl . '/statistics/manga?' . http_build_query(['ids[]' => $mangaIds]);
$statResponse = file_get_contents($statUrl, false, $context);
$stats = json_decode($statResponse, true);

foreach ($stats['statistics'] as $id => $stat) {
    $popular[$id]['followed'] = $stat['follows'] ?? 0;
    $popular[$id]['rating'] = $stat['rating']['average'] ?? 0;

}

// Lưu vào cache
file_put_contents($cacheFile, json_encode(array_values($popular)));

// Trả về dữ liệu
header('Content-Type: application/json');
echo json_encode(array_values($popular));
?>
