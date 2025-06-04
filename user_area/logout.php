<?php
session_start();

// session_unset();

// Hủy bỏ session
session_destroy();

// Chuyển hướng về trang đăng nhập hoặc trang chính của bạn
echo "<script>window.open('/electrician_web/index.php','_self')</script>";
exit();
?>

