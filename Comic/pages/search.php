<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tìm Truyện</title>
    <link rel="stylesheet" href="../assets/style.css"> <!-- Include the main stylesheet -->
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
        select, input[type="text"], button {
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
    </style>
</head>
<body>

<?php include '../includes/header.php'; ?>

<div class="search-container">
    <h2>Tìm truyện nâng cao</h2>
    <input type="text" id="searchInput" name="title" placeholder="Tựa đề">

    <div id="searchResults" style="margin-top: 20px;"></div>
    </div>

    <h3>Thể loại</h3>
    <div class="categories-container">
    <?php foreach ($categories as $category): ?>
        <label class='category-item'>
            <input type='checkbox' class="genre-checkbox" value="<?= $category ?>"> <?= $category ?>
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
                <option value="relevance">Liên quan</option>
                <option value="rating">Đánh giá cao</option>
            </select>
        </div>
    </div>

    <button>Tìm kiếm</button>
</div>

</body>
<script>
function getSelectedGenres() {
    const selected = [];
    document.querySelectorAll('.genre-checkbox:checked').forEach(cb => {
        selected.push(cb.value);
    });
    return selected;
}

function searchManga() {
    const title = document.getElementById('searchInput').value.trim();
    const genres = getSelectedGenres();
    const status = document.getElementById('statusSelect').value;
    const order = document.getElementById('sortSelect').value;

    const params = new URLSearchParams();
    if (title) params.append('title', title);
    if (status) params.append('status', status);
    if (order) params.append('order', order);
    genres.forEach(g => params.append('genres[]', g));

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
                        <div style="display: flex; gap: 15px; background: #333; padding: 10px; border-radius: 8px; margin-bottom: 10px;">
                            <img src="${coverUrl}" alt="${title}" style="width: 80px; height: 110px; object-fit: cover;">
                            <div>
                                <h4 style="margin: 0 0 5px 0;">${title}</h4>
                                <a href="manga_detail.php?id=${id}" style="color: lightgreen;">Xem chi tiết</a>
                            </div>
                        </div>
                    `;
                }).join('');
                document.getElementById('searchResults').innerHTML = results || '<p>Không tìm thấy truyện.</p>';
            } else {
                document.getElementById('searchResults').innerHTML = '<p>Không có kết quả phù hợp.</p>';
            }
        })
        .catch(() => {
            document.getElementById('searchResults').innerHTML = '<p style="color:red;">Có lỗi xảy ra.</p>';
        });
}

// Gọi khi nhập hoặc thay đổi bộ lọc
document.getElementById('searchInput').addEventListener('input', () => setTimeout(searchManga, 300));
document.querySelectorAll('.genre-checkbox').forEach(cb => cb.addEventListener('change', searchManga));
document.getElementById('statusSelect').addEventListener('change', searchManga);
document.getElementById('sortSelect').addEventListener('change', searchManga);
</script>


</html>