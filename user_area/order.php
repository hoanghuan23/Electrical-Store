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

    $get_ip_address = getIPAddress();
    $total_price = 0;
    $total_quantity = 0;
    $cart_query_price = "SELECT * FROM `tbl_cart_detail` where ip_address = '$user_ip'";
    $result_cart_price = mysqli_query($conn,$cart_query_price);

    // Trạng thái đơn hàng
    $status = 'Đang xử lý';

    $count_product = mysqli_num_rows($result_cart_price);
    
    // Kiểm tra xem có sản phẩm trong giỏ hàng không
    if($count_product == 0) {
        echo "<script>alert('Giỏ hàng trống!')</script>";
        echo "<script>window.location.href='../page/cart.php'</script>";
        exit();
    }

    // Xử lý từng sản phẩm trong giỏ hàng
    while($row_price = mysqli_fetch_array($result_cart_price)) {
        $product_id = $row_price['product_id'];
        $select_product = "SELECT * FROM `tbl_product` where product_id = $product_id";
        $run_price = mysqli_query($conn,$select_product);
        while($row_prd_price = mysqli_fetch_array($run_price)) {
            $product_name = $row_prd_price['product_name'];
            $prd_pr = $row_prd_price['product_price'];
            $current_stock = $row_prd_price['product_quantity'];

            $sql = "SELECT * FROM `tbl_cart_detail` WHERE product_id = '$product_id'";
            $result_qty = mysqli_query($conn, $sql);
            while($row_cart=mysqli_fetch_array($result_qty)) {
                $quantity = $row_cart['quantity'];
                
                $total_quantity += $quantity; 
                $prd_qty_price = $prd_pr * $quantity;
                $prd_price = array(($prd_pr * $row_cart['quantity']));
                $product_value = array_sum($prd_price);
                $total_price = $total_price + $product_value;

                // Tạo order_code duy nhất cho mỗi sản phẩm
                $unique_order_code = $order_code . '_' . $product_id;
                
                // Insert vào tbl_user_order với order_code duy nhất
                $insert_user_order = "INSERT INTO `tbl_user_order` (order_code, user_id, product_id, product_name, user_name, quantity) 
                    VALUES ('$unique_order_code', $user_id, $product_id, '$product_name', '$user_name', $quantity)";
                $result_user_order = mysqli_query($conn, $insert_user_order);
                if (!$result_user_order) {
                    die("<script>alert('Lỗi khi lưu đơn hàng: " . mysqli_error($conn) . "')</script>");
                }

                // Cập nhật số lượng sản phẩm trong kho
                $new_stock = $current_stock - $quantity;
                $update_stock = "UPDATE `tbl_product` SET product_quantity = $new_stock WHERE product_id = $product_id";
                if (!mysqli_query($conn, $update_stock)) {
                    mysqli_query($conn, "DELETE FROM tbl_user_order WHERE order_code = '$unique_order_code'");
                    die("<script>alert('Lỗi khi cập nhật số lượng sản phẩm: " . mysqli_error($conn) . "')</script>");
                }
            }
        }
    }

    $insert_user_contact = "INSERT INTO `tbl_user_contact` (user_id, order_code, user_name, user_email, user_phone, user_address, user_note) 
        VALUES ($user_id, '$order_code', '$user_name', '$user_email', '$user_phone', '$user_address', '$user_note')";
    $result_contact = mysqli_query($conn, $insert_user_contact);
    if (!$result_contact) {
        // Nếu lỗi, xóa các bản ghi đã insert vào tbl_user_order
        mysqli_query($conn, "DELETE FROM tbl_user_order WHERE order_code LIKE '$order_code%'");
        die("<script>alert('Lỗi khi lưu thông tin liên hệ: " . mysqli_error($conn) . "')</script>");
    }
    
    // lưu dữ liệu đặt hàng bao gồm order_code, tổng tiền sản phẩm, phương thức thanh toán, ngày đặt hàng
    $insert_order = "INSERT INTO `tbl_order` (user_id, order_code, total_price, order_payment_method, order_date, order_status)
                        VALUES ($user_id, $order_code, $total_price, '$order_payment_method', NOW(), '$status')";
    if (!mysqli_query($conn, $insert_order)) {
        // Nếu lỗi, xóa các bản ghi đã insert
        mysqli_query($conn, "DELETE FROM tbl_user_order WHERE order_code = $order_code");
        die("<script>alert('Lỗi khi lưu thông tin đơn hàng: " . mysqli_error($conn) . "')</script>");
    }

    // Xóa sản phẩm trong giỏ hàng
    $empty_cart = "DELETE FROM `tbl_cart_detail` WHERE ip_address='$get_ip_address'";
    $result_delete = mysqli_query($conn, $empty_cart);

    echo "<script>alert('Đặt hàng thành công!')</script>";
    echo "<script>window.location.href='order.php?user_id=$user_id'</script>";
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
