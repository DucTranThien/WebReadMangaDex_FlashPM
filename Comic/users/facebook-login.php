<?php
require_once __DIR__ . '/vendor/autoload.php';

use League\OAuth2\Client\Provider\Facebook;

session_start();

// Khởi tạo Facebook OAuth Provider
$provider = new Facebook([
    'clientId'          => '1161027415804256', // Thay bằng App ID của bạn
    'clientSecret'      => '3cfa28f76c2324d33e150a80154f7163', // Thay bằng App Secret
    'redirectUri'       => 'http://localhost/Comic/users/facebook-callback.php', // Phải trùng với Redirect URI trong Facebook Developer Console
    'graphApiVersion'   => 'v16.0', // Phiên bản mới nhất của Facebook Graph API
]);

// Tạo URL đăng nhập Facebook
$authUrl = $provider->getAuthorizationUrl();
$_SESSION['oauth2state'] = $provider->getState(); // Lưu trạng thái OAuth để bảo mật

echo '<a href="' . htmlspecialchars($authUrl) . '">Đăng nhập bằng Facebook!</a>';
?>
