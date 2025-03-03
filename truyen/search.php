<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tìm Truyện</title>
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

<?php include 'navbar.php'; ?>

<div class="search-container">
    <h2>Tìm truyện nâng cao</h2>
    <input type="text" placeholder="Tựa đề">

    <h3>Thể loại</h3>
    <div class="categories-container">
        <?php
            $categories = [
                "Oneshot", "Thriller", "Award Winning", "Reincarnation", "Sci-Fi", "Time Travel",
                "Genderswap", "Loli", "Historical", "Monsters", "Psychological", "Romance",
                "Crime", "Reverse Harem", "Sports", "Superhero", "Martial Arts", "Magical Girls",
                "Adventure", "Post-Apocalypse", "Sexual Violence", "Magic", "Girls' Love", "Harem",
                "Military", "Isekai", "Doujinshi", "Drama", "Fantasy", "Monster Girls", "Vampires"
            ];

            foreach ($categories as $category) {
                echo "<label class='category-item'><input type='checkbox'> $category</label>";
            }
        ?>
    </div>

    <h3>Tùy chọn</h3>
    <div class="filter-container">
    <div class="filter-item">
            <label>Sếch?</label>
            <select>
                <option>Có</option>
                <option>Không</option>
                <option>YESSSSSSSSSSS</option>
            </select>
        </div>
        <div class="filter-item">
            <label>Dành cho</label>
            <select>
                <option>Tất cả</option>
                <option>Shounen</option>
                <option>Shoujo</option>
                <option>Josei</option>
                <option>Seinen</option>
            </select>
        </div>
        <div class="filter-item">
            <label>Tình trạng</label>
            <select>
                <option>Tất cả</option>
                <option>Đang tiến hành</option>
                <option>Hoàn thành</option>
                <option>Đã kết thúc</option>
                <option>Bị ngưng</option>
                <option>Bị hủy</option>
            </select>
        </div>
        <div class="filter-item">
            <label>Sắp xếp theo</label>
            <select>
                <option>Theo dõi nhiều nhất</option>
                <option>Mới cập nhật</option>
                <option>Được xem nhiều</option>
                <option>Đánh giá cao</option>
            </select>
        </div>
    </div>

    <button>Tìm kiếm</button>
</div>

</body>
</html>
