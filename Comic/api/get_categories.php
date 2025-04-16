<?php
header('Content-Type: application/json');
include_once '../includes/db.php';
// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

function getCategoriesFromDB($conn) {
    $result = $conn->query("SELECT mangadex_tag_id, name FROM categories ORDER BY name ASC");
    $categories = [];

    while ($row = $result->fetch_assoc()) {
        $categories[] = [
            'id' => $row['mangadex_tag_id'],
            'name' => $row['name']
        ];
    }

    return $categories;
}

$check = $conn->query("SELECT COUNT(*) as total FROM categories");
$row = $check->fetch_assoc();
$hasData = $row['total'] > 0;

if ($hasData) {
    echo json_encode([
        'status' => 'success',
        'data' => getCategoriesFromDB($conn)
    ], JSON_PRETTY_PRINT);
    exit;
}

$apiUrl = "https://api.mangadex.org/manga/tag";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'ComicBase/1.0 (http://localhost; contact@example.com)');
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json']);

$tagJson = curl_exec($ch);
$curlError = curl_error($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($tagJson !== false && empty($curlError) && $httpCode === 200) {
    $tagData = json_decode($tagJson, true);

    if (isset($tagData['data']) && is_array($tagData['data'])) {
        $inserted = 0;

        foreach ($tagData['data'] as $tag) {
            $tagId = $tag['id'];
            $tagName = $tag['attributes']['name']['en'] ?? null;

            if ($tagName) {
                $stmt = $conn->prepare("SELECT id FROM categories WHERE mangadex_tag_id = ?");
                $stmt->bind_param("s", $tagId);
                $stmt->execute();
                $stmt->store_result();

                if ($stmt->num_rows === 0) {
                    $insert = $conn->prepare("INSERT INTO categories (mangadex_tag_id, name) VALUES (?, ?)");
                    $insert->bind_param("ss", $tagId, $tagName);
                    $insert->execute();
                    $insert->close();
                    $inserted++;
                }

                $stmt->close();
            }
        }
        echo json_encode([
            'status' => 'success',
            'message' => "Đã đồng bộ $inserted thể loại mới.",
            'data' => getCategoriesFromDB($conn)
        ], JSON_PRETTY_PRINT);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Cấu trúc phản hồi API không hợp lệ'
        ], JSON_PRETTY_PRINT);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Không thể kết nối MangaDex API: ' . $curlError . ' (HTTP Code: ' . $httpCode . ')'
    ], JSON_PRETTY_PRINT);
}
