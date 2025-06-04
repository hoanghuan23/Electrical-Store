<?php
  require('../config/config.php');
  include('../functions/common_function.php');

    session_start();
    $error_message = '';
    if(isset($_POST["login"])) {
        $username = $_POST["txt_username"];
        $password = $_POST["txt_password"];
        
        // Kiểm tra trong bảng admin
        $admin_sql = "select * from tbl_admin where ad_name ='$username'";
        $admin_result = mysqli_query($conn, $admin_sql);
        $admin_data = mysqli_fetch_assoc($admin_result);
        
        // Kiểm tra trong bảng users
        $user_sql = "select * from tbl_users where user_name ='$username'";
        $user_result = mysqli_query($conn, $user_sql);
        $user_data = mysqli_fetch_assoc($user_result);
        
        if(mysqli_num_rows($admin_result) > 0) {
            if($password == $admin_data['ad_password']) {
                $_SESSION['ad_name'] = $username;
                if(isset($admin_data['ad_id'])) {
                    $_SESSION['admin_id'] = $admin_data['ad_id'];
                }
                echo "<script>window.open('/electrician_web/admin/dashboard.php','_self')</script>";
            } else {
                $error_message = "Sai tên đăng nhập hoặc mật khẩu";
            }
        } else if(mysqli_num_rows($user_result) > 0) {
            if(password_verify($password, $user_data['user_password'])) {
                $_SESSION['username'] = $username;
                $_SESSION['user_id'] = $user_data['user_id'];
                echo "<script>window.open('/electrician_web/index.php','_self')</script>";
            } else {
                $error_message = "Sai tên đăng nhập hoặc mật khẩu";
            }
        } else {
            $error_message = "Tài khoản không tồn tại";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/electrician_web/assets/css/bootstrap.min.css">
        <link rel="icon" href="/electrician_web/assets/img/logo/logo.png">
        <link rel="stylesheet" href="/electrician_web/assets/css/style.css">
        <link rel="stylesheet" href="/electrician_web/assets/css/responsive.css">
        <script src="/electrician_web/assets/js/bootstrap.bundle.min.js"></script>
        <script src="/electrician_web/assets/js/app.js"></script>
        <title>Login</title>
        <style>
            .error-notification {
                position: fixed;
                top: 20px;
                right: 20px;
                background-color: #ff4444;
                color: white;
                padding: 15px 25px;
                border-radius: 5px;
                box-shadow: 0 2px 5px rgba(0,0,0,0.2);
                opacity: 0;
                visibility: hidden;
                transform: translateX(100%);
                transition: all 0.5s ease-out;
                z-index: 9999;
            }

            .error-notification.show {
                opacity: 1;
                visibility: visible;
                transform: translateX(0);
            }

            .error-notification .close-btn {
                position: absolute;
                right: 10px;
                top: 10px;
                cursor: pointer;
                font-size: 20px;
                color: white;
            }

            .error-notification .error-icon {
                margin-right: 10px;
                font-size: 20px;
            }
        </style>
    </head>
    <body>
        <div id="login">
            <!-- Error Notification -->
            <div class="error-notification" id="errorNotification">
                <span class="close-btn" onclick="closeError()">&times;</span>
                <span class="error-icon">⚠️</span>
                <span id="errorMessage"></span>
            </div>

            <!-- Begin: LOG IN -->
            <div class="login">
                <div class="wrapper">
                    <form action="login.php" method="post" id="loginForm">
                        <h2 class="animate-wave">ĐĂNG NHẬP</h2>
                        <div class="form-group">
                            <input type="text" name= "txt_username" placeholder="Tài khoản" required>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                            </svg>
                        </div>
                        <div class="form-group">
                            <input type="password" name="txt_password" id="password" placeholder="Mật khẩu" required>
                         
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16" onclick="togglePassword()" id="eye-open">
                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                            </svg>

                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash-fill" viewBox="0 0 16 16" onclick="togglePassword()" id="eye-close" style="display: none;">
                            <path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7 7 0 0 0 2.79-.588M5.21 3.088A7 7 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474z"/>
                            <path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12z"/>
                            </svg>
                        </div>

                        <script>
                            function togglePassword() {
                                var passwordInput = document.getElementById("password");
                                var eyeOpen = document.getElementById("eye-open");
                                var eyeClose = document.getElementById("eye-close");
                                
                                if (passwordInput.type === "password") {
                                    passwordInput.type = "text";
                                    eyeOpen.style.display = "none";
                                    eyeClose.style.display = "block";
                                } else {
                                    passwordInput.type = "password";
                                    eyeOpen.style.display = "block";
                                    eyeClose.style.display = "none";
                                }
                            }

                            function showError(message) {
                                console.log('Showing error:', message); // Debug log
                                const errorNotification = document.getElementById('errorNotification');
                                const errorMessage = document.getElementById('errorMessage');
                                
                                if (!errorNotification || !errorMessage) {
                                    console.error('Error elements not found!');
                                    return;
                                }

                                errorMessage.textContent = message;
                                errorNotification.classList.add('show');
                                
                                // Tự động ẩn sau 5 giây
                                setTimeout(() => {
                                    closeError();
                                }, 5000);
                            }

                            function closeError() {
                                const errorNotification = document.getElementById('errorNotification');
                                if (errorNotification) {
                                    errorNotification.classList.remove('show');
                                }
                            }

                            // Test error notification
                            document.addEventListener('DOMContentLoaded', function() {
                                // Kiểm tra xem có thông báo lỗi từ PHP không
                                const urlParams = new URLSearchParams(window.location.search);
                                const error = urlParams.get('error');
                                if (error) {
                                    showError(decodeURIComponent(error));
                                }
                            });
                        </script>

                        <input type="submit" value="ĐĂNG NHẬP" name="login" class="btn"/>

                        <div class="register-link">
                            <p>Không có tài khoản? <a href="register.php">Đăng ký ngay!</a></p>
                        </div>
                    </form>
                </div>

                <div class="row return-home">
                    <a href="/electrician_web/index.php" class="btn btn-return-home">
                    <button class="btn btn-return-home">QUAY LẠI TRANG CHỦ</button>
                    </a>
                </div>
            </div>
            <!-- End: Login -->

            <!-- Footer -->
            <?php
                include '../config/footer.php';
            ?>
            <!-- End Footer -->
        </div>
        <?php if (!empty($error_message)): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                showError("<?= addslashes($error_message) ?>");
            });
        </script>
        <?php endif; ?>
    </body>
</html>