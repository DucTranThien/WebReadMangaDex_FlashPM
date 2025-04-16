<?php
header('Content-Type: application/json');
include '../includes/db.php';

// Gọi API MangaDex
$url = "https://api.mangadex.org/manga/tag";
$options = [
    "http" => [
        "method" => "GET",
        "header" => "User-Agent: ComicBase/1.0\r\nAccept: application/json\r\n"
    ]
];
$context = stream_context_create($options);
$response = file_get_contents($url, false, $context);

if ($response === false) {
    echo json_encode(['status' => 'error', 'message' => 'Không thể kết nối API MangaDex']);
    exit;
}

$data = json_decode($response, true);
if (!isset($data['data'])) {
    echo json_encode(['status' => 'error', 'message' => 'Dữ liệu trả về không hợp lệ']);
    exit;
}

$inserted = 0;
foreach ($data['data'] as $tag) {
    $id = $tag['id'];
    $name = $tag['attributes']['name']['en'] ?? null;
    if (!$id || !$name) continue;

    // Chèn lại nếu đã xóa trước đó
    $stmt = $conn->prepare("INSERT INTO categories (name, mangadex_tag_id) 
                            VALUES (?, ?) 
                            ON DUPLICATE KEY UPDATE name = VALUES(name)");
    $stmt->bind_param("ss", $name, $id);
    if ($stmt->execute()) {
        $inserted++;
    }
    $stmt->close();
}

echo json_encode([
    'status' => 'success',
    'inserted_or_updated' => $inserted,
    'total_tags_from_api' => count($data['data'])
], JSON_PRETTY_PRINT);
