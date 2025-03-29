<?php
require_once __DIR__ . '/vendor/autoload.php';

use League\OAuth2\Client\Provider\Facebook;
use League\OAuth2\Client\Token\AccessToken;

session_start();

// Kiểm tra OAuth state để tránh tấn công CSRF
if (!isset($_GET['state']) || $_GET['state'] !== $_SESSION['oauth2state']) {
    unset($_SESSION['oauth2state']);
    exit('❌ Lỗi bảo mật: Trạng thái OAuth không hợp lệ!');
}

// Khởi tạo lại Facebook Provider
$provider = new Facebook([
    'clientId'          => '1161027415804256', // Thay bằng App ID của bạn
    'clientSecret'      => '3cfa28f76c2324d33e150a80154f7163', // Thay bằng App Secret
    'redirectUri'       => 'http://localhost/Comic/users/facebook-callback.php',
    'graphApiVersion'   => 'v16.0',
]);

try {
    // Lấy Access Token từ Facebook
    $accessToken = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);

    // Lấy thông tin người dùng từ Facebook Graph API
    $user = $provider->getResourceOwner($accessToken);

    $_SESSION['user_name'] = $user->getName();
    $_SESSION['user_email'] = $user->getEmail();
    $_SESSION['user_picture'] = $user->getPictureUrl();

    echo "✅ Đăng nhập thành công với Facebook!<br>";
    echo "👤 Tên: " . $_SESSION['user_name'] . "<br>";
    echo "📧 Email: " . $_SESSION['user_email'] . "<br>";
    echo "<img src='" . $_SESSION['user_picture'] . "' width='100'>";

} catch (\Exception $e) {
    exit('❌ Đăng nhập thất bại! ' . $e->getMessage());
}
?>
