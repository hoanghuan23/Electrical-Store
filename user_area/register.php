<?php
    require('../config/config.php');
    include('../functions/common_function.php');

    if(isset($_POST["register"])) {
        $user_name = $_POST["txt_user_name"];
        $email = $_POST["txt_email"];
        $password = $_POST["txt_password"];
        // băm mật khẩu
        $hash_password = password_hash($password, PASSWORD_DEFAULT);
        $confirm_password = $_POST["txt_confirmpassword"];
        $user_ip = getIPAddress();
        $address = $_POST["txt_address"];
        $tel = $_POST["tel"];
        // $status = $_POST["txt_status"];

    if ($password !== $confirm_password) {
      echo "<script>alert('Mật khẩu và xác nhận mật khẩu không khớp')</script>";
    } else {
        $sql = "select * from tbl_users where user_name = '".$user_name."' or user_email = '".$email."' or user_ip = '".$user_ip."'";
        //  or user_ip = '".$user_ip."'
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)>0) {
            echo "<script>alert('Tên hoặc email đã tồn tại!')</script>";
        }
        else{
            $sql_insert = "INSERT INTO tbl_users (user_name, user_email, user_password, user_ip, user_address, user_mobile)
                            VALUEs('".$user_name."',
                                  '".$email."',
                                  '".$hash_password."',
                                  '".$user_ip."',
                                  '".$address."',
                                  '".$tel."'
                            )";
                            var_dump($sql_insert);            
            if (mysqli_query($conn, $sql_insert)) {
              echo "<script>alert('Đăng kí thành công')</script>";
              echo "<script>window.open('login.php','_self')</script>";
            }
            else {
                echo "Error: " .$sql . "</br>" . mysqli_error($conn); 
            }
        }
    }

    }
    if(isset($_POST["login"])) {
        header("location:login.php");
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
        <title>Register</title>
    </head>
    <body>
        <div id="register">

            <!-- Begin: Register -->
            <div class="register">
                <div class="wrapper">
                    <form action="register.php" method="post">
                        <h2 class="animate-wave">ĐĂNG KÝ</h2>
                        <div class="form-group">
                            <input type="text" name="txt_user_name" placeholder="Tên đăng nhập" required>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                            </svg>
                        </div>

                        <div class="form-group">
                            <input type="password" name="txt_password" id="password" placeholder="Mật khẩu" required>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash-fill" viewBox="0 0 16 16" onclick="togglePassword('password')">
                                <path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7 7 0 0 0 2.79-.588M5.21 3.088A7 7 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474z"/>
                                <path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12z"/>
                            </svg>
                        </div>

                        <div class="form-group">
                            <input type="password" name="txt_confirmpassword" id="confirm_password" placeholder="Xác nhận mật khẩu" required>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash-fill" viewBox="0 0 16 16" onclick="togglePassword('confirm_password')">
                                <path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7 7 0 0 0 2.79-.588M5.21 3.088A7 7 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474z"/>
                                <path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12z"/>
                            </svg>
                        </div>

                        <div class="form-group">
                            <input type="email" name="txt_email" placeholder="Email" required>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
                                <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z"/>
                            </svg>
                        </div>

                        <div class="form-group">
                            <input type="text" name="txt_address" placeholder="Địa chỉ" required>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-fill" viewBox="0 0 16 16">
                                <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5Z"/>
                                <path d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6Z"/>
                            </svg>
                        </div>

                        <div class="form-group">
                            <input type="tel" name="tel" placeholder="Số điện thoại" required pattern="[0-9]{10,}" title="Vui lòng nhập số điện thoại hợp lệ với ít nhất 10 chữ số">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                            </svg>
                        </div>

                        <input type="submit" value="Đăng ký" name="register" class="btn"/>

                        <div class="register-link">
                            <p>Bạn đã có tài khoản? <a href="login.php">Đăng nhập ngay!</a></p>
                        </div>
                    </form>
                </div>

                <div class="row return-home">
                    <a href="../page/index.php" class="btn btn-return-home">
                    <button class="btn btn-return-home">QUAY LẠI TRANG CHỦ</button>
                    </a>
                </div>
            </div>
            <!-- End: Register -->

            <!-- Footer -->
            <?php
                include '../config/footer.php';
            ?>
            <!-- End Footer -->
        </div>

        <script>
            function togglePassword(inputId) {
                const input = document.getElementById(inputId);
                const icon = input.nextElementSibling;

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
    </body>
</html>