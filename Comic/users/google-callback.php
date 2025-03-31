<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/../includes/JWTHandler.php';
use Google\Service\Oauth2;

session_start();
include __DIR__ . '/../includes/db.php'; // Kết nối CSDL

// Khởi tạo Google Client
$client = new Google_Client();
$client->setClientId('960991411828-2qhudvk4gu7a0tvqi716svh2kgd6o015.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('http://localhost/Comic/users/google-callback.php');
$client->addScope("email");
$client->addScope("profile");

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

    if (isset($token['error'])) {
        echo "❌ Lỗi khi lấy Access Token: " . $token['error'];
        exit();
    }

    $client->setAccessToken($token);
    $oauth2 = new Oauth2($client);
    $userInfo = $oauth2->userinfo->get();

    // Gán biến
    $email = $userInfo->email;
    $name = $userInfo->name;
    $avatar = $userInfo->picture;

    // Kiểm tra người dùng đã tồn tại chưa
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 0) {
        // Tạo tài khoản mới nếu chưa có
        $stmt->close();
        $stmt = $conn->prepare("INSERT INTO users (username, email, avatar_url, login_method, created_at) VALUES (?, ?, ?, 'google', NOW())");
        $stmt->bind_param("sss", $name, $email, $avatar);
        $stmt->execute();
    }
    $stmt->close();

    // Lấy lại ID người dùng
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($user_id);
    $stmt->fetch();
    $stmt->close();

    // Tạo JWT
    $jwt = new JWTHandler();
    $token = $jwt::generateToken([
        "user_id" => $user_id,
        "username" => $name,
        "email" => $email,
        "avatar_url" => $avatar,
        "login_method" => "google"
    ]);

    // Lưu vào SESSION & COOKIE
    $_SESSION['user_id'] = $user_id;
    $_SESSION['username'] = $name;
    $_SESSION['email'] = $email;
    $_SESSION['avatar_url'] = $avatar;
    $_SESSION['login_method'] = 'google';

    setcookie("jwt_token", $token, time() + 86400, "/");

    // Chuyển hướng về trang chính
    header("Location: ../pages/index.php");
    exit();
} else {
    echo "❌ Đăng nhập thất bại!";
}
