<?php
require_once "../includes/db.php";
require_once "../includes/JWTHandler.php";
require_once "../vendor/autoload.php";

use Google\Client;

session_start();

$client = new Client();
$client->setClientId("960991411828-2qhudvk4gu7a0tvqi716svh2kgd6o015.apps.googleusercontent.com");
$client->setClientSecret("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");
$client->setRedirectUri("http://localhost/Comic/users/google-callback.php");
$client->addScope("email");
$client->addScope("profile");

// Lấy code từ Google redirect
if (!isset($_GET['code'])) {
    exit("No code returned from Google.");
}

try {
    // Lấy access token từ Google
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

    if (isset($token['error'])) {
        exit("Google OAuth Error: " . $token['error_description']);
    }

    $client->setAccessToken($token['access_token']);

    // Lấy thông tin user từ Google
    $oauth = new Google\Service\Oauth2($client);
    $googleUser = $oauth->userinfo->get();

    $email = $googleUser->email ?? null;
    $name = $googleUser->name ?? 'GoogleUser';
    $avatar = $googleUser->picture ?? '';

    if (!$email) {
        exit("Email not available from Google.");
    }

    // Kiểm tra nếu đã tồn tại user
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        $user_id = $user['id'];
        $username = $user['username'];
        $avatar_url = $user['avatar_url'];
    } else {
        // Thêm mới user
        $stmtInsert = $conn->prepare("INSERT INTO users (username, email, avatar_url, login_method) VALUES (?, ?, ?, 'google')");
        $stmtInsert->bind_param("sss", $name, $email, $avatar);
        $stmtInsert->execute();
        $user_id = $stmtInsert->insert_id;
        $username = $name;
        $avatar_url = $avatar;
    }

    // Tạo JWT token
    $jwt = JWTHandler::generateToken([
        "user_id" => $user_id,
        "username" => $username,
        "email" => $email,
        "avatar_url" => $avatar_url,
        "login_method" => "google"
    ]);

    // Lưu session
    $_SESSION['user_id'] = $user_id;
    $_SESSION['username'] = $username;
    $_SESSION['email'] = $email;
    $_SESSION['avatar_url'] = $avatar_url;
    $_SESSION['login_method'] = 'google';

    // Lưu cookie
    setcookie("jwt_token", $jwt, time() + 86400, "/");

    // Redirect về trang chủ
    header("Location: ../pages/index.php");
    exit;

} catch (Exception $e) {
    exit("Google Login Failed: " . $e->getMessage());
}
?>
