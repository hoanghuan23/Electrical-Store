<?php
    require('../config/config.php'); 
    // Kiểm tra xem đã đăng nhập hay chưa
    // Nếu chưa đăng nhập thành công điều hướng về trang login. Nếu đã đăng nhập được rồi thì hiển thị
    if(!$_SESSION["ad_name"]) {
        header("location:../admin_login.php");
    }

    // Xử lý xóa đơn hàng
    if(isset($_GET['orders']) && $_GET['orders'] == 'delete' && isset($_GET['id'])) {
        $order_code = $_GET['id'];
        
        // Xóa từ bảng tbl_user_order trước
        $delete_user_order = "DELETE FROM tbl_user_order WHERE order_code = '$order_code'";
        mysqli_query($conn, $delete_user_order);
        
        // Sau đó xóa từ bảng tbl_order
        $delete_order = "DELETE FROM tbl_order WHERE order_code = '$order_code'";
        mysqli_query($conn, $delete_order);
        
        echo "<script>window.location.href='./dashboard.php?orders';</script>";
    }

    // Xử lý cập nhật đơn hàng
    if(isset($_POST['btn_update_order'])) {
        $order_code = $_POST['order_code'];
        $order_status = $_POST['order_status'];
        $order_payment_method = $_POST['order_payment_method'];
        
        // Cập nhật thông tin đơn hàng
        $update_order = "UPDATE tbl_order SET 
                         order_status = '$order_status',
                         order_payment_method = '$order_payment_method'
                         WHERE order_code = '$order_code'";
        
        mysqli_query($conn, $update_order);
        
        echo "<script>window.location.href='./dashboard.php?orders';</script>";
    }
?>

<html>
    <head>
            <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
            <script src="../../assets/js/bootstrap.bundle.min.js"></script>  
            <title>Orders - Admin Dashboard</title>
    </head>

    <body>
        <div class="container-fluid" style="margin: 0px 20px;">
            <h1>CÁC ĐƠN ĐẶT HÀNG</h1>
            <div class="row">
                <div class="col-6">
                    <form class="form-check-inline d-flex" action="./dashboard.php?orders" method="post">
                            <input class="form-control me-2" style="width: 300px;" type="text" name="txt_search" id="" placeholder="Tìm kiếm theo mã đơn hàng...">
                            <input class="btn btn-success" type="submit" value="Tìm kiếm" name="btn_search">
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <table class="table table-striped">
                        <tr>
                            <th>Mã đơn hàng</th>
                            <th>ID người đặt</th>
                            <th>Tên người đặt</th>
                            <th>Tên sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Giá trị đơn hàng</th>
                            <th>Phương thức thanh toán</th>
                            <th>Ngày đặt hàng</th>
                            <th>Trạng thái</th>
                            <th>Lựa chọn</th>
                        </tr>
                        <?php
                            $sql = "";
                            if(isset($_POST["btn_search"])) {
                                $sql = "SELECT o.*, 
                                       MAX(uo.user_name) as user_name,
                                       GROUP_CONCAT(uo.product_name SEPARATOR ', ') as product_names,
                                       SUM(uo.quantity) as total_quantity
                                       FROM tbl_order o 
                                       LEFT JOIN tbl_user_order uo ON o.order_code = uo.order_code 
                                       WHERE o.order_code LIKE '%".$_POST["txt_search"]."%'
                                       GROUP BY o.order_code, o.order_id, o.user_id, o.total_price, 
                                                o.order_payment_method, o.order_date, o.order_status";
                            }
                            else
                                $sql = "SELECT o.*, 
                                       MAX(uo.user_name) as user_name,
                                       GROUP_CONCAT(uo.product_name SEPARATOR ', ') as product_names,
                                       SUM(uo.quantity) as total_quantity
                                       FROM tbl_order o 
                                       LEFT JOIN tbl_user_order uo ON o.order_code = uo.order_code 
                                       GROUP BY o.order_code, o.order_id, o.user_id, o.total_price, 
                                                o.order_payment_method, o.order_date, o.order_status
                                       ORDER BY o.order_id ASC";                             

                            //Khai báo sql, liên kết sql hiển thị bảng
                            $result = mysqli_query($conn,$sql);               
                            if(mysqli_num_rows($result)>0) {
                                // Hiển thị các cột dữ liệu
                                while($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" .$row["order_code"] . "</td>";
                                    echo "<td>" .$row["user_id"] . "</td>";
                                    echo "<td>" .$row["user_name"] . "</td>";
                                    echo "<td>" .$row["product_names"] . "</td>";
                                    echo "<td>" .$row["total_quantity"] . "</td>";
                                    echo "<td>" .number_format($row["total_price"] , 0, ',', '.')." VND</td>";
                                    echo "<td>" .$row["order_payment_method"] . "</td>";
                                    echo "<td>" .$row["order_date"] . "</td>";
                                    echo "<td>" .$row["order_status"] . "</td>";
                                    echo "<td>
                                            <a href='#' class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#editModal".$row["order_code"]."'><i class='bi bi-pencil-square'></i></a>
                                            <a href='./dashboard.php?orders=delete&id=".$row["order_code"]."' class='btn btn-danger btn-sm' onclick='return confirm(\"Bạn có chắc chắn muốn xóa đơn hàng này?\")'><i class='bi bi-trash'></i></a>
                                          </td>";
                                    echo "</tr>";
                                    
                                    // Modal for editing order
                                    echo "<div class='modal fade' id='editModal".$row["order_code"]."' tabindex='-1' aria-labelledby='editModalLabel' aria-hidden='true'>
                                            <div class='modal-dialog'>
                                                <div class='modal-content'>
                                                    <div class='modal-header'>
                                                        <h5 class='modal-title' id='editModalLabel'>Sửa thông tin đơn hàng</h5>
                                                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                                    </div>
                                                    <form action='./dashboard.php?orders' method='post'>
                                                        <div class='modal-body'>
                                                            <input type='hidden' name='order_code' value='".$row["order_code"]."'>
                                                            <div class='mb-3'>
                                                                <label for='order_status' class='form-label'>Trạng thái đơn hàng</label>
                                                                <select class='form-select' name='order_status' id='order_status'>
                                                                    <option value='Đang xử lý' ".($row["order_status"] == "Đang xử lý" ? "selected" : "").">Đang xử lý</option>
                                                                    <option value='Đã xác nhận' ".($row["order_status"] == "Đã xác nhận" ? "selected" : "").">Đã xác nhận</option>
                                                                    <option value='Đang giao hàng' ".($row["order_status"] == "Đang giao hàng" ? "selected" : "").">Đang giao hàng</option>
                                                                    <option value='Đã giao hàng' ".($row["order_status"] == "Đã giao hàng" ? "selected" : "").">Đã giao hàng</option>
                                                                    <option value='Đã hủy' ".($row["order_status"] == "Đã hủy" ? "selected" : "").">Đã hủy</option>
                                                                </select>
                                                            </div>
                                                            <div class='mb-3'>
                                                                <label for='order_payment_method' class='form-label'>Phương thức thanh toán</label>
                                                                <select class='form-select' name='order_payment_method' id='order_payment_method'>
                                                                    <option value='Thanh toán khi nhận hàng' ".($row["order_payment_method"] == "Thanh toán khi nhận hàng" ? "selected" : "").">Thanh toán khi nhận hàng</option>
                                                                    <option value='Chuyển khoản ngân hàng' ".($row["order_payment_method"] == "Chuyển khoản ngân hàng" ? "selected" : "").">Chuyển khoản ngân hàng</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class='modal-footer'>
                                                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Đóng</button>
                                                            <button type='submit' name='btn_update_order' class='btn btn-primary'>Cập nhật</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>";
                                }
                            }
                            else {
                                if(isset($_POST["btn_search"])) {
                                    echo "<tr><td colspan='10' class='text-center'>Không tìm thấy đơn hàng nào với mã tìm kiếm này</td></tr>";
                                } else {
                                    echo "<tr><td colspan='10' class='text-center'>Chưa có đơn hàng nào</td></tr>";
                                }
                            }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>
