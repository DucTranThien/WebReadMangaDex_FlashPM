<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $baseUrl = "https://api.mangadex.org/manga";

    $queryParts = [];

    // Title
    if (!empty($_GET['title'])) {
        $queryParts[] = 'title=' . urlencode($_GET['title']);
    }
    
    // Status
    if (!empty($_GET['status'])) {
        $queryParts[] = 'status[]=' . urlencode($_GET['status']);
    }

    // Genres (as includedTags[])
    if (!empty($_GET['genres']) && is_array($_GET['genres'])) {
        foreach ($_GET['genres'] as $tagId) {
            $queryParts[] = 'includedTags[]=' . urlencode($tagId);
        }
        $queryParts[] = 'includedTagsMode=OR'; // OR hoặc AND
    }

    // Order
    if (!empty($_GET['order'])) {
        $orderKey = urlencode($_GET['order']);
        $queryParts[] = "order[$orderKey]=desc";
    }

    // Offset & Limit
    $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
    $queryParts[] = 'offset=' . $offset;
    $queryParts[] = 'limit=30';

    // Includes & Language
    $queryParts[] = 'includes[]=cover_art';
    $queryParts[] = 'availableTranslatedLanguage[]=en';

    // Final URL
    $url = $baseUrl . '?' . implode('&', $queryParts);


    // Gọi API
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['User-Agent: ComicSearch/1.0']);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode !== 200 || !$response) {
        http_response_code(500);
        echo json_encode(["error" => "Không thể lấy dữ liệu từ MangaDex", "debug_url" => $url]);
        exit;
    }

    echo $response;
} else {
    http_response_code(405);
    echo json_encode(["error" => "Phương thức không hợp lệ"]);
}
