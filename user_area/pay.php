<?php
  require('../config/config.php');
  include('../functions/common_function.php');
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán đơn hàng</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .container {
            max-width: 800px;
            margin: 30px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .qr-image {
            width: 250px;
            height: 250px;
            background-image: url('../assets/img/bank/QR_Code.png');
            background-size: contain;
            background-repeat: no-repeat;
            margin: 20px auto;
        }
        .bank-info {
            margin: 20px 0;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .download-btn {
            display: inline-block;
            padding: 8px 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .download-btn:hover {
            background-color: #0069d9;
            color: white;
        }
        .btn_pay {
            padding: 10px 20px;
            background-color: rgba(236, 133, 65, 0.99);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <?php include('../config/header.php');

if(isset($_POST['order'])) {
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
    $order_id = isset($_SESSION['order_id']) ? $_SESSION['order_id'] : (isset($_POST['order_id']) ? $_POST['order_id'] : '');
    $user_ip = getIPAddress();

    if ($order_id) {
        // Bắt đầu transaction
        mysqli_begin_transaction($conn);
        
        try {
            // Kiểm tra đơn hàng đã tồn tại chưa
            $check_order = "SELECT * FROM tbl_order WHERE order_code = '$order_code'";
            $result_check = mysqli_query($conn, $check_order);
            
            if(mysqli_num_rows($result_check) > 0) {
                throw new Exception("Đơn hàng này đã được xử lý!");
            }

            // Lấy thông tin người dùng
            $get_user = "SELECT * FROM tbl_users WHERE user_id = '$user_id'";
            $result_user = mysqli_query($conn, $get_user);
            if(!$result_user) {
                throw new Exception("Không tìm thấy thông tin người dùng!");
            }
            $user_data = mysqli_fetch_assoc($result_user);

            // Lấy thông tin giỏ hàng
            $cart_query = "SELECT * FROM tbl_cart_detail WHERE ip_address = '$user_ip'";
            $result_cart = mysqli_query($conn, $cart_query);
            if(!$result_cart) {
                throw new Exception("Không tìm thấy thông tin giỏ hàng!");
            }

            $total_price = 0;
            $total_quantity = 0;

            // Xử lý từng sản phẩm trong giỏ hàng
            while ($cart_item = mysqli_fetch_assoc($result_cart)) {
                $product_id = $cart_item['product_id'];
                $quantity = $cart_item['quantity'];

                $product_query = "SELECT * FROM tbl_product WHERE product_id = '$product_id'";
                $result_product = mysqli_query($conn, $product_query);
                if(!$result_product) {
                    throw new Exception("Không tìm thấy thông tin sản phẩm!");
                }
                $product_data = mysqli_fetch_assoc($result_product);

                // Kiểm tra số lượng tồn kho
                if($product_data['product_quantity'] < $quantity) {
                    throw new Exception("Sản phẩm {$product_data['product_name']} không đủ số lượng trong kho!");
                }

                $product_name = $product_data['product_name'];
                $product_price = $product_data['product_price'];
                $total_price += $product_price * $quantity;
                $total_quantity += $quantity;

                // Thêm vào bảng user_order
                $insert_order = "INSERT INTO tbl_user_order (order_code, user_id, product_id, product_name, user_name, quantity) 
                                VALUES ('$order_id', '$user_id', '$product_id', '$product_name', '{$user_data['user_name']}', '$quantity')";
                if(!mysqli_query($conn, $insert_order)) {
                    throw new Exception("Lỗi khi thêm thông tin đơn hàng chi tiết!");
                }

                // Cập nhật số lượng tồn kho
                $new_stock = $product_data['product_quantity'] - $quantity;
                $update_stock = "UPDATE tbl_product SET product_quantity = '$new_stock' WHERE product_id = '$product_id'";
                if(!mysqli_query($conn, $update_stock)) {
                    throw new Exception("Lỗi khi cập nhật số lượng tồn kho!");
                }
            }

            // Thêm vào bảng order
            $insert_main_order = "INSERT INTO tbl_order (user_id, order_code, total_price, order_payment_method, order_date, order_status)
                                VALUES ('$user_id', '$order_id', '$total_price', 'Chuyển khoản ngân hàng', NOW(), 'Đang xử lý')";
            if(!mysqli_query($conn, $insert_main_order)) {
                throw new Exception("Lỗi khi thêm thông tin đơn hàng!");
            }

            // Thêm vào bảng user_contact
            $insert_contact = "INSERT INTO tbl_user_contact (user_id, order_code, user_name, user_email, user_phone, user_address)
                            VALUES ('$user_id', '$order_id', '{$user_data['user_name']}', '{$user_data['user_email']}', '{$user_data['user_mobile']}', '{$user_data['user_address']}')";
            if(!mysqli_query($conn, $insert_contact)) {
                throw new Exception("Lỗi khi thêm thông tin liên hệ!");
            }

            // Xóa giỏ hàng
            $clear_cart = "DELETE FROM tbl_cart_detail WHERE ip_address = '$user_ip'";
            if(!mysqli_query($conn, $clear_cart)) {
                throw new Exception("Lỗi khi xóa giỏ hàng!");
            }

            // Commit transaction nếu mọi thứ OK
            mysqli_commit($conn);

            // Xóa session
            unset($_SESSION['order_id']);
            unset($_SESSION['total_price']);

            echo "<script>alert('Cảm ơn bạn đã thanh toán! Đơn hàng đang được xử lý.');</script>";
            echo "<script>window.location.href='order.php?user_id=" . $user_id . "';</script>";

        } catch (Exception $e) {
            // Rollback nếu có lỗi
            mysqli_rollback($conn);
            echo "<script>alert('" . $e->getMessage() . "');</script>";
            echo "<script>window.location.href='checkout.php';</script>";
        }

    } else {
        echo "<script>alert('Không tìm thấy thông tin đơn hàng!');</script>";
        echo "<script>window.location.href='checkout.php';</script>";
    }
}
    // Lấy thông tin giá từ session
    $tongtien = isset($_SESSION['total_price']) ? $_SESSION['total_price'] : 0;
    
    // Lấy thông tin người dùng
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
    $get_user = "SELECT * FROM tbl_users WHERE user_id = '$user_id'";
    $result_user = mysqli_query($conn, $get_user);
    $user_data = mysqli_fetch_assoc($result_user);
    
    // Lấy mã đơn hàng từ session
    $order_id = isset($_SESSION['order_id']) ? $_SESSION['order_id'] : 'DH' . time();
    ?>
    
    <div class="container">
        <h2 class="text-center mb-4">QR Chuyển khoản ngân hàng</h2>
        <P class="text-center">GHI ĐÚNG NỘI DUNG CHUYỂN KHOẢN</P>
        <div class="qr-image"></div>
        <div class="text-center">
            <a href="../assets/img/bank/QR_Code.png" download class="download-btn">
                <i class="fa fa-download"></i> Tải ảnh QR
            </a>
        </div>
        <div class="bank-info">
            <p><strong>Ngân hàng:</strong> TPbank</p>
            <p><strong>Thụ hưởng:</strong> HOANG VAN HUAN</p>
            <p><strong>Số tài khoản:</strong> 0374582895</p>
            <p><strong>Số tiền:</strong> <?php echo number_format($tongtien, 0, ',', '.'); ?> VNĐ</p>
            <p><strong>Nội dung:</strong> <?php echo $order_id . " - " . $user_data['user_name']; ?></p>
        </div>
        <div class="text-center">
            <form action="" method="post">
                <input type="hidden" name="tongtien" value="<?php echo $tongtien; ?>">
                <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                <button class="btn_pay" type="submit" name="order">Tôi đã thanh toán</button>
            </form>
        </div>
    </div>
    
    <?php include('../config/footer.php'); ?>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>