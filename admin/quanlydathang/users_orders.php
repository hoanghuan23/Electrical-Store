<?php
    require('../config/config.php'); 
    // Kiểm tra xem đã đăng nhập hay chưa
    // Nếu chưa đăng nhập thành công điều hướng về trang login. Nếu đã đăng nhập được rồi thì hiển thị
    if(!$_SESSION["ad_name"]) {
        header("location:../admin_login.php");
    }

?>

<html>
    <head>
            <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
            <script src="../../assets/js/bootstrap.bundle.min.js"></script>  
            <link rel="stylesheet" href="../css/styleadmin.css">        
            <title>Users - Admin Dashboard</title>
    </head>

    <body>
        <div class="container-fluid">
            <h1>Danh sách người dùng đặt hàng</h1>
            <div class="row">
                <div class="col-6">
                    <form class="form-check-inline mb-3" action="./dashboard.php?users_orders" method="post">
                        <input class="form-control" style="width: 300px;" type="text" name="txt_search" id="" placeholder="Tìm kiếm theo iD...">
                        <br>
                        <input class="btn btn-success" type="submit" value="Tìm kiếm" name="btn_search">
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <table class="table table-striped">
                        <tr>
                            <th>ID người đặt</th> 
                            <th>Mã đơn hàng</th>
                            <th>Mã sản phẩm</th>
                            <th>Số lượng</th>
                        </tr>
                        <?php
                            $sql = "";
                            if(isset($_POST["btn_search"])) {
                                $sql = "select * from tbl_user_order where user_id like '%".$_POST["txt_search"]."%'";
                            } else {
                                $sql = "select * from tbl_user_order";                             
                            }
                            // Khai báo sql, liên kết sql hiển thị bảng
                            $result = mysqli_query($conn,$sql);               
                            if(mysqli_num_rows($result)>0) {
                                // Hiển thị các cột dữ liệu
                                while($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" .$row["user_id"] . "</td>";
                                    echo "<td>" .$row["order_code"] . "</td>";
                                    echo "<td>" .$row["product_id"] . "</td>";
                                    echo "<td>" .$row["quantity"] . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<script>alert('Không tìm thấy người dùng này')</script>";
                                echo "<script>window.open('./dashboard.php?users_orders','_self')</script>";
                            }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>
