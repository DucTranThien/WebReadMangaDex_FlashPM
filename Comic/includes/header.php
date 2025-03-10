<?php
// includes/header.php

// Fetch categories from local API
$categories = [];
$categoryJson = @file_get_contents('http://localhost/Comic/WebReadMangaDex_FlashPM/Comic/api/get_categories.php');
if ($categoryJson !== false) {
    $categoryData = json_decode($categoryJson, true);
    if (isset($categoryData['status']) && $categoryData['status'] === 'success' && !empty($categoryData['data'])) {
        $categories = $categoryData['data'];
    } else {
        $categories = [
            "Action", "Comedy", "Drama", "Fantasy", "Horror", "Romance"
        ];
    }
} else {
    $categories = [
        "Action", "Comedy", "Drama", "Fantasy", "Horror", "Romance"
    ];
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ComicBase - Trang Chủ</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<header>
    <div><span style="font-size: 27px; font-weight: bold;">📚</span><span class="logo">ComicBase</span></div>
    <nav>
        <a href="index.php">Trang Chủ</a>
        <a href="search.php">Tìm Kiếm</a>
        <div class="dropdown">
            <a href="#">Thể Loại ▼</a>
            <div class="dropdown-content">
                <?php
                foreach ($categories as $category) {
                    echo "<a href='#'>$category</a>";
                }
                ?>
            </div>
        </div>
        <a href="#">Xếp Hạng</a>
    </nav>
</header>