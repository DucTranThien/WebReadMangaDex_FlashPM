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
$chapterUrl = "https://api.mangadex.org/manga/$mangaId/feed?translatedLanguage[]=en&order[chapter]=desc&limit=500";

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
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($manga['title'] ?? 'Manga Detail'); ?> - MangaFlashPM</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
<?php include '../includes/header.php'; ?>

<div class="manga-detail">
    <h2><?php echo htmlspecialchars($manga['title'] ?? 'Unknown Title'); ?></h2>
    <div style="display: flex; align-items: flex-start;">
        <img src="<?php echo htmlspecialchars($coverUrl); ?>" alt="Cover" class="cover">
        <div class="info">
                    <p><strong>Đánh giá:</strong> ⭐ 
            <?php 
            echo isset($manga['average_rating']) && is_numeric($manga['average_rating']) 
                ? number_format($manga['average_rating'], 1) 
                : 'N/A'; 
            ?>
            </p>
            <p><strong>Lượt theo dõi:</strong> 👥 <?php echo htmlspecialchars($manga['followed_count'] ?? 'N/A'); ?></p>
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
    <h3>📖 Danh sách chương</h3>
    <input type="text" id="searchChapter" placeholder="🔍 Tìm chương..." style="width: 100%; padding: 8px; margin-bottom: 10px; border-radius: 4px; border: 1px solid #ccc;">

    <ul>
    <?php foreach ($chapters as $ch): 
        $chNum = $ch['attributes']['chapter'] ?? 'N/A';
        $title = $ch['attributes']['title'] ?? '';
        $chId = $ch['id'];
        $updated = $ch['attributes']['updatedAt'] ?? null;
        $updatedTime = $updated ? date("d/m/Y - H:i", strtotime($updated)) : 'Chưa rõ';
    ?>
        <li>
            <a href="/Comic/pages/readingpage.php?chapter_id=<?php echo $chId; ?>&mangadex_id=<?php echo $mangaId; ?>&chapter=<?php echo $chNum; ?>">
                 Chương <?php echo htmlspecialchars($chNum); ?> - <?php echo htmlspecialchars($title); ?>
            </a>
            <div style="font-size: 13px; color: #aaa;">🕒 Cập nhật: <?php echo $updatedTime; ?></div>
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
        if (!loadMoreBtn) return;
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


