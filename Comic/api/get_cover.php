<?php
header('Content-Type: application/json');
include "../includes/db.php";

$mangaId = $_GET['id'] ?? '';
if (empty($mangaId)) {
    echo json_encode(['status' => 'error', 'message' => 'Manga ID is required']);
    exit;
}

$query = "SELECT cover_url FROM manga WHERE id = ? OR mangadex_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $mangaId, $mangaId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $coverUrl = $row['cover_url'];
} else {
    $url = "https://api.mangadex.org/manga/$mangaId?includes[]=cover_art";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'ComicBase/1.0 (http://localhost; contact@example.com)'); 
    $response = curl_exec($ch);
    $error = curl_error($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($response === false || $httpCode !== 200) {
        $coverUrl = "../assets/images/default.jpg";
    } else {
        $data = json_decode($response, true);
        $coverRel = array_filter($data['data']['relationships'], fn($rel) => $rel['type'] === 'cover_art');
        $cover = reset($coverRel);
        $coverUrl = $cover 
            ? "https://uploads.mangadex.org/covers/$mangaId/{$cover['attributes']['fileName']}.256.jpg" 
            : "../assets/images/default.jpg";
    }
}

echo json_encode(['status' => 'success', 'data' => ['cover_url' => $coverUrl]], JSON_PRETTY_PRINT);
$stmt->close();
$conn->close();
?>