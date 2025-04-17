<?php
session_start();

// session_unset();

// Hủy bỏ session
session_destroy();

// Chuyển hướng về trang đăng nhập hoặc trang chính của bạn
echo "<script>window.open('../page/index.php','_self')</script>";
// header("Location: ../user_area/login.php");
exit();
?>

