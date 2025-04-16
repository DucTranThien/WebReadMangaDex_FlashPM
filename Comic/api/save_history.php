<?php
header('Content-Type: application/json');

include "../includes/db.php";
require_once "../includes/JWTHandler.php";
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Lấy user từ JWT
$jwt = new JWTHandler();
$token = $_COOKIE['jwt_token'] ?? '';
try {
    $decoded = $jwt->decodeToken($token);
    $user_id = $decoded->data->user_id ?? null;
} catch (Exception $e) {
    echo json_encode(["status" => "fail", "message" => "JWT không hợp lệ"]);
    exit;
}

$input = json_decode(file_get_contents("php://input"), true);
$mangadexId = $input['mangadex_id'] ?? '';
$chapterId = $input['chapter_id'] ?? '';
$chapterNumber = $input['chapter_number'] ?? 'N/A';

if (!$user_id || !$mangadexId || !$chapterId) {
    echo json_encode(["status" => "fail", "message" => "Thiếu thông tin"]);
    exit;
}

// Lấy thông tin manga từ API
$mangaInfoUrl = "https://api.mangadex.org/manga/$mangadexId?includes[]=cover_art";
$mangaResponse = file_get_contents($mangaInfoUrl);
$mangaData = json_decode($mangaResponse, true);

$title = $mangaData['data']['attributes']['title']['en']
    ?? $mangaData['data']['attributes']['title']['ja-ro']
    ?? 'Không rõ tên';

$coverFile = '';
foreach ($mangaData['data']['relationships'] as $rel) {
    if ($rel['type'] === 'cover_art') {
        $coverFile = $rel['attributes']['fileName'] ?? '';
        break;
    }
}

$coverUrl = $coverFile
    ? "https://uploads.mangadex.org/covers/$mangadexId/$coverFile.256.jpg"
    : "https://mangadex.org/img/cover-placeholder.png";

$chapterTitle = "Chương $chapterNumber";
$now = date('Y-m-d H:i:s');

// Cập nhật hoặc thêm mới
$stmt = $conn->prepare("SELECT id FROM reading_history WHERE user_id = ? AND manga_id = ?");
$stmt->bind_param("is", $user_id, $mangadexId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $stmt = $conn->prepare("UPDATE reading_history SET chapter_id = ?, title = ?, cover_url = ?, last_read = ? WHERE user_id = ? AND manga_id = ?");
    $stmt->bind_param("ssssis", $chapterId, $chapterTitle, $coverUrl, $now, $user_id, $mangadexId);
} else {
    $stmt = $conn->prepare("INSERT INTO reading_history (user_id, manga_id, title, cover_url, last_read, chapter_id) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $user_id, $mangadexId, $chapterTitle, $coverUrl, $now, $chapterId);
}

$stmt->execute();
$stmt->close();

echo json_encode(["status" => "success"]);
