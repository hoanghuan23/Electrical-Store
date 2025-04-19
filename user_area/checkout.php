<?php
  require('../config/config.php');
  include('../functions/common_function.php');
//   if(isset($_POST['update_address'])) {
//     $user_id = $_POST['update_add_user'];
//     $user_mobile = $_POST['customerPhone'];
//     $user_address = $_POST['customerAddress'];
//     $sql_update = "update tbl_users set user_mobile = N'".$user_mobile."', user_address = ".$user_address." where user_id =" .$user_id;

//   }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Check-out</title>
        <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/css/style.css">
        <link rel="stylesheet" href="../assets/css/responsive.css">
        <link rel="stylesheet" href="../assets/css/checkout.css">
        <script src="../assets/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/js/app.js"></script>        
    </head>
    <body>
        <?php
            include '../config/header.php';
        ?>
        
        <div id="checkout">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6 col-md-6 col-lg-6 left">
                        <div class="thongtin">
                            <h4><label>THÔNG TIN GIAO HÀNG</label></h4>
                        </div>
                        <!-- <form action="order.php" method = "POST"> -->
                        <?php
                            // if (isset($_SESSION['username'])) {
                                // checkout();
                            // }
                            $total_price = 0;
                            if(isset($_GET["task"]) && $_GET["task"]=="checkout") {
                                if(isset($_SESSION['username'])) {
                                    $user_id = $_SESSION['user_id'];
                                    $user_ip = getIPAddress();
                                    $select_query="SELECT * FROM tbl_users where user_id = '$user_id'";
                                    $result_query=mysqli_query($conn,$select_query);
                                    $row=mysqli_fetch_assoc($result_query);
                                    if($row) {
                                        $user_name = $row['user_name'];
                                        $user_mobile = $row['user_mobile'];
                                        $user_address = $row['user_address'];
                                        $user_email = $row['user_email'];

                                        echo "<form action='order.php?user_id=$user_id' method = 'POST'>";

                                        echo "
                                        <p class='form-row form-row-wide'>
                                            <input type='text' class='input-text' id='inputSuccess2' placeholder='HỌ TÊN' name='customerName' value = '$user_name' required>
                                        </p>
                                        <p class='form-row form-row-wide'>
                                            <input type='email' class='input-text' id='inputSuccess2' placeholder='Email' name='customerEmail' value = '$user_email' required>
                                        </p>
                                        <p class='form-row form-row-wide'>
                                            <input type='text' class='input-text' id='inputSuccess2' placeholder='Số điện thoại' name='customerPhone' value = '$user_mobile' required>
                                        </p>
                                        <p class='form-row form-row-wide'>
                                            <input type='text' class='input-text' id='inputSuccess2' placeholder='Địa chỉ' name='customerAddress' value = '$user_address' required>
                                        </p>
                                        <p class='form-row form-row-wide'>
                                            <textarea class='input-text' id='inputError2' placeholder='Ghi chú đơn hàng' name='customerNote'></textarea>
                                        </p>
                                        <p class='form-row form-row-wide'>
                                                <input type='checkbox' class='information'>
                                                <label class='checkbox'>Cập nhật các thông tin mới nhất về chương trình từ Ananas</label>
                                        </p>
                                            
                                        ";
                                    }
                                }
                            }
                            
                        ?>                            

                            <div class="giaohang">
                                <h4><label>PHƯƠNG THỨC GIAO HÀNG</label></h4>
                            </div>
                            
                            <input type="checkbox" class="ship">
                            <label class="checkbox">Tốc độ tiêu chuẩn (từ 2 - 5 ngày làm việc)</label>
                            
                            <div class="thanhtoan">
                                <h4><label>PHƯƠNG THỨC THANH TOÁN</label></h4>
                            </div>   
                            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                            <input type="hidden" name="user_ip" value="<?php echo $user_ip; ?>">

                            <label class="checkbox">
                                <input type="radio" name="payment" class="pay" value="Thanh toán trực tiếp khi giao hàng" checked>
                                Thanh toán trực tiếp khi giao hàng
                                <img src="./../assets/img/checkout/icon_COD.svg" alt="">
                            </label>
                            <br>
                            <label class="checkbox">
                                <input type="radio" name="payment" class="pay" value="Thanh toán bằng Thẻ quốc tế / Thẻ nội địa / QR Code">
                                Thanh toán bằng Thẻ quốc tế / Thẻ nội địa / QR Code
                                <img src="./../assets/img/checkout/card_icon.svg" alt="">
                            </label>
                            <br>
                            <label class="checkbox">
                                <input type="radio" name="payment" class="pay" value="Thanh toán bằng ví MoMo">
                                Thanh toán bằng ví MoMo
                                <img src="./../assets/img/checkout/icon_momo-01.svg" alt="">
                            </label>

                    </div>

                    <div class="col-sm-6 col-md-6 col-lg-6 right">
                        <ul class="donhang">
                            <h3><label>ĐƠN HÀNG</label></h3>
                            <li class="list-group-item divider"></li>
                    
                        <div id="order_review" class="xemlaidonhang">
                            <table class="table table-hover shop_table">
                                <thead>
                                    <tr>
                                        <th class="product-name">Tên sản phẩm</th>
                                        <th class="product-quantity">Số lượng</th>
                                        <th class="product-total">Tổng cộng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                                                                        
                                        //lấy id sản phẩm theo ip trong giỏ hàng
                                        $select_cart="SELECT * FROM tbl_cart_detail where ip_address ='$user_ip'";
                                        $result_cart=mysqli_query($conn,$select_cart);
                                        while($row=mysqli_fetch_assoc($result_cart)) {
                                            $product_id = $row['product_id'];
                                            $select_product = "SELECT * FROM `tbl_product` WHERE product_id = '$product_id'";            
                                            $result_product = mysqli_query($conn, $select_product);
                                            while($row_prd_price=mysqli_fetch_array($result_product)) {
                                                $product_name = $row_prd_price['product_name'];
                                                $prd_pr = $row_prd_price['product_price'];
                                                $product_price = number_format($row_prd_price['product_price'], 0, ',', '.');


                                                 // lấy số lượng ra và tính theo giá tiền
                                                 $sql = "SELECT * FROM `tbl_cart_detail` WHERE product_id = '$product_id'";
                                                 $result_qty = mysqli_query($conn, $sql);
                                                while($row_cart=mysqli_fetch_array($result_qty)) {
                                                     $quantity = $row_cart['quantity'];
                                                     $prd_qty_price = $prd_pr * $quantity;
                                                     $prd_qty_price = number_format($prd_qty_price, 0, ',', '.');
                                                     $prd_price = array(($prd_pr * $row_cart['quantity']));
                                                     $product_value = array_sum($prd_price);
                                                     $total_price = $total_price + $product_value;
                                                     echo "
                                                         <tr class='cart_item'>
                                                            <td class='produc-name'>$product_name</td>
                                                            <td class='product-quantity'>X $quantity</td>
                                                            <td class='product-total'>$prd_qty_price VNĐ</td>
                                                         </tr>
                                                    ";                                                
                                                }
                                            }
                                        }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr class="order">
                                        <th>Đơn hàng</th>
                                        <td></td>
                                        <td><?php echo" ".number_format($total_price, 0, ',', '.') ."";?> VNĐ</td>
                                    </tr>
                                    <tr class="discount">
                                        <th>GIẢM</th>
                                        <td></td>
                                        <td>-0 VNĐ</td>
                                    </tr>
                                    <tr class="shipping">
                                        <th>Phí vận chuyển</th>
                                        <td></td>
                                        <td>0 VNĐ</td>
                                    </tr>
                                    <tr class="payment-fees">
                                        <th>Phí thanh toán</th>
                                        <td></td>
                                        <td>0VNĐ</td>
                                    </tr>
                                    <tr class="order-total">
                                        <th>TỔNG CỘNG</th>
                                        <td></td>
                                        <td><?php echo" ".number_format($total_price, 0, ',', '.') ."";?> VNĐ</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <?php
                        echo "  
                        <a href='order.php'>
                            <input type='submit' class='place_order' value = 'HOÀN TẤT ĐẶT HÀNG' name = 'complete_order'>
                          </a>  ";
                          echo "</form>";
                        ?>    
                        </ul>
                    </div>
                </div>
            </div>

            <?php
                include '../config/footer.php';
            ?>
        </div>
    </body>
</html>