<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "../includes/db.php";


$mangaId = isset($_GET['id']) ? $_GET['id'] : (isset($_GET['mangadex_id']) ? $_GET['mangadex_id'] : null);

if (!$mangaId) {
    die("Manga ID not provided.");
}

$manga = null;
$coverUrl = null;


$query = "SELECT * FROM manga WHERE id = ? OR mangadex_id = ?";
$stmt = $conn->prepare($query);
if ($stmt === false) {
    die("Prepare failed: " . htmlspecialchars($conn->error));
}
$stmt->bind_param("ss", $mangaId, $mangaId);
if (!$stmt->execute()) {
    die("Execute failed: " . htmlspecialchars($stmt->error));
}
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $manga = $result->fetch_assoc();
   
    $coverUrl = $manga['cover_url'] ?: null;
}

if (!$manga) {
    $mangaData = fetchMangaFromMangadex($mangaId);
    if (isset($mangaData['error'])) {
        die("Manga not found: " . htmlspecialchars($mangaData['error']));
    }
    $manga = $mangaData;
}

if (!$manga || !is_array($manga)) {
    die("No valid manga data available.");
}


if (!$coverUrl) {
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
        $coverUrl = "http://localhost/Comic/WebReadMangaDex_FlashPM/Comic/assets/images/default.jpg";
    } else {
        $data = json_decode($response, true);
        $coverRel = array_filter($data['data']['relationships'], fn($rel) => $rel['type'] === 'cover_art');
        $cover = reset($coverRel);
        $coverUrl = $cover 
            ? "https://uploads.mangadex.org/covers/$mangaId/{$cover['attributes']['fileName']}.256.jpg" 
            : "http://localhost/Comic/WebReadMangaDex_FlashPM/Comic/assets/images/default.jpg";
    }
}

function fetchMangaFromMangadex($mangaId) {
    $url = "https://api.mangadex.org/manga/$mangaId";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'ComicBase/1.0 (http://localhost; contact@example.com)');
    $response = curl_exec($ch);

    if ($response === false) {
        $error = curl_error($ch);
        curl_close($ch);
        return ['error' => "CURL Error: $error"];
    }

    curl_close($ch);
    $data = json_decode($response, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        return ['error' => 'JSON Decode Error: ' . json_last_error_msg()];
    }

    if (!isset($data['result']) || $data['result'] === 'error') {
        return ['error' => isset($data['errors'][0]['detail']) ? $data['errors'][0]['detail'] : 'Unknown API error'];
    }

    if (!isset($data['data']) || !is_array($data['data'])) {
        return ['error' => 'Invalid API response: data is not an array'];
    }

    if (!isset($data['data']['attributes']) || !is_array($data['data']['attributes'])) {
        return ['error' => 'Invalid API response: attributes is not an array'];
    }

    $manga = $data['data']['attributes'];
    $manga['id'] = $data['data']['id'];

    if (isset($manga['title']) && is_array($manga['title'])) {
        $manga['title'] = $manga['title']['en'] ?? reset($manga['title']) ?? 'Unknown Title';
    } elseif (!isset($manga['title'])) {
        $manga['title'] = 'Unknown Title';
    }

    if (isset($manga['description']) && is_array($manga['description'])) {
        $manga['description'] = $manga['description']['en'] ?? reset($manga['description']) ?? 'No description available';
    } elseif (!isset($manga['description'])) {
        $manga['description'] = 'No description available';
    }

    if (!isset($manga['status'])) {
        $manga['status'] = 'Unknown';
    }

    return $manga;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($manga['title'] ?? 'Manga Detail'); ?> - ComicBase</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        .manga-detail {
            max-width: 900px;
            margin: 70px auto;
            padding: 20px;
            background-color: #222;
            border-radius: 10px;
            color: white;
        }
        .manga-detail .cover {
            width: 200px;
            height: auto;
            border: 2px solid #444;
            border-radius: 8px;
        }
        .manga-detail .info {
            margin-left: 20px;
        }
        .preview-section {
            margin-top: 20px;
        }
        .preview-images {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        .preview-images img {
            width: 150px;
            height: 200px;
            object-fit: cover;
            border: 1px solid #444;
            border-radius: 5px;
        }
        .load-more {
            margin-top: 10px;
            background-color: #444;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }
        .load-more:hover {
            background-color: #ffcc00;
            color: black;
        }
    </style>
</head>
<body>

<?php include '../includes/header.php'; ?>

<div class="manga-detail">
    <h2><?php echo htmlspecialchars($manga['title'] ?? 'Unknown Title'); ?></h2>
    <div style="display: flex; align-items: flex-start;">
        <img src="<?php echo htmlspecialchars($coverUrl); ?>" alt="Cover" class="cover">
        <div class="info">
            <p><strong>Đánh giá:</strong> ⭐ <?php echo htmlspecialchars($manga['rating'] ?? 'N/A'); ?></p>
            <p><strong>Lượt thích:</strong> ❤️ <?php echo htmlspecialchars($manga['likes'] ?? 'N/A'); ?></p>
            <p><strong>Mô tả:</strong> <?php echo htmlspecialchars($manga['description'] ?? 'No description available'); ?></p>
            <p><strong>Tình trạng:</strong> <?php echo htmlspecialchars($manga['status'] ?? 'Unknown'); ?></p>
        </div>
    </div>

    <div class="preview-section">
        <h3>Xem trước</h3>
        <div class="preview-images" id="preview-images">
            <!-- Images will be loaded via JavaScript -->
        </div>
        <button class="load-more" id="load-more">Tải thêm</button>
    </div>
</div>

<script>
    let offset = 0;
    const limit = 5;
    const mangaId = "<?php echo htmlspecialchars($mangaId, ENT_QUOTES); ?>";
    const previewImages = document.getElementById('preview-images');
    const loadMoreBtn = document.getElementById('load-more');

    function loadPreviewImages() {
        loadMoreBtn.disabled = true;
        loadMoreBtn.textContent = 'Đang tải...';

        fetch(`https://api.mangadex.org/manga/${mangaId}/feed?limit=${limit}&offset=${offset}&order[chapter]=desc`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.result === 'ok' && data.data.length > 0) {
                    data.data.slice(0, 3).forEach(chapter => {
                        const chapterId = chapter.id;
                        fetch(`https://api.mangadex.org/chapter/${chapterId}`)
                            .then(res => {
                                if (!res.ok) {
                                    throw new Error('Chapter fetch failed');
                                }
                                return res.json();
                            })
                            .then(chapData => {
                                if (chapData.result === 'ok') {
                                    const hash = chapData.data.attributes.hash;
                                    const page = chapData.data.attributes.data[0]; // First page
                                    const imgUrl = `https://uploads.mangadex.org/data/${hash}/${page}`;
                                    const img = document.createElement('img');
                                    img.src = imgUrl;
                                    img.alt = `Chapter ${chapter.attributes.chapter || 'Unknown'}`;
                                    previewImages.appendChild(img);
                                }
                            })
                            .catch(error => {
                                console.error(`Error loading chapter ${chapterId}:`, error);
                            });
                    });
                    offset += limit;
                    if (data.data.length < limit) {
                        loadMoreBtn.style.display = 'none';
                    }
                } else {
                    loadMoreBtn.style.display = 'none';
                }
            })
            .catch(error => {
                console.error('Error loading chapters:', error);
                loadMoreBtn.style.display = 'none';
            })
            .finally(() => {
                loadMoreBtn.disabled = false;
                loadMoreBtn.textContent = 'Tải thêm';
            });
    }

    loadPreviewImages();
    loadMoreBtn.addEventListener('click', loadPreviewImages);
</script>

</body>
</html>