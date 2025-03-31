<?php
require_once __DIR__ . '/vendor/autoload.php';

session_start();

$client = new Google_Client();
$client->setClientId('960991411828-2qhudvk4gu7a0tvqi716svh2kgd6o015.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('http://localhost/Comic/users/google-callback.php'); // Đổi đường dẫn nếu cần
$client->addScope("email");
$client->addScope("profile");
$client->setPrompt('select_account');

$auth_url = $client->createAuthUrl();
header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
exit();
?>
