<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tìm Truyện</title>
    <link rel="stylesheet" href="../assets/css/style.css"> <!-- Include the main stylesheet -->
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #111;
            color: white;
            padding-top: 50px; /* Đảm bảo navbar không che nội dung */
        }
        .search-container {
            max-width: 900px;
            margin: 70px auto;
            padding: 20px;
            background-color: #222;
            border-radius: 10px;
        }
        .categories-container {
            display: grid;
            grid-template-columns: repeat(5, 1fr); /* Chia thành 5 cột */
            gap: 10px;
            margin-top: 10px;
        }
        .category-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        input[type="checkbox"] {
            transform: scale(1.2); /* Tăng kích thước checkbox */
        }
        .filter-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-top: 20px;
        }
        .filter-item {
            display: flex;
            flex-direction: column;
        }
        select, input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
        }
        button {
            background-color: green;
            color: white;
            border: none;
            cursor: pointer;
            padding: 10px;
        }
        button:hover {
            background-color: darkgreen;
        }
        .manga-grid {
        display: grid;
        grid-template-columns: repeat(6, 1fr); /* 6 cột */
        gap: 20px;
        }

        .manga-card {
            background-color: #222;
            padding: 10px;
            border-radius: 10px;
            text-align: center;
            transition: transform 0.2s;
            overflow: hidden;
            height: 300px; /* cố định chiều cao */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .manga-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 6px;
        }

        .manga-card h4 {
            font-size: 14px;
            margin: 8px 0 4px;
            color: white;
            line-height: 1.3;
            height: 35px; /* fix chiều cao tên truyện */
            overflow: hidden;
        }

        .manga-card a {
            color: lightgreen;
            font-size: 13px;
            text-decoration: none;
        }
        .categories-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 12px;
            margin-top: 15px;
        }

        .category-tag {
            background-color: #222;
            color: white;
            border-radius: 20px;
            padding: 8px 12px;
            font-size: 14px;
            cursor: pointer;
            text-align: center;
            transition: 0.2s;
            border: 1px solid #444;
            user-select: none;
            display: inline-block;
            position: relative;
        }

        /* Ẩn checkbox */
        .category-tag input[type="checkbox"] {
            display: none;
        }

        /* Nếu checkbox được chọn → đổi màu */
        .category-tag input[type="checkbox"]:checked + * {
            background-color: #00aa55;
            color: white;
        }

        /* Hoặc dùng toggle class (bên dưới) nếu bạn thích JS hơn */
        .category-tag.active {
            background-color: #00aa55;
            color: white;
            border-color: #00aa55;
        }



    </style>
</head>
<body>
<?php 
include '../includes/header.php'; 
include '../includes/db.php'; 
$preSelectedGenre = $_GET['genre'] ?? null;
if (apiHasNewTags($conn)) {
    @file_get_contents("http://localhost/Comic/api/sync_categories.php");
}

$categories = [];
$sql = "SELECT name, mangadex_tag_id FROM categories ORDER BY name ASC";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $categories[] = $row;
}

function apiHasNewTags($conn) {
    $localCount = 0;
    $res = $conn->query("SELECT COUNT(*) AS total FROM categories");
    if ($res) {
        $row = $res->fetch_assoc();
        $localCount = (int)$row['total'];
    }

    $apiUrl = "https://api.mangadex.org/manga/tag";
    $json = @file_get_contents($apiUrl);
    if (!$json) return false;

    $data = json_decode($json, true);
    if (!isset($data['data'])) return false;

    $apiCount = count($data['data']);

    return $apiCount > $localCount;
}
?>

<div class="search-container">
    <h2>Tìm truyện nâng cao</h2>
    <input type="text" id="searchInput" placeholder="Tựa đề">

    <h3>Thể loại</h3>
    <div class="categories-container">
    <?php foreach ($categories as $category): ?>
        <?php
            $tagId = $category['mangadex_tag_id'];
            $tagName = $category['name'] ?? '';
            $isChecked = ($preSelectedGenre && $tagId === $preSelectedGenre);
        ?>
        <label class="category-tag <?= $isChecked ? 'active' : '' ?>">
            <input type="checkbox" class="genre-checkbox" value="<?= htmlspecialchars($tagId) ?>" <?= $isChecked ? 'checked' : '' ?>>
            <?= htmlspecialchars($tagName) ?>
        </label>
    <?php endforeach; ?>

    </div>


    <h3>Tùy chọn</h3>
    <div class="filter-container">
        <div class="filter-item">
            <label>Tình trạng</label>
            <select id="statusSelect">
                <option value="">Tất cả</option>
                <option value="ongoing">Đang tiến hành</option>
                <option value="completed">Hoàn thành</option>
            </select>
        </div>
        <div class="filter-item">
            <label>Sắp xếp theo</label>
            <select id="sortSelect">
                <option value="followedCount">Theo dõi nhiều</option>
                <option value="latestUploadedChapter">Mới cập nhật</option>
                <option value="rating">Đánh giá cao</option>
            </select>
        </div>
    </div>


    <div id="searchResults" class="manga-grid" style="margin-top: 30px;"></div>
    <div id="pagination" style="text-align: center; margin-top: 20px;"></div>

</div>

<!-- css kết quả -->
<style>
    
.manga-grid {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 20px;
}

.manga-card {
    background-color: #222;
    border-radius: 10px;
    padding: 10px;
    text-align: center;
    overflow: hidden;
    height: 300px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.manga-card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 6px;
}

.manga-card h4 {
    font-size: 14px;
    color: white;
    margin: 10px 0 5px;
    height: 34px;
    overflow: hidden;
}

.manga-card a {
    color: lightgreen;
    font-size: 13px;
    text-decoration: none;
}
#pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
    gap: 6px;
    margin-top: 20px;
}

#pagination button {
    background: #333;
    color: white;
    border: none;
    padding: 6px 12px;
    border-radius: 4px;
    cursor: pointer;
    transition: background 0.2s;
    font-size: 14px;
    min-width: 40px;
}

#pagination button:hover {
    background: #555;
}

#pagination button[disabled] {
    opacity: 0.5;
    cursor: not-allowed;
}

#pagination .active-page {
    background-color: #00aa55;
    color: white;
}

#pagination .dots {
    color: #aaa;
    font-size: 14px;
    padding: 0 4px;
}

</style>

<!-- script search -->
<script>
    
    document.querySelectorAll('.category-tag').forEach(tag => {
    const checkbox = tag.querySelector('input[type="checkbox"]');
    tag.addEventListener('click', (e) => {
        e.preventDefault(); 
        checkbox.checked = !checkbox.checked;
        tag.classList.toggle('active', checkbox.checked);
        searchManga(); 
    });
    });

    function getSelectedGenres() {
        const selected = [];
        document.querySelectorAll('.genre-checkbox:checked').forEach(cb => {
            selected.push(cb.value);
        });
        return selected;
    }

    function searchManga(page = 1) {
        const title = document.getElementById('searchInput').value.trim();
        const genres = getSelectedGenres();
        const status = document.getElementById('statusSelect').value;
        const order = document.getElementById('sortSelect').value;

        const limit = 30;
        const offset = (page - 1) * limit;

        const params = new URLSearchParams();
        if (title) params.append('title', title);
        if (status) params.append('status', status);
        if (order) params.append('order', order);
        genres.forEach(g => params.append('genres[]', g));
        params.append('offset', offset);

    fetch(`../api/search_api.php?${params.toString()}`)
        .then(res => res.json())
        .then(data => {
            if (data.result === 'ok') {
                const results = data.data.map(manga => {
                    const title = manga.attributes.title.en || 'Không có tên';
                    const id = manga.id;
                    const coverRel = manga.relationships.find(rel => rel.type === 'cover_art');
                    const coverFile = coverRel ? coverRel.attributes.fileName : '';
                    const coverUrl = coverRel ? `https://uploads.mangadex.org/covers/${id}/${coverFile}.256.jpg` : '';

                    return `
                        <div class="manga-card">
                            <img src="${coverUrl}" alt="${title}">
                            <h4 title="${title}">${title}</h4>
                            <a href="manga_detail.php?id=${id}">Xem chi tiết</a>
                        </div>
                    `;
                }).join('');

                document.getElementById('searchResults').innerHTML = results || '<p>Không tìm thấy truyện.</p>';

                //phân trang 
                const total = data.total || 0;
                const totalPages = Math.ceil(total / limit);
                let paginationHTML = '';

            if (totalPages > 1) {
                paginationHTML += `<button onclick="searchManga(${page - 1})" ${page === 1 ? 'disabled' : ''}>❮</button>`;

                if (page > 3) {
                    paginationHTML += `<button onclick="searchManga(1)">1</button>`;
                    if (page > 4) paginationHTML += `<span class="dots">...</span>`;
                }

                const range = 1;
                for (let i = Math.max(1, page - range); i <= Math.min(totalPages, page + range); i++) {
                    paginationHTML += `<button onclick="searchManga(${i})" class="${i === page ? 'active-page' : ''}">${i}</button>`;
                }

                if (page < totalPages - 2) {
                    if (page < totalPages - 3) paginationHTML += `<span class="dots">...</span>`;
                    paginationHTML += `<button onclick="searchManga(${totalPages})">${totalPages}</button>`;
                }

                paginationHTML += `<button onclick="searchManga(${page + 1})" ${page === totalPages ? 'disabled' : ''}>❯</button>`;
            }

            document.getElementById('pagination').innerHTML = paginationHTML;


            } else {
                document.getElementById('searchResults').innerHTML = '<p>Không có kết quả phù hợp.</p>';
                document.getElementById('pagination').innerHTML = '';
            }
        })
        .catch(() => {
            document.getElementById('searchResults').innerHTML = '<p style="color:red;">Có lỗi xảy ra.</p>';
            document.getElementById('pagination').innerHTML = '';
        });
        }



        document.getElementById('searchInput').addEventListener('input', () => setTimeout(searchManga, 300));
        document.querySelectorAll('.genre-checkbox').forEach(cb => cb.addEventListener('change', searchManga));
        document.getElementById('statusSelect').addEventListener('change', searchManga);
        document.getElementById('sortSelect').addEventListener('change', searchManga);

        window.addEventListener('DOMContentLoaded', () => searchManga(1));
        window.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('genre')) {
                searchManga(1);
            }
        });


</script>

</body>
</html>
