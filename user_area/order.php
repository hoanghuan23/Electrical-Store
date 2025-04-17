<?php
  require('../config/config.php');
  include('../functions/common_function.php');
?>

<?php
  if(isset($_POST['complete_order'])) {
    $user_id = $_POST['user_id'];
    $user_ip = $_POST['user_ip'];
    $user_name = $_POST['customerName'];
    $user_phone = $_POST['customerPhone'];
    $user_email = $_POST['customerEmail'];
    $user_address = $_POST['customerAddress'];
    $user_note = $_POST['customerNote'];

    $order_payment_method = $_POST['payment'];

    // mã hóa đơn ngẫu nhiên
    $order_code = mt_rand();


    // Liên hệ người dùng
    $insert_user_contact = "INSERT INTO `tbl_user_contact` (user_id,order_code,user_name,user_email,user_phone,user_address,user_note)
                                VALUES($user_id, $order_code, '$user_name', '$user_email', '$user_phone', '$user_address', '$user_note')";
    $result_contact=mysqli_query($conn, $insert_user_contact);   

    $get_ip_address = getIPAddress();
    $total_price = 0;
    $total_quantity = 0;
    $cart_query_price = "SELECT * FROM `tbl_cart_detail` where ip_address = '$user_ip'";
    $result_cart_price = mysqli_query($conn,$cart_query_price);

    // Trạng thái đơn hàng
    $status = 'Thành công';

    $count_product = mysqli_num_rows($result_cart_price);
    while($row_price = mysqli_fetch_array($result_cart_price)) {
        $product_id = $row_price['product_id'];
        $select_product = "SELECT * FROM `tbl_product` where product_id = $product_id";
        $run_price = mysqli_query($conn,$select_product);
        while($row_prd_price = mysqli_fetch_array($run_price)) {
            $product_name = $row_prd_price['product_name'];
            $prd_pr = $row_prd_price['product_price'];

            $sql = "SELECT * FROM `tbl_cart_detail` WHERE product_id = '$product_id'";
            $result_qty = mysqli_query($conn, $sql);
            while($row_cart=mysqli_fetch_array($result_qty)) {
                $quantity = $row_cart['quantity'];
                $total_quantity += $quantity; 
                $prd_qty_price = $prd_pr * $quantity;
                $prd_qty_price = number_format($prd_qty_price, 0, ',', '.');
                $prd_price = array(($prd_pr * $row_cart['quantity']));
                $product_value = array_sum($prd_price);
                $total_price = $total_price + $product_value;
                
                // Sửa câu lệnh INSERT để thêm tên người đặt và tên sản phẩm
                $insert_user_order = "INSERT INTO `tbl_user_order`
                    (order_code, user_id, product_id, product_name, user_name, quantity)
                    VALUES($order_code, $user_id, $product_id, '$product_name', '$user_name', $quantity)";
                $result_user_order = mysqli_query($conn, $insert_user_order);
            }
        }
    }
    
    // lưu dữ liệu đặt hàng bao gồm order_code, tổng tiền sản phẩm, phương thức thanh toán, ngày đặt hàng
    $insert_order = "INSERT INTO `tbl_order` (user_id, order_code, total_price, order_payment_method, order_date, order_status)
                        VALUES ($user_id,$order_code, $total_price, '$order_payment_method', NOW(), '$status')";
    if (mysqli_query($conn, $insert_order)) {
        echo "<script>alert('Đã đặt hàng thành công')</script>";
    }


    // Đặt hàng xong lưu thông tin người nhận
    // Xóa sản phẩm trong giỏ hàng
    $empty_cart = "DELETE FROM `tbl_cart_detail` WHERE ip_address='$get_ip_address'";
    $result_delete = mysqli_query($conn, $empty_cart);

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/responsive.css">
    <link rel="stylesheet" href="../assets/css/order.css">
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/app.js"></script>        
    <title>Order</title>
</head>
<body>
    <div id="order">
    <?php
        include '../config/header.php';
    ?>
        <div class="order container-fluid">
                <!-- <h3>THÔNG TIN ĐƠN HÀNG</h3> -->
            <div class="row title-success">
                <!-- <div class="col-4 border-left"></div> -->
                <div class="col-4">
                    <img src="./../assets/img/order/title_success.jpg" alt="">
                </div>
                <!-- <div class="col-4 border-right"></div> -->
            </div>

            <div class="row going">
                <p>Chúng tôi sẽ giao hàng đến bạn sớm nhất!</p>
            </div>    

            <div class="row content-order">
                <?php
                // chi tiết đơn hàng người dùng đặt
                    get_user_order_detail();
                ?>
            </div>

            <div class="row complete-order">
                <div class="col-3"></div>
                <div class="col-6">
                    <img src="./../assets/img/order/icon_dat_hang_thanh_cong.svg" alt="">
                </div>
                <div class="col-3"></div>

            </div>
            <div class="row thanku">
                <p>
                    CUỘC SỐNG CÓ NHIỀU LỰA CHỌN. CẢM ƠN VÌ ĐÃ CHỌN CHÚNG TÔI
                </p>
            </div>

            <div class="continue-purchase">
                <a href="../page/product.php">
                    <button>
                        TIẾP TỤC MUA HÀNG
                    </button>
                </a>
            </div>

        </div>
    </div>
    
    <?php
        include '../config/footer.php';
    ?>
</body>
</html>
