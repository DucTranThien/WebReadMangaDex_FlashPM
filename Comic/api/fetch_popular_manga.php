<?php
include "../includes/db.php";

// Step 1: Fetch popular manga
$baseUrl = "https://api.mangadex.org";
$popularMangaUrl = "$baseUrl/manga?order[followedCount]=desc&limit=10&includes[]=cover_art&includes[]=author&contentRating[]=safe";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $popularMangaUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'ComicBase/1.0 (http://localhost; contact@example.com)');
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if ($response === false || $httpCode !== 200) {
    $error = curl_error($ch);
    curl_close($ch);
    die("Failed to fetch popular manga: HTTP $httpCode, Error: $error");
}

curl_close($ch);
$popularMangaData = json_decode($response, true);

if (json_last_error() !== JSON_ERROR_NONE || !isset($popularMangaData['data'])) {
    die("Invalid API response: " . json_last_error_msg());
}

// Step 2: Store manga details
foreach ($popularMangaData['data'] as $manga) {
    $mangadexId = $manga['id'];
    $title = $manga['attributes']['title']['en'] ?? reset($manga['attributes']['title']) ?? 'Unknown Title';
    $description = $manga['attributes']['description']['en'] ?? reset($manga['attributes']['description']) ?? 'No description';
    $status = $manga['attributes']['status'] ?? 'unknown';
    $year = $manga['attributes']['year'] ?? null;
    $contentRating = $manga['attributes']['contentRating'] ?? 'unknown';

    $coverUrl = "http://localhost/Comic/WebReadMangaDex_FlashPM/Comic/assets/images/default.jpg";
    foreach ($manga['relationships'] as $rel) {
        if ($rel['type'] === 'cover_art' && isset($rel['attributes']['fileName'])) {
            $coverUrl = "https://uploads.mangadex.org/covers/$mangadexId/{$rel['attributes']['fileName']}";
            break;
        }
    }

    $author = 'Unknown Author';
    foreach ($manga['relationships'] as $rel) {
        if ($rel['type'] === 'author' && isset($rel['attributes']['name'])) {
            $author = $rel['attributes']['name'];
            break;
        }
    }

    $query = "INSERT INTO manga (mangadex_id, title, description, status, year, content_rating, cover_url, author)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)
              ON DUPLICATE KEY UPDATE
              title = VALUES(title),
              description = VALUES(description),
              status = VALUES(status),
              year = VALUES(year),
              content_rating = VALUES(content_rating),
              cover_url = VALUES(cover_url),
              author = VALUES(author)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssisss", $mangadexId, $title, $description, $status, $year, $contentRating, $coverUrl, $author);
    $stmt->execute();
    $stmt->close();
}

// Step 3: Fetch chapters and images
$imageDir = __DIR__ . "/../images/chapters/";
if (!is_dir($imageDir)) {
    mkdir($imageDir, 0777, true);
}

foreach ($popularMangaData['data'] as $manga) {
    $mangadexId = $manga['id'];

    $query = "SELECT id FROM manga WHERE mangadex_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $mangadexId);
    $stmt->execute();
    $result = $stmt->get_result();
    $mangaRow = $result->fetch_assoc();
    $mangaDbId = $mangaRow['id'];
    $stmt->close();

    $chapterUrl = "$baseUrl/manga/$mangadexId/feed?translatedLanguage[]=en&order[chapter]=desc&limit=5";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $chapterUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'ComicBase/1.0 (http://localhost; contact@example.com)');
    $chapterResponse = curl_exec($ch);
    curl_close($ch);

    $chapterData = json_decode($chapterResponse, true);
    if (!isset($chapterData['data'])) {
        echo "Failed to fetch chapters for manga $mangadexId\n";
        continue;
    }

    foreach ($chapterData['data'] as $chapter) {
        $chapterId = $chapter['id'];
        $chapterNumber = $chapter['attributes']['chapter'] ?? 'Unknown';
        $chapterTitle = $chapter['attributes']['title'] ?? 'Untitled';
        $volume = $chapter['attributes']['volume'] ?? null;
        $language = $chapter['attributes']['translatedLanguage'] ?? 'en';
        $publishAt = $chapter['attributes']['publishAt'] ?? null;

        $query = "INSERT INTO chapters (mangadex_id, manga_id, chapter_number, title, volume, language, publish_at)
                  VALUES (?, ?, ?, ?, ?, ?, ?)
                  ON DUPLICATE KEY UPDATE
                  chapter_number = VALUES(chapter_number),
                  title = VALUES(title),
                  volume = VALUES(volume),
                  language = VALUES(language),
                  publish_at = VALUES(publish_at)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sisssss", $chapterId, $mangaDbId, $chapterNumber, $chapterTitle, $volume, $language, $publishAt);
        $stmt->execute();
        $chapterDbId = $stmt->insert_id;
        $stmt->close();

        // Fetch chapter images
        $atHomeUrl = "$baseUrl/at-home/server/$chapterId";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $atHomeUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'ComicBase/1.0 (http://localhost; contact@example.com)');
        $atHomeResponse = curl_exec($ch);
        curl_close($ch);

        $atHomeData = json_decode($atHomeResponse, true);
        if (!isset($atHomeData['baseUrl']) || !isset($atHomeData['chapter']['data'])) {
            echo "Failed to fetch images for chapter $chapterId\n";
            continue;
        }

        $baseUrl = $atHomeData['baseUrl'];
        $hash = $atHomeData['chapter']['hash'];
        $pages = $atHomeData['chapter']['data'];

        $page = $pages[0]; // First page for preview
        $pageNumber = 1;
        $imageUrl = "$baseUrl/data/$hash/$page";

        $localPath = "$imageDir/{$chapterId}_page_{$pageNumber}.jpg";
        $fp = fopen($localPath, 'wb');
        $ch = curl_init($imageUrl);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_USERAGENT, 'ComicBase/1.0 (http://localhost; contact@example.com)');
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);

        $relativePath = "images/chapters/{$chapterId}_page_{$pageNumber}.jpg";
        $query = "INSERT INTO chapter_images (chapter_id, page_number, image_url, local_path)
                  VALUES (?, ?, ?, ?)
                  ON DUPLICATE KEY UPDATE
                  image_url = VALUES(image_url),
                  local_path = VALUES(local_path)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iiss", $chapterDbId, $pageNumber, $imageUrl, $relativePath);
        $stmt->execute();
        $stmt->close();

        sleep(1); // Avoid rate limits
    }
}

echo "Successfully fetched and stored popular manga!\n";
?>