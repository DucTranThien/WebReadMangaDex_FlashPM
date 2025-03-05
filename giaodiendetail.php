<?php
// Kết nối database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "truyendb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Lấy ID truyện từ URL
$truyen_id = isset($_GET['id']) ? intval($_GET['id']) : 1;

// Lấy thông tin truyện
$sql = "SELECT * FROM mangas WHERE id = $truyen_id";
$result = $conn->query($sql);
$truyen = $result->fetch_assoc();
$conn->query("UPDATE mangas SET views = views + 1 WHERE id = $truyen_id");
$sql = "SELECT * FROM mangas ORDER BY last_update DESC LIMIT 7";

// Kiểm tra và gán giá trị mặc định nếu thiếu dữ liệu
$truyen = array_merge([
    'rating' => 0,
    'likes' => 0,
    'comments_count' => 0,
    'alternative_title' => 'Đang cập nhật',
    'original_language' => 'Đang cập nhật',
    'source' => 'Không xác định',
    'last_update' => 'Đang cập nhật',
    'description' => 'Nội dung đang cập nhật...'
], $truyen);

// Lấy danh sách chương
$sql_chapters = "SELECT * FROM chapters WHERE manga_id = $truyen_id ORDER BY chapter_number ASC";
$chapters = $conn->query($sql_chapters);

// Lấy chương đầu tiên
$first_chapter = $chapters->fetch_assoc();

// Tách thể loại thành danh sách click được
$genres = isset($truyen['genre']) ? explode(",", $truyen['genre']) : [];

// Lấy danh sách bảng xếp hạng (giả lập dữ liệu)
$top_mangas = [
    ["title" => "Solo Leveling", "image" => "images/solo_leveling.jpg"],
    ["title" => "Cô Nàng Nổi Loạn X Chàng Thợ May", "image" => "images/co_nang_noi_loan.jpg"],
    ["title" => "Ta Muốn Trở Thành Chúa Tể Bóng Tối", "image" => "images/chu_te_bong_toi.jpg"]
];

// Số chương hiển thị trên mỗi trang
$chapters_per_page = 10;

// Xác định trang hiện tại
$current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($current_page - 1) * $chapters_per_page;

// Truy vấn danh sách chương có phân trang
$sql_chapters_paginated = "SELECT * FROM chapters WHERE manga_id = $truyen_id ORDER BY chapter_number ASC LIMIT $chapters_per_page OFFSET $offset";
$chapters_paginated = $conn->query($sql_chapters_paginated);

// Đếm tổng số chương để tính số trang
$total_chapters = $conn->query("SELECT COUNT(*) AS total FROM chapters WHERE manga_id = $truyen_id")->fetch_assoc()['total'];
$total_pages = ceil($total_chapters / $chapters_per_page);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($truyen['title']); ?></title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="truyen-layout">
            <div class="truyen-content">
            <div class="truyen-detail">
    <!-- Breadcrumb và Tiêu đề -->
    <div class="truyen-header">
        <nav class="breadcrumb">
            <a href="index.php" target="_blank">Trang chủ</a> /
            <a href="truyen-tranh.php" target="_blank">Truyện Tranh</a>
        </nav>
        <h1 class="truyen-title"><?php echo htmlspecialchars($truyen['title']); ?></h1>
    </div>

    <!-- Bố cục chứa Ảnh bìa + Thông tin -->
    <div class="truyen-main">
        <!-- Ảnh bìa -->
        <div class="cover-container">
            <img src="<?php echo htmlspecialchars($truyen['cover_image']); ?>" alt="<?php echo htmlspecialchars($truyen['title']); ?>" class="cover-image">
        </div>

        <!-- Thông tin truyện -->
        <div class="truyen-info">
            <div class="truyen-stats">
                <span class="rating"><i class="fa-solid fa-star"></i> <?php echo number_format($truyen['rating'], 2); ?> / 10</span>
                <span class="likes"><i class="fa-solid fa-heart"></i> <?php echo number_format($truyen['likes']); ?></span>
                <span class="comments"><i class="fa-solid fa-comment"></i> <?php echo number_format($truyen['comments_count']); ?></span>
            </div>
            <p><strong>Tác giả:</strong> <?php echo htmlspecialchars($truyen['author']); ?></p>
            <p><strong>Thể loại:</strong> 
                <?php foreach ($genres as $genre) { ?>
                    <a href="genre.php?name=<?php echo urlencode(trim($genre)); ?>" class="genre-tag"><?php echo htmlspecialchars(trim($genre)); ?></a>
                <?php } ?>
            </p>
            <p><strong>Tình trạng:</strong> <?php echo htmlspecialchars($truyen['status']); ?></p>
            <p><strong>Ngôn ngữ gốc:</strong> <?php echo htmlspecialchars($truyen['original_language']); ?></p>
            <p><strong>Nguồn:</strong> <?php echo htmlspecialchars($truyen['source']); ?></p>
            <p><strong>Cập nhật lần cuối:</strong> <?php echo htmlspecialchars($truyen['last_update']); ?></p>
            <button class="read-now" onclick="location.href='chapter.php?id=<?php echo $first_chapter['id']; ?>'">
                <i class="fa-solid fa-eye"></i> Đọc ngay
            </button>
        </div>
    </div>
</div>


                <h2>Nội dung</h2>
                <p><?php echo nl2br(htmlspecialchars($truyen['description'])); ?></p>
                
                <h2>Danh sách chương (<?php echo $total_chapters; ?> chương)</h2>
                <table class="chapter-list">
                    <tr>
                        <th>Tên chương</th>
                        <th>Cập nhật</th>
                        <th>Nhóm dịch</th>
                    </tr>
                    <?php while ($chapter = $chapters_paginated->fetch_assoc()) { ?>
                        <tr>
                            <td><a href="chapter.php?id=<?php echo $chapter['id']; ?>">Chương <?php echo $chapter['chapter_number']; ?>: <?php echo htmlspecialchars($chapter['title']); ?></a></td>
                            <td>23/02/2025</td>
                            <td>Seikowo Team</td>
                        </tr>
                    <?php } ?>
                </table>
                
                <div class="pagination">
                    <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                        <a href="?id=<?php echo $truyen_id; ?>&page=<?php echo $i; ?>" class="<?php echo ($i == $current_page) ? 'active' : ''; ?>"><?php echo $i; ?></a>
                    <?php } ?>
                </div>

                <?php
// Xử lý lưu bình luận
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_comment"])) {
    $username = !empty($_POST["username"]) ? htmlspecialchars($_POST["username"]) : "Ẩn danh";
    $comment = htmlspecialchars($_POST["comment"]);
    
    if (!empty($comment)) {
        $stmt = $conn->prepare("INSERT INTO comments (manga_id, username, comment) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $truyen_id, $username, $comment);
        $stmt->execute();
        $stmt->close();
    }
    
    // Sau khi gửi bình luận, reload trang để hiển thị bình luận mới
    header("Location: ".$_SERVER['PHP_SELF']."?id=".$truyen_id);
    exit;
}
?>
                <div class="comment-section">
    <h3><i class="fa-solid fa-comments"></i> Bình luận</h3>

    <!-- Form nhập bình luận -->
    <form method="POST">
        <input type="text" name="username" placeholder="Tên của bạn (tuỳ chọn)" class="comment-input">
        <textarea name="comment" placeholder="Nhập bình luận của bạn..." required class="comment-textarea"></textarea>
        <button type="submit" name="submit_comment" class="comment-button">Gửi bình luận</button>
    </form>

    <!-- Hiển thị danh sách bình luận -->
    <div class="comment-list">
        <?php
        $result = $conn->query("SELECT * FROM comments WHERE manga_id = $truyen_id ORDER BY created_at DESC");
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='comment-item'>";
                echo "<strong>" . htmlspecialchars($row['username']) . "</strong>: ";
                echo "<p>" . htmlspecialchars($row['comment']) . "</p>";
                echo "<small>" . $row['created_at'] . "</small>";
                echo "</div>";
            }
        } else {
            echo "<p>Chưa có bình luận nào. Hãy là người đầu tiên!</p>";
        }
        ?>
    </div>
</div>

            </div> <!-- Kết thúc .truyen-content -->

            <!-- 🏆 THÊM LẠI BẢNG XẾP HẠNG -->
            <?php
// Xác định tab đang chọn (Top, Hot, Tháng)
$tab = isset($_GET['tab']) ? $_GET['tab'] : 'top';

// Lấy danh sách truyện theo tab
if ($tab == 'top') {
    $sql = "SELECT * FROM mangas ORDER BY views DESC LIMIT 7"; // Truyện có lượt xem nhiều nhất
} elseif ($tab == 'hot') {
    $sql = "SELECT * FROM mangas ORDER BY likes DESC LIMIT 7"; // Truyện được yêu thích nhiều nhất
} elseif ($tab == 'thang') {
    $sql = "SELECT * FROM mangas WHERE MONTH(updated_at) = MONTH(CURRENT_DATE()) ORDER BY views DESC LIMIT 7"; // Truyện có lượt đọc nhiều nhất trong tháng
} else {
    $sql = "SELECT * FROM mangas ORDER BY views DESC LIMIT 7"; // Mặc định là Top
}

$result = $conn->query($sql);
$ranking_mangas = [];
while ($row = $result->fetch_assoc()) {
    $ranking_mangas[] = $row;
}
?>

<!-- Giao diện bảng xếp hạng với tab chuyển đổi -->
<aside class="ranking">
<h2><i class="fa-solid fa-trophy" style="color: #ffcc00;"></i> Bảng xếp hạng</h2>
    <div class="ranking-tabs">
        <a href="?tab=top" class="<?php echo ($tab == 'top') ? 'active' : ''; ?>">Top</a>
        <a href="?tab=hot" class="<?php echo ($tab == 'hot') ? 'active' : ''; ?>">Hot</a>
        <a href="?tab=thang" class="<?php echo ($tab == 'thang') ? 'active' : ''; ?>">Tháng</a>
    </div>
    <ul>
        <?php foreach ($ranking_mangas as $index => $manga) { ?>
            <li>
                <span class="rank-number"><?php echo $index + 1; ?>.</span>
                <img src="<?php echo htmlspecialchars($manga['cover_image']); ?>" alt="<?php echo htmlspecialchars($manga['title']); ?>" class="ranking-image">
                <a href="truyen.php?id=<?php echo $manga['id']; ?>"><?php echo htmlspecialchars($manga['title']); ?></a>
            </li>
        <?php } ?>
    </ul>
</aside>

        </div> <!-- Kết thúc .truyen-layout -->
    </div> <!-- Kết thúc .container -->
</body>
</html>

<?php $conn->close(); ?>
