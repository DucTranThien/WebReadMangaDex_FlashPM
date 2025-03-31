<?php
include "../includes/db.php";
require_once "../includes/JWTHandler.php";

header("Content-Type: application/json");

// Lấy JWT từ header
$headers = getallheaders();
if (!isset($headers['Authorization'])) {
    echo json_encode(["status" => "error", "message" => "Thiếu token."]);
    exit;
}

$token = str_replace("Bearer ", "", $headers['Authorization']);
$jwt = new JWTHandler();
$decoded = $jwt->decodeToken($token);

if (!$decoded || !isset($decoded->user_id)) {
    echo json_encode(["status" => "error", "message" => "Token không hợp lệ hoặc đã hết hạn."]);
    exit;
}

$user_id = $decoded->user_id;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["avatar"])) {
    $target_dir = "../assets/avatars/";
    $allowed_types = ["jpg", "jpeg", "png", "gif"];
    $file_type = strtolower(pathinfo($_FILES["avatar"]["name"], PATHINFO_EXTENSION));

    if (!in_array($file_type, $allowed_types)) {
        echo json_encode(["status" => "error", "message" => "Chỉ chấp nhận JPG, JPEG, PNG, GIF."]);
        exit;
    }

    if ($_FILES["avatar"]["size"] > 2 * 1024 * 1024) {
        echo json_encode(["status" => "error", "message" => "Ảnh quá lớn. Tối đa 2MB."]);
        exit;
    }

    $new_file_name = "avatar_" . $user_id . "_" . time() . "." . $file_type;
    $target_file = $target_dir . $new_file_name;
    $avatar_url = "http://localhost/Comic/assets/avatars/" . $new_file_name;

    if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
        $query = "UPDATE users SET avatar_url = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $avatar_url, $user_id);

        if ($stmt->execute()) {
            session_start();
            $_SESSION["avatar_url"] = $avatar_url;

            // Tạo lại JWT mới với avatar_url mới
            $new_token = JWTHandler::generateToken([
                "user_id" => $user_id,
                "username" => $_SESSION["username"],
                "email" => $_SESSION["email"],
                "avatar_url" => $avatar_url
            ]);

            setcookie("jwt_token", $new_token, time() + 86400, "/");

            echo json_encode(["status" => "success", "message" => "Cập nhật ảnh đại diện thành công!", "avatar_url" => $avatar_url]);
        } else {
            echo json_encode(["status" => "error", "message" => "Lỗi cập nhật database."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Tải ảnh lên máy chủ thất bại."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Không có ảnh được gửi lên."]);
}
?>
