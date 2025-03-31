<?php
session_start();

// Hủy toàn bộ session
session_unset();
session_destroy();

// Xóa JWT token (cookie)
setcookie("jwt_token", "", time() - 3600, "/");

// Quay về trang chủ
header("Location: ../pages/index.php");
exit();
?>
