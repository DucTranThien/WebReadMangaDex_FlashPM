<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $baseUrl = "https://api.mangadex.org/manga";
    $params = [];

    // Title
    if (!empty($_GET['title'])) {
        $params['title'] = $_GET['title'];
    }

    // Genres (thể loại) – bạn dùng tên genre, mình sẽ map sang ID (nếu cần bạn có file map genre name -> id không thì gửi mình)
    if (!empty($_GET['genres']) && is_array($_GET['genres'])) {
        // ⚠️ Đang dùng tên thể loại như "Action", nếu bạn muốn dùng ID thì cần map tên → id
        $params['includedTags[]'] = $_GET['genres']; // MangaDex cần Tag ID, bạn cần map genre name → tagId nếu chưa
    }

    // Status – MangaDex chỉ hiểu: ongoing, completed, cancelled, hiatus
    if (!empty($_GET['status'])) {
        $params['status[]'] = $_GET['status'];
    }

    // Order
    if (!empty($_GET['order'])) {
        $params["order[" . $_GET['order'] . "]"] = "desc";
    }

    // Default includes
    $params['limit'] = 20;
    $params['includes[]'] = 'cover_art';
    $params['availableTranslatedLanguage[]'] = 'en';

    // Build URL
    $query = http_build_query($params);
    $url = "$baseUrl?$query";

    // Gọi API bằng cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'User-Agent: ComicSearch/1.0'
    ]);

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
?>
