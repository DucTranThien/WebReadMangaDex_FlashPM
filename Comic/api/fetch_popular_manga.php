<?php
include "../includes/db.php";

function fetchPopularManga($conn, $limit = 10) {
    $url = "https://api.mangadex.org/manga?order[rating]=desc&limit=$limit";
    $response = @file_get_contents($url);
    if ($response === false) {
        die("Failed to connect to MangaDex API");
    }

    $data = json_decode($response, true);
    if (isset($data['result']) && $data['result'] === 'error') {
        die("API Error: " . $data['errors'][0]['detail']);
    }

    foreach ($data['data'] as $manga) {
        $mangadexId = $conn->real_escape_string($manga['id']);
        $title = $conn->real_escape_string($manga['attributes']['title']['en'] ?? 'Unknown');
        $description = $conn->real_escape_string($manga['attributes']['description']['en'] ?? '');
        $status = $conn->real_escape_string($manga['attributes']['status'] ?? 'ongoing');
        $contentRating = $conn->real_escape_string($manga['attributes']['contentRating'] ?? 'safe');
        $latestChapter = ''; // Will update later with chapter data
        $newestUploadDate = date('Y-m-d H:i:s'); // Placeholder; fetch from chapters if needed
        $coverRel = array_filter($manga['relationships'], fn($rel) => $rel['type'] === 'cover_art');
        $cover = reset($coverRel);
        $coverUrl = $cover 
            ? "https://uploads.mangadex.org/covers/$mangadexId/{$cover['attributes']['fileName']}.256.jpg" 
            : '';

        // Check if manga exists
        $checkQuery = "SELECT id FROM manga WHERE mangadex_id = '$mangadexId'";
        if ($conn->query($checkQuery)->num_rows == 0) {
            $query = "INSERT INTO manga (mangadex_id, title, description, latest_chapter, newest_upload_date, cover_url, status, content_rating, rating, likes) 
                      VALUES ('$mangadexId', '$title', '$description', '$latestChapter', '$newestUploadDate', '$coverUrl', '$status', '$contentRating', 0, 0)";
            $conn->query($query) or die("Insert Error: " . $conn->error);
        }
    }
}

fetchPopularManga($conn);
echo "Popular manga updated successfully!";
$conn->close();
?>