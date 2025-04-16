<?php
require_once "../includes/db.php";
require_once "../includes/JWTHandler.php";
require_once "../vendor/autoload.php";

use League\OAuth2\Client\Provider\Facebook;

session_start();

$provider = new Facebook([
    'clientId' => '1161027415804256',
    'clientSecret' => '3cfa28f76c2324d33e150a80154f7163',
    'redirectUri' => 'http://localhost/Comic/users/facebook-callback.php',
    'graphApiVersion' => 'v17.0',
]);

if (!isset($_GET['code'])) {
    exit('No code provided from Facebook.');
}

try {
    // Lấy access token
    $accessToken = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);

    // Lấy thông tin người dùng từ Graph API
    $facebookUser = $provider->getResourceOwner($accessToken);
    $userData = $facebookUser->toArray();

    $email = $userData['email'] ?? null;
    $name = $userData['name'] ?? 'FacebookUser';
    $avatar = "https://graph.facebook.com/{$userData['id']}/picture?type=large";

    if (!$email) {
        exit('Email is required from Facebook login.');
    }

    // Kiểm tra nếu user đã tồn tại
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        // Đã tồn tại → lấy thông tin user
        $user_id = $user['id'];
        $username = $user['username'];
        $avatar_url = $user['avatar_url'];
    } else {
        // Chưa có → thêm mới user
        $stmtInsert = $conn->prepare("INSERT INTO users (username, email, avatar_url, login_method) VALUES (?, ?, ?, 'facebook')");
        $stmtInsert->bind_param("sss", $name, $email, $avatar);
        $stmtInsert->execute();
        $user_id = $stmtInsert->insert_id;
        $username = $name;
        $avatar_url = $avatar;
    }

    // Tạo JWT token
    $token = JWTHandler::generateToken([
        "user_id" => $user_id,
        "username" => $username,
        "email" => $email,
        "avatar_url" => $avatar_url,
        "login_method" => "facebook"
    ]);

    // Lưu vào session
    $_SESSION['user_id'] = $user_id;
    $_SESSION['username'] = $username;
    $_SESSION['email'] = $email;
    $_SESSION['avatar_url'] = $avatar_url;
    $_SESSION['login_method'] = 'facebook';

    // Lưu JWT vào cookie
    setcookie("jwt_token", $token, time() + 86400, "/");

    // Về trang chủ
    header("Location: ../pages/index.php");
    exit;

} catch (Exception $e) {
    exit("Facebook Login Error: " . $e->getMessage());
}
?>
