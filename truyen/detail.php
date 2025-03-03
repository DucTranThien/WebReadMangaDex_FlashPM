<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết truyện</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #111;
            color: white;
            text-align: center;
            padding-top: 70px;
        }
        .truyen-detail {
            max-width: 600px;
            margin: auto;
            background-color: #222;
            padding: 20px;
            border-radius: 10px;
        }
        .truyen-detail img {
            width: 100%;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<?php
// Danh sách truyện cứng (giống `truyen.php`)
$truyen_data = [
    1 => ["Solo Leveling", "122026848_p0_master1200.jpg", 9.34, 5034, 291511],
    2 => ["Tensei Shitara Slime Datta Ken", "122474309_p0_master1200.jpg", 9.29, 1519, 201580],
    3 => ["Cô Nàng Nổi Loạn X Chàng Thợ May", "122026848_p0_master1200.jpg", 9.21, 784, 232574],
    4 => ["Chainsaw Man", "chainsaw-man.jpg", 9.27, 735, 169572],
    5 => ["Ta Muốn Trở Thành Chúa Tể Bóng Tối!", "chua-te-bong-toi.jpg", 9.18, 1717, 215707],
    6 => ["Nô lệ của đội tinh nhuệ Ma đỏ", "no-le-ma-do.jpg", 8.89, 828, 194059],
    7 => ["Komi - Nữ thần sợ giao tiếp", "komi.jpg", 8.98, 2014, 170660],
    8 => ["Pháp Sư Tiễn Tăng Frieren", "frieren.jpg", 9.53, 1303, 184733]
];

$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id && isset($truyen_data[$id])) {
    $truyen = $truyen_data[$id];
    echo "<div class='truyen-detail'>
            <img src='images/{$truyen[1]}' alt='{$truyen[0]}'>
            <h2>{$truyen[0]}</h2>
            <p>⭐ Đánh giá: {$truyen[2]}</p>
            <p>👀 Lượt xem: {$truyen[3]}</p>
            <p>❤️ Lượt theo dõi: {$truyen[4]}</p>
          </div>";
} else {
    echo "<h2>Không tìm thấy truyện</h2>";
}
?>

</body>
</html>
