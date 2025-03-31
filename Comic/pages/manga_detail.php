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
        $coverUrl = "http://localhost/Comic/assets/images/default.jpg";
    } else {
        $data = json_decode($response, true);
        $coverRel = array_filter($data['data']['relationships'], fn($rel) => $rel['type'] === 'cover_art');
        $cover = reset($coverRel);
        $coverUrl = $cover 
            ? "https://uploads.mangadex.org/covers/$mangaId/{$cover['attributes']['fileName']}.256.jpg" 
            : "http://localhost/Comic/assets/images/default.jpg";
    }
}

$chapters = [];
$chapterUrl = "https://api.mangadex.org/manga/$mangaId/feed?translatedLanguage[]=en&order[chapter]=asc&limit=100";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $chapterUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'ComicBase/1.0 (http://localhost; contact@example.com)');

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode === 200) {
    $chapterData = json_decode($response, true);
    if (isset($chapterData['data']) && is_array($chapterData['data'])) {
        $chapters = $chapterData['data'];
    }
} else {
    // Optional: log lỗi hoặc hiển thị cảnh báo
    error_log("Lỗi khi lấy danh sách chương cho manga $mangaId: HTTP $httpCode");
}

function translateToVietnamese($text) {
    $apiKey = 'AIzaSyBuYELdyvGvTnaYEKIQpsgTLiUCISRrWsQ'; 
    $url = 'https://translation.googleapis.com/language/translate/v2';

    $data = [
        'q' => $text,
        'target' => 'vi',
        'format' => 'text',
        'source' => 'en',
        'key' => $apiKey
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $json = json_decode($response, true);
    return $json['data']['translations'][0]['translatedText'] ?? $text;
}

function fetchMangaFromMangadex($mangaId) {
    $url = "https://api.mangadex.org/manga/$mangaId?includes[]=cover_art&includes[]=author&includes[]=artist";
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
        return ['error' => $data['errors'][0]['detail'] ?? 'Unknown API error'];
    }

    $mangaData = $data['data'];
    $attributes = $mangaData['attributes'];

    // Lấy title và description đầy đủ
    $title = $attributes['title']['en'] ?? reset($attributes['title']) ?? 'Unknown Title';
    $desc = $attributes['description']['en'] ?? reset($attributes['description']) ?? 'No description available';

    // Gán thêm thông tin
    $result = [
        'id' => $mangaData['id'],
        'title' => $title,
        'description' => $desc,
        'status' => $attributes['status'] ?? 'Unknown',
        'rating' => $attributes['contentRating'] ?? 'N/A',
        'likes' => $attributes['version'] ?? 'N/A', // chỉ là ví dụ, mangadex không cung cấp "likes"
    ];

    // Tìm ảnh bìa từ relationships
    foreach ($mangaData['relationships'] as $rel) {
        if ($rel['type'] === 'cover_art') {
            $fileName = $rel['attributes']['fileName'] ?? '';
            $result['cover_url'] = "https://uploads.mangadex.org/covers/$mangaId/$fileName.256.jpg";
        }
    }

    return $result;
}

// function fetchMangaFromMangadex($mangaId) {
//     $url = "https://api.mangadex.org/manga/$mangaId";
//     $ch = curl_init();
//     curl_setopt($ch, CURLOPT_URL, $url);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     curl_setopt($ch, CURLOPT_USERAGENT, 'ComicBase/1.0 (http://localhost; contact@example.com)');
//     $response = curl_exec($ch);

//     if ($response === false) {
//         $error = curl_error($ch);
//         curl_close($ch);
//         return ['error' => "CURL Error: $error"];
//     }

//     curl_close($ch);
//     $data = json_decode($response, true);

//     if (json_last_error() !== JSON_ERROR_NONE) {
//         return ['error' => 'JSON Decode Error: ' . json_last_error_msg()];
//     }

//     if (!isset($data['result']) || $data['result'] === 'error') {
//         return ['error' => isset($data['errors'][0]['detail']) ? $data['errors'][0]['detail'] : 'Unknown API error'];
//     }

//     if (!isset($data['data']) || !is_array($data['data'])) {
//         return ['error' => 'Invalid API response: data is not an array'];
//     }

//     if (!isset($data['data']['attributes']) || !is_array($data['data']['attributes'])) {
//         return ['error' => 'Invalid API response: attributes is not an array'];
//     }

//     $manga = $data['data']['attributes'];
//     $manga['id'] = $data['data']['id'];

//     if (isset($manga['title']) && is_array($manga['title'])) {
//         $manga['title'] = $manga['title']['en'] ?? reset($manga['title']) ?? 'Unknown Title';
//     } elseif (!isset($manga['title'])) {
//         $manga['title'] = 'Unknown Title';
//     }

//     if (isset($manga['description']) && is_array($manga['description'])) {
//         $manga['description'] = $manga['description']['en'] ?? reset($manga['description']) ?? 'No description available';
//     } elseif (!isset($manga['description'])) {
//         $manga['description'] = 'No description available';
//     }

//     if (!isset($manga['status'])) {
//         $manga['status'] = 'Unknown';
//     }

//     return $manga;
// }

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($manga['title'] ?? 'Manga Detail'); ?> - ComicBase</title>
    <link rel="stylesheet" href="../assets/style.css">

    <style>
       body {
    background-color: #121212;
    color: #f1f1f1;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    line-height: 1.6;
    margin: 0;
    padding: 0;
}

.manga-detail {
    max-width: 900px;
    margin: 30px auto;
    background-color: #1e1e1e;
    padding: 25px 30px;
    border-radius: 12px;
    box-shadow: 0 0 20px rgba(0,0,0,0.4);
}

.manga-detail h2 {
    font-size: 28px;
    color: #ffcc00;
    text-align: center;
    margin-bottom: 20px;
}

.manga-detail .cover {
    width: 220px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.3);
}

.manga-detail .info {
    margin-left: 25px;
    flex: 1;
}

.manga-detail .info p {
    margin: 10px 0;
    font-size: 16px;
}

.manga-detail .info strong {
    color: #ccc;
}

.btn-read {
    display: block;
    width: fit-content;
    margin: 20px auto;
    background-color: #ff5722;
    color: white;
    font-weight: bold;
    text-decoration: none;
    padding: 12px 28px;
    border-radius: 8px;
    transition: background 0.3s;
}
.btn-read:hover {
    background-color: #e64a19;
}

.preview-section h3,
.chapter-list h3 {
    margin-top: 30px;
    color: #ffcc00;
    border-bottom: 1px solid #444;
    padding-bottom: 8px;
}

.preview-images {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-top: 15px;
}
.preview-images img {
    width: 150px;
    border-radius: 6px;
    object-fit: cover;
    transition: transform 0.3s;
}
.preview-images img:hover {
    transform: scale(1.05);
}

.chapter-list {
    max-height: 300px;
    overflow-y: auto;
    padding: 10px;
    background-color: #222;
    border-radius: 8px;
}

.chapter-list ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.chapter-list li {
    border-bottom: 1px solid #444;
    padding: 10px 0;
}

.chapter-list a {
    color: #80d0ff;
    text-decoration: none;
    transition: color 0.3s;
}
.chapter-list a:hover {
    color: #4db8ff;
}

input#searchChapter {
    width: 100%;
    padding: 10px;
    margin-bottom: 12px;
    border-radius: 6px;
    border: 1px solid #555;
    background-color: #1b1b1b;
    color: white;
}

.load-more {
    display: block;
    margin: 20px auto 0;
    background-color: #444;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}
.load-more:hover {
    background-color: #555;
}

@media screen and (max-width: 768px) {
    .manga-detail {
        padding: 20px;
    }
    .manga-detail .cover {
        width: 100%;
        margin-bottom: 20px;
    }
    .manga-detail .info {
        margin-left: 0;
    }
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
            <!-- <p><strong>Mô tả:</strong> <?php echo htmlspecialchars($manga['description'] ?? 'No description available'); ?></p> -->
            <?php
            function cleanDescription($text) {
                $text = preg_replace('/\[.*?\]\(.*?\)/', '', $text); // Remove [text](link)
                $text = preg_replace('/[*_~#>`]/', '', $text);       // Remove markdown chars
                $text = preg_replace('/-{2,}/', '', $text);          // Remove horizontal lines ---
                return trim($text);
            }

            $fullDesc = cleanDescription($manga['description'] ?? 'No description available');
            $shortDesc = mb_strimwidth($fullDesc, 0, 500, '...');

            $descToShow = strlen($fullDesc) > 500 ? $shortDesc : $fullDesc;
            ?>

            <p><strong>Mô tả:</strong> <span id="desc"><?php echo nl2br(htmlspecialchars($descToShow)); ?></span>
            <?php if (strlen($fullDesc) > 500): ?>
                <a href="#" id="show-more">Xem thêm</a>
                <script>
                    document.getElementById('show-more').addEventListener('click', function(e) {
                        e.preventDefault();
                        document.getElementById('desc').innerHTML = <?php echo json_encode(nl2br(htmlspecialchars($fullDesc))); ?>;
                        this.style.display = 'none';
                    });
                </script>
            <?php endif; ?>
            </p>
            <p><strong>Tình trạng:</strong> <?php echo htmlspecialchars($manga['status'] ?? 'Unknown'); ?></p>
        </div>
    </div>

        <?php if (!empty($chapters)): 
        $firstChapter = $chapters[0];
        $chapterId = $firstChapter['id'];
        $chapterNum = $firstChapter['attributes']['chapter'] ?? '1';
    ?>
    <a href="/Comic/pages/readingpage.php?chapter_id=<?php echo $chapterId; ?>&mangadex_id=<?php echo $mangaId; ?>&chapter=<?php echo $chapterNum; ?>" class="btn-read">📖 Đọc Ngay</a>
    <?php endif; ?>

    <?php if (!empty($chapters)): ?>
        <div class="chapter-list scrollable">
    <h3>📚 Danh sách chương</h3>
    <input type="text" id="searchChapter" placeholder="🔍 Tìm chương..." style="width: 100%; padding: 8px; margin-bottom: 10px; border-radius: 4px; border: 1px solid #ccc;">

    <ul>
        <?php foreach ($chapters as $ch): 
            $chNum = $ch['attributes']['chapter'] ?? 'N/A';
            $title = $ch['attributes']['title'] ?? '';
            $chId = $ch['id'];
        ?>
            <li>
                <a href="/Comic/pages/readingpage.php?chapter_id=<?php echo $chId; ?>&mangadex_id=<?php echo $mangaId; ?>&chapter=<?php echo $chNum; ?>">
                    Chương <?php echo htmlspecialchars($chNum); ?> - <?php echo htmlspecialchars($title); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<?php endif; ?>

</div>

<script>
    let offset = 0;
    const limit = 5;
    const mangaId = "<?php echo htmlspecialchars($mangaId, ENT_QUOTES); ?>";
    const previewImages = document.getElementById('preview-images');
    const loadMoreBtn = document.getElementById('load-more');

    document.getElementById("searchChapter").addEventListener("input", function () {
        const keyword = this.value.toLowerCase();
        const items = document.querySelectorAll(".chapter-list.scrollable li");
        items.forEach(item => {
            const text = item.textContent.toLowerCase();
            item.style.display = text.includes(keyword) ? "" : "none";
        });
    });

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
                                    const readLink = document.createElement('a');
                                    readLink.href = `/Comic/pages/readingpage.php?chapter_id=${chapterId}&mangadex_id=${mangaId}&chapter=${chapter.attributes.chapter || ''}`;
                                    readLink.target = "_blank";

                                    const img = document.createElement('img');
                                    img.src = imgUrl;
                                    img.alt = `Chapter ${chapter.attributes.chapter || 'Unknown'}`;
                                    img.classList.add('preview-thumbnail');

                                    readLink.appendChild(img);
                                    previewImages.appendChild(readLink);
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


