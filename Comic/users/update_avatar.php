<?php
session_start();
include "../includes/db.php";

if (!isset($_SESSION["user_id"])) {
    die(json_encode(["status" => "error", "message" => "Bạn chưa đăng nhập."]));
}

$user_id = $_SESSION["user_id"];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["avatar"])) {
    $target_dir = "../assets/avatars/";

    // Kiểm tra định dạng file
    $allowed_types = ["jpg", "jpeg", "png", "gif"];
    $file_type = strtolower(pathinfo($_FILES["avatar"]["name"], PATHINFO_EXTENSION));

    if (!in_array($file_type, $allowed_types)) {
        die(json_encode(["status" => "error", "message" => "Chỉ chấp nhận định dạng JPG, JPEG, PNG, GIF."]));
    }

    // Kiểm tra kích thước file (tối đa 2MB)
    if ($_FILES["avatar"]["size"] > 2 * 1024 * 1024) {
        die(json_encode(["status" => "error", "message" => "Dung lượng ảnh quá lớn. Chọn ảnh dưới 2MB."]));
    }

    // Tạo tên file mới để tránh trùng lặp
    $new_file_name = "avatar_" . $user_id . "_" . time() . "." . $file_type;
    $target_file = $target_dir . $new_file_name;

    // Di chuyển file vào thư mục
    if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
        $avatar_url = "http://localhost/Comic/assets/avatars/" . $new_file_name;

        // Cập nhật avatar_url trong database
        $query = "UPDATE users SET avatar_url = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $avatar_url, $user_id);
        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Cập nhật ảnh đại diện thành công!", "avatar_url" => $avatar_url]);
        } else {
            echo json_encode(["status" => "error", "message" => "Lỗi khi cập nhật database."]);
        }
        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Lỗi khi tải ảnh lên máy chủ."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Không có ảnh được chọn."]);
}
?>
