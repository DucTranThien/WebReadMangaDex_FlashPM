<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách truyện</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #111;
            color: white;
            padding-top: 70px; /* Tạo khoảng cách với navbar */
            text-align: center;
        }
        .truyen-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            padding: 20px;
        }
        .truyen-item {
            background-color: #222;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            transition: transform 0.2s;
        }
        .truyen-item:hover {
            transform: scale(1.05);
        }
        .truyen-item a {
            text-decoration: none;
            color: white;
            display: block;
        }
        .truyen-item img {
            width: 100%;
            height: 250px; /* Cố định chiều cao ảnh */
            object-fit: cover; /* Đảm bảo ảnh giữ đúng tỷ lệ */
            border-radius: 5px;
        }
        .truyen-item h3 {
            font-size: 14px;
            margin: 5px 0;
        }
        .truyen-info {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
        }
        .title {
            font-size: 24px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<?php
// Danh sách danh mục có dấu
$danh_muc_tieng_viet = [
    "hot" => "Hot",
    "yeu_thich" => "Yêu Thích",
    "moi_cap_nhat" => "Mới Cập Nhật",
    "con_gai" => "Con Gái",
    "con_trai" => "Con Trai"
];

// Lấy danh mục từ URL, nếu không có thì mặc định là "hot"
$danh_muc_hop_le = array_keys($danh_muc_tieng_viet);
$danh_muc = isset($_GET['danh_muc']) && in_array($_GET['danh_muc'], $danh_muc_hop_le) ? $_GET['danh_muc'] : 'hot';

// Danh sách truyện theo từng danh mục (code cứng) với ID để chuyển sang `detail.php`
$truyen_data = [
    "hot" => [
        [1, "Solo Leveling", "122026848_p0_master1200.jpg", 9.34, 5034, 291511],
        [2, "Tensei Shitara Slime Datta Ken", "122474309_p0_master1200.jpg", 9.29, 1519, 201580],
        [3, "Solo Leveling", "3.jpg", 9.34, 5034, 291511],
        [4, "Tensei Shitara Slime Datta Ken", "4.jpg", 9.29, 1519, 201580],
        [5, "Solo Leveling", "122026848_p0_master1200.jpg", 9.34, 5034, 291511],
        [6, "Tensei Shitara Slime Datta Ken", "122474309_p0_master1200.jpg", 9.29, 1519, 201580]
    ],
    "yeu_thich" => [
        [7, "Cô Nàng Nổi Loạn X Chàng Thợ May", "122026848_p0_master1200.jpg", 9.21, 784, 232574]
    ],
    "moi_cap_nhat" => [
        [8, "Chainsaw Man", "3.jpg", 9.27, 735, 169572],
        [9, "Ta Muốn Trở Thành Chúa Tể Bóng Tối!", "4.jpg", 9.18, 1717, 215707]
    ],
    "con_gai" => [
        [10, "Nô lệ của đội tinh nhuệ Ma đỏ", "5.jpg", 8.89, 828, 194059],
        [11, "Komi - Nữ thần sợ giao tiếp", "3.jpg", 8.98, 2014, 170660]
    ],
    "con_trai" => [
        [12, "Pháp Sư Tiễn Tăng Frieren", "4.jpg", 9.53, 1303, 184733]
    ]
];

// Hiển thị tiêu đề danh mục với dấu
echo "<div class='title'>Danh sách truyện - {$danh_muc_tieng_viet[$danh_muc]}</div>";

// Hiển thị danh sách truyện
echo "<div class='truyen-container'>";
foreach ($truyen_data[$danh_muc] as $truyen) {
    echo "<div class='truyen-item'>
            <a href='detail.php?id={$truyen[0]}'>
                <img src='images/{$truyen[2]}' alt='{$truyen[1]}'>
                <h3>{$truyen[1]}</h3>
                <div class='truyen-info'>
                    <span>⭐ {$truyen[3]}</span>
                    <span>👀 {$truyen[4]}</span>
                    <span>❤️ {$truyen[5]}</span>
                </div>
            </a>
          </div>";
}
echo "</div>";
?>

</body>
</html>
