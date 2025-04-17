<?php
  require('../config/config.php');
  include('../functions/common_function.php');

    session_start();
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
                // echo "<script>alert('Đăng nhập thành công với tài khoản Admin')</script>";
                echo "<script>window.open('../admin/dashboard.php','_self')</script>";
            } else {
                echo "<script>alert('Sai tên đăng nhập hoặc mật khẩu')</script>";
            }
        } else if(mysqli_num_rows($user_result) > 0) {
            if(password_verify($password, $user_data['user_password'])) {
                $_SESSION['username'] = $username;
                $_SESSION['user_id'] = $user_data['user_id'];
                // echo "<script>alert('Đăng nhập thành công')</script>";
                echo "<script>window.open('../page/index.php','_self')</script>";
            } else {
                echo "<script>alert('Sai tên đăng nhập hoặc mật khẩu')</script>";
            }
        } else {
            echo "<script>alert('Tài khoản không tồn tại')</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/css/style.css">
        <link rel="stylesheet" href="../assets/css/responsive.css">
        <script src="../assets/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/js/app.js"></script>
        <title>Login</title>
    </head>
    <body>
        <div id="login">

            <!-- Begin: LOG IN -->
            <div class="login">
                <div class="wrapper">
                    <form action="login.php" method="post">
                        <h2 class="animate-wave">ĐĂNG NHẬP</h2>
                        <div class="form-group">
                            <input type="text" name= "txt_username" placeholder="Tài khoản" required>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                            </svg>
                        </div>

                        <div class="form-group">
                            <input type="password" name="txt_password" id="password" placeholder="Mật khẩu" required>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash-fill" viewBox="0 0 16 16" onclick="togglePassword()">
                                <path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7 7 0 0 0 2.79-.588M5.21 3.088A7 7 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474z"/>
                                <path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12z"/>
                            </svg>
                            <script>
                                function togglePassword() {
                                   const input = document.getElementById('password');
                                   const icon = document.querySelector('.bi');

                                   if (input.type === 'password') {
                                    input.type = 'text';
                                    icon.classList.remove("bi-eye-slash-fill");
                                    icon.classList.add("bi-eye-fill");
                                } else {
                                    input.type = 'password';
                                    icon.classList.remove("bi-eye-fill");
                                    icon.classList.add("bi-eye-slash-fill");
                                }
                                }
                            </script>
                        </div>

                        <div class="remember-forgot">
                            <label><input type="checkbox" name="" id="">Nhớ tài khoản</label>
                            <a href="#">Quên mật khẩu?</a>
                        </div>

                        <input type="submit" value="ĐĂNG NHẬP" name="login" class="btn"/>

                        <div class="register-link">
                            <p>Không có tài khoản? <a href="register.php">Đăng ký ngay!</a></p>
                        </div>
                    </form>
                </div>

                <div class="row return-home">
                    <a href="../page/index.php" class="btn btn-return-home">
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
    </body>
</html>