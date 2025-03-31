<?php
session_start();

// Thông tin Facebook App
$appId = '1161027415804256';
$appSecret = '3cfa28f76c2324d33e150a80154f7163';
$redirectUri = 'http://localhost/Comic/users/facebook-callback.php';

// Kết nối CSDL
$conn = new mysqli('localhost', 'root', 'abcd', 'comic_db1');
if ($conn->connect_error) {
    die("❌ Kết nối CSDL thất bại: " . $conn->connect_error);
}

// Nếu có mã code từ Facebook
if (isset($_GET['code'])) {
    $code = $_GET['code'];

    // Lấy access token
    $token_url = "https://graph.facebook.com/v18.0/oauth/access_token?" . http_build_query([
        'client_id' => $appId,
        'redirect_uri' => $redirectUri,
        'client_secret' => $appSecret,
        'code' => $code
    ]);
    $token_data = json_decode(file_get_contents($token_url), true);

    if (isset($token_data['access_token'])) {
        $access_token = $token_data['access_token'];

        // Lấy thông tin người dùng
        $user_info_url = "https://graph.facebook.com/me?fields=id,name,email,picture&access_token={$access_token}";
        $user = json_decode(file_get_contents($user_info_url));

        // Chuẩn bị dữ liệu
        $username = $conn->real_escape_string($user->name ?? '');
        $email = $conn->real_escape_string($user->email ?? '');
        $avatar = $conn->real_escape_string($user->picture->data->url ?? '');
        $login_method = 'facebook';

        // Kiểm tra người dùng đã tồn tại chưa
        $check = $conn->query("SELECT * FROM users WHERE email = '$email'");
        if ($check->num_rows == 0) {
            // Thêm người dùng mới
            $sql = "INSERT INTO users (username, email, password, avatar_url, login_method)
        VALUES ('$username', '$email', '', '$avatar', '$login_method')";

            $conn->query($sql);
        }

        // Lưu session (giống Google)
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_name'] = $username;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_avatar'] = $avatar;

        // Chuyển về trang index
        header("Location: ../pages/index.php");
        exit;
    } else {
        echo "❌ Không lấy được access token từ Facebook.";
    }
} else {
    echo "❌ Không có mã code từ Facebook.";
}
