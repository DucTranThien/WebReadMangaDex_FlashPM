<style>
    .navbar {
        display: flex;
        justify-content: left;
        align-items: center; /* Căn giữa theo chiều dọc */
        background-color: #000;
        padding: 10px;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 100;
    }
    .navbar a {
        color: white;
        padding: 10px 15px;
        text-decoration: none;
        font-size: 14px;
        display: flex;
        align-items: center; /* Căn giữa văn bản */
    }
    .navbar a:hover {
        background-color: #333;
    }
    .dropdown {
        position: relative;
        display: flex;
        align-items: center; /* Căn giữa chữ THỂ LOẠI */
    }
    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #222;
        padding: 10px;
        width: 600px;
        left: 0;
        top: 100%;
        box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
        z-index: 100;
    }
    .dropdown:hover .dropdown-content {
        display: flex;
        flex-wrap: wrap;
    }
    .dropdown-content a {
        color: white;
        padding: 8px;
        width: 30%;
        box-sizing: border-box;
        text-decoration: none;
    }
    .dropdown-content a:hover {
        background-color: #333;
    }
</style>

<div class="navbar">
    <a href="index.php">🏠 Trang Chủ</a>
    <a href="#">THEO DÕI</a>
    <a href="list.php?danh_muc=hot">HOT</a>
    <a href="list.php?danh_muc=yeu_thich">YÊU THÍCH</a>
    <a href="list.php?danh_muc=moi_cap_nhat">MỚI CẬP NHẬT</a>
    <a href="#">LỊCH SỬ</a>

    <div class="dropdown">
        <a href="#">THỂ LOẠI ▼</a>
        <div class="dropdown-content">
            <?php
                $categories = [
                    "Oneshot", "Thriller", "Award Winning", "Reincarnation", "Sci-Fi", "Time Travel",
                    "Genderswap", "Loli", "Historical", "Monsters", "Psychological", "Romance",
                    "Crime", "Reverse Harem", "Sports", "Superhero", "Martial Arts", "Magical Girls",
                    "Adventure", "Post-Apocalypse", "Sexual Violence", "Magic", "Girls' Love", "Harem",
                    "Military", "Isekai", "Doujinshi", "Drama", "Fantasy", "Monster Girls", "Vampires"
                ];

                foreach ($categories as $category) {
                    echo "<a href='#'>$category</a>";
                }
            ?>
        </div>
    </div>

    <a href="search.php">TÌM TRUYỆN</a>
    <a href="truyen.php?danh_muc=con_gai">CON GÁI</a>
    <a href="truyen.php?danh_muc=con_trai">CON TRAI</a>
    <a href="#">LIGHT NOVEL</a>
</div>
