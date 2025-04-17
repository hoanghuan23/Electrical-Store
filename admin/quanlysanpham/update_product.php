<?php
    require('../../config/config.php'); 
    session_start();

    if(!$_SESSION["ad_name"]) {
        header("location:../admin_login.php");
    }

    // Get existing product data
    if(isset($_GET["id"])) {
        $product_id = $_GET["id"];
        $sql_select = "SELECT * FROM tbl_product WHERE product_id = " . $product_id;
        $result = mysqli_query($conn, $sql_select);
        $row = mysqli_fetch_assoc($result);
    }

    // Handle update submission
    if(isset($_POST['btn_update'])) {
        $product_id = $_POST['product_id'];
        $prd_cate_id = $_POST['cate'];
        $prd_code = $_POST['txt_prd_code'];
        $prd_name = $_POST['txt_prd_name'];
        $prd_color = $_POST['txt_prd_color'];
        $prd_desc = $_POST['txt_prd_desc'];
        $prd_price = $_POST['txt_prd_price'];
        $prd_quantity = $_POST['txt_prd_quantity'];
        $prd_status = $_POST['txt_prd_status'];

        // Get existing images from database
        $sql_get_images = "SELECT img, img_hover FROM tbl_product WHERE product_id = $product_id";
        $result_images = mysqli_query($conn, $sql_get_images);
        $existing_images = mysqli_fetch_assoc($result_images);
        
        // Keep existing images by default
        $prd_img = $existing_images['img'];
        $prd_img_hover = $existing_images['img_hover'];

        // Only update main image if a new one is uploaded
        if(isset($_FILES['prd_img']) && $_FILES['prd_img']['error'] !== UPLOAD_ERR_NO_FILE && $_FILES['prd_img']['size'] > 0) {
            $prd_img = $_FILES['prd_img']['name'];
            $target_dir = "../quanlysanpham/upload/";
            $target_file = $target_dir . basename($_FILES["prd_img"]["name"]);
            move_uploaded_file($_FILES["prd_img"]["tmp_name"], $target_file);
        }

        // Only update hover image if a new one is uploaded
        if(isset($_FILES['prd_img_hover']) && $_FILES['prd_img_hover']['error'] !== UPLOAD_ERR_NO_FILE && $_FILES['prd_img_hover']['size'] > 0) {
            $prd_img_hover = $_FILES['prd_img_hover']['name'];
            $target_dir = "../quanlysanpham/upload/";
            $target_file = $target_dir . basename($_FILES["prd_img_hover"]["name"]);
            move_uploaded_file($_FILES["prd_img_hover"]["tmp_name"], $target_file);
        }

        $sql_update = "UPDATE tbl_product SET 
            cate_id = '$prd_cate_id',
            product_code = '$prd_code',
            product_name = '$prd_name',
            product_color = '$prd_color',
            product_desc = '$prd_desc',
            product_price = '$prd_price',
            img = '$prd_img',
            img_hover = '$prd_img_hover',
            product_quantity = '$prd_quantity',
            status = '$prd_status'
            WHERE product_id = $product_id";

        if(mysqli_query($conn, $sql_update)) {
            echo "<script>window.open('../dashboard.php?products','_self')</script>";
        } else {
            echo "Error: " . $sql_update . "<br>" . mysqli_error($conn);
        }
    }

    if(isset($_POST["btn_cancel"])) {
        header("location:../dashboard.php?products");
    }

?>

<html>
    <head>
            <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
            <link rel="stylesheet" href="../../assets/bootstrap.bundle.min.js">    
            <link rel="stylesheet" href="../css/styleadmin.css"> 
            <title>Update Product</title>
           
    </head>

    <body style = "background-color: antiquewhite;">
        <div class="container">
            <h1>Cập nhật sản phẩm</h1>
            <div class="row">
                <div class="col-6">
                    <!-- gửi dữ liệu qua form thông thường dùng qua post -->
                    <form action="update_product.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                        
                        Chọn danh mục sản phẩm:
                        <select class="form-control" name="cate" id="">
                            <?php
                                $sql = "select * from tbl_category order by cate_id ASC";                             
                                $result_cate = mysqli_query($conn, $sql);               
                                if(mysqli_num_rows($result_cate) > 0) {
                                    while($cate_row = mysqli_fetch_assoc($result_cate)) {
                                        $selected = ($cate_row["cate_id"] == $row["cate_id"]) ? "selected" : "";
                                        echo "<option value='".$cate_row["cate_id"]."' ".$selected.">".$cate_row["cate_name"]."</option>";
                                    }                                
                                }
                            ?>
                        </select>

                        Mã sản phẩm:
                        <input type="text" name="txt_prd_code" class="form-control" value="<?php echo $row['product_code']; ?>">
                        
                        Tên sản phẩm:
                        <input type="text" name="txt_prd_name" class="form-control" value="<?php echo $row['product_name']; ?>">
                        
                        Màu sản phẩm:
                        <input type="text" name="txt_prd_color" class="form-control" value="<?php echo $row['product_color']; ?>">
                        
                        Mô tả sản phẩm:
                        <textarea class="form-control" name="txt_prd_desc" id="editor"><?php echo $row['product_desc']; ?></textarea>
                        <script>
                            ClassicEditor
                                .create(document.querySelector('#editor'))
                                .catch(error => {
                                    console.error(error);
                                });
                        </script>
                        
                        Giá sản phẩm:
                        <input type="number" name="txt_prd_price" class="form-control" value="<?php echo $row['product_price']; ?>">
                        
                        Hình ảnh hiện tại: <img src="../quanlysanpham/upload/<?php echo $row['img']; ?>" width="100">
                        <br>
                        Cập nhật hình ảnh mới:
                        <input type="file" name="prd_img" class="form-control">
                        <br>
                        
                        Hình ảnh hover hiện tại: <img src="../quanlysanpham/upload/<?php echo $row['img_hover']; ?>" width="100">
                        <br>
                        Cập nhật hình ảnh hover mới:
                        <input type="file" name="prd_img_hover" class="form-control">
                        <br>
                        
                        Số lượng sản phẩm:
                        <input type="number" name="txt_prd_quantity" class="form-control" value="<?php echo $row['product_quantity']; ?>">
                        
                        Trạng thái sản phẩm:
                        <select class="form-control" name="txt_prd_status">
                            <option value="0" <?php echo ($row['status'] == 0) ? 'selected' : ''; ?>>Phiên bản mới</option>
                            <option value="1" <?php echo ($row['status'] == 1) ? 'selected' : ''; ?>>Khuyến mãi</option>
                            <option value="2" <?php echo ($row['status'] == 2) ? 'selected' : ''; ?>>Sản phẩm đặc biệt</option>
                            <option value="3" <?php echo ($row['status'] == 3) ? 'selected' : ''; ?>>Hàng có sẵn</option>
                        </select>
                        <br>
                        
                        <input type="submit" name="btn_update" value="Cập nhật sản phẩm" class="btn btn-primary">
                        <input type="submit" value="Cancel" name="btn_cancel" class="btn btn-danger">
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>