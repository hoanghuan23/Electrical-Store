<?php
  require('../config/config.php');
  include('../functions/common_function.php');

  if(isset($_POST['order'])) {
    echo "<script>alert('Cảm ơn bạn đã thanh toán! Đơn hàng của bạn đang được xử lý.');</script>";
    echo "<script>window.location.href='order.php?user_id=$user_id';</script>";
  }
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