<?php
    require('../config/config.php'); 
    if(!$_SESSION["ad_name"]) {
        header("location:../admin_login.php");
    }

    if(isset($_POST['btn_insert'])) {
        $prd_cate_id = $_POST['cate'];
        $prd_code = $_POST['txt_prd_code'];
        $prd_name = $_POST['txt_prd_name'];
        $prd_color = $_POST['txt_prd_color'];
        $prd_desc = $_POST['txt_prd_desc'];
        $prd_price = $_POST['txt_prd_price'];

        $prd_img = $_FILES['prd_img']['name'];
        $prd_img_hover = $_FILES['prd_img_hover']['name'];

        //upload img
        $target_dir = "./quanlysanpham/upload/";
        $target_file1 = $target_dir . basename($_FILES["prd_img"]["name"]);
        $imageFileType1 = strtolower(pathinfo($target_file1,PATHINFO_EXTENSION));
        
        $target_file2 = $target_dir . basename($_FILES["prd_img_hover"]["name"]);
        $imageFileType2 = strtolower(pathinfo($target_file2,PATHINFO_EXTENSION));
        
        $uploadOk = 1;
        
        $prd_quantity = $_POST['txt_prd_quantity'];
        $prd_status = $_POST['txt_prd_status'];

        $sql_insert = "INSERT INTO tbl_product (cate_id, product_code, product_name, product_color, product_price, product_desc, img, img_hover, product_quantity, date, status)
                                VALUES ('$prd_cate_id','$prd_code','$prd_name','$prd_color','$prd_price','$prd_desc','$prd_img','$prd_img_hover','$prd_quantity',NOW(),'$prd_status')";

        move_uploaded_file($_FILES["prd_img"]["tmp_name"], $target_file1);
        move_uploaded_file($_FILES["prd_img_hover"]["tmp_name"], $target_file2);


        if(mysqli_query($conn, $sql_insert)) {
            echo "<script>alert('Đã thêm sản phẩm thành công')</script>";
            echo "<script>window.open('./dashboard.php?products','_self')</script>";
        } 
        else {
            echo "Error: " . $sql_insert . "<br>" . mysqli_error($conn);
        }
    }

        // Xóa dữ liệu
    // task có thể thay đổi, tự đặt có thể là tên khác
    // Xóa dữ liệu
    // task có thể thay đổi, tự đặt có thể là tên khác
    if(isset($_GET["products"]) && $_GET["products"]=="delete") {
        $product_id = $_GET["id"];
        $sql_delete = "delete from tbl_product where product_id = " .$product_id;
        if (mysqli_query($conn, $sql_delete)) {
            echo "<script>alert('Xóa sản phẩm thành công)</script>";
        }
        else {
            echo "Error: " .$sql . "</br>" . mysqli_error($conn); 
        }
    }


    // Xóa theo lựa chọn
    if(isset($_POST["delete_check"])) {
        // Mảng product_id với giá trị lấy từ product[]
        $product_id = $_POST["product"];
        // $product_id as $p 
        foreach($product_id as $p) {
            $sql_delete = "delete from tbl_product where product_id = " .$p;
            if (mysqli_query($conn, $sql_delete)) {
                echo "<script>alert('Xóa các sản phẩm đã chọn thành công)</script>";
            }
                else {
                echo "Error: " .$sql . "</br>" . mysqli_error($conn); 
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Products - Admin Dashboard</title>
        <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
        <script src="../../assets/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
        <style>
            .table img {
                width: 80px;
                height: 40px;
                object-fit: cover;
                border-radius: 4px;
                border: 1px solid #ddd;
            }
            
            .description-cell {
                max-width: 250px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                cursor: pointer;
            }
            
            .description-cell:hover {
                white-space: normal;
                overflow: visible;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>SẢN PHẨM</h1>
            <div class="row">
                <div class="col-12">
                    <form class="form-check-inline " action="./dashboard.php?products" method="post">
                            <input class="form-control" style="width: 300px;" type="text" name="txt_search" id="" placeholder="Tìm kiếm theo mã sản phẩm....">
                            <br>
                            <input class="btn btn-success" type="submit" value="Tìm kiếm" name="btn_search">
                            <input type="submit" value="Xóa theo lựa chọn" name = "delete_check" class="btn btn-info"> 
                        </div>
                    </form>
            </div>
            

            <h2>Tất cả sản phẩm</h2>
            <div class="row">
                <div class="col-12">
                    <table class="table table-striped">
                        <tr>
                            <th>Mã danh mục</th>
                            <th>Mã sản phẩm</th>
                            <th>Tên </th>
                            <th>Màu</th>
                            <th>Mô tả</th>
                            <th>Giá</th>
                            <th>Ảnh</th>
                            <th>Ảnh (hover)</th>
                            <th>Số lượng</th>
                            <th>Ngày post</th>
                            <th>Trạng thái</th>
                            <th>Chỉnh sửa</th>
                            <th>Xóa</th>
                            <th>Chọn</th>
                        </tr>
                        <!-- Form bao trọn table -->
                        <form action="./dashboard.php?products" method="post">
                            <?php
                                $sql = "";
                                if(isset($_POST["btn_search"])) {
                                    $sql = "select * from tbl_product where product_code like '%".$_POST["txt_search"]."%'";
                                }
                                else
                                $sql = "select * from tbl_product order by product_id ASC";                             
                                //Khai báo sql, liên kết sql hiển thị bảng
                                $result = mysqli_query($conn,$sql);               
                                if(mysqli_num_rows($result)>0) {
                                    // Hiển thị các cột dữ liệu
                                    while($row = mysqli_fetch_assoc($result)) {
                                        $s = "";
                                        // Khi status = 0 là Phiên bản mới, 1 là Khuyến mãi, 2 là Sản phẩm đặc biệt, 3 là Hàng có sẵn
                                        if($row["status"] == 0) {
                                            $s = "<p style='color:red'>Phiên bản mới</p>";
                                        }
                                        elseif($row["status"] == 1) {
                                            $s = "<p style='color:green'>Khuyến mãi</p>";
                                        }
                                        elseif($row["status"] == 2) {
                                            $s = "<p style='color:black'>Sản phẩm đặc biệt</p>";   
                                        }
                                        else {
                                            $s = "<p style='color:#f15e2c'>Hàng có sẵn</p>";   
                                        }

                                        echo "<tr>";
                                            echo "<td>" .$row["cate_id"] . "</td>";
                                            echo "<td>" .$row["product_code"] . "</td>";
                                            echo "<td>" .$row["product_name"] . "</td>";
                                            echo "<td>" .$row["product_color"] . "</td>";
                                            echo "<td class='description-cell' title='" . htmlspecialchars($row["product_desc"]) . "'>" . $row["product_desc"] . "</td>";                                        
                                            echo "<td>" .$row["product_price"] . "</td>";
                                            echo "<td><img src='./quanlysanpham/upload/{$row['img']}'></td>";
                                            echo "<td><img src='./quanlysanpham/upload/{$row['img_hover']}' </td>";
                                            echo "<td>" .$row["product_quantity"] . "</td>";
                                            echo "<td>" .$row["date"] . "</td>";
                                            echo "<td>".$s."</td>";
                                            echo "<td><a class='btn btn-warning' href='./quanlysanpham/update_product.php?task=update&id=".$row["product_id"]."'>
                                                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil-square' viewBox='0 0 16 16'>
                                                            <path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z'/>
                                                            <path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z'/>
                                                        </svg> 
                                                    </a> 
                                                    </td>";
                                            echo "<td><a class='btn btn-danger' href='./dashboard.php?products=delete&id=".$row["product_id"]."'>
                                                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash3-fill' viewBox='0 0 16 16'>
                                                            <path d='M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z'/>
                                                        </svg>
                                                    </a></td>";
                                            // Tạo checkbox để lựa chọn xóa. Mảng product[] với các giá trị là các product_id
                                            echo "<td>";
                                                echo "<input class='form-check-input' type='checkbox' name ='product[]' value='".$row["product_id"]."'>";
                                            echo "</td>";
                                        echo "</tr>";
                                    }
                                }
                                else {
                                    echo "<script>alert('Không tìm thấy mã sản phẩm này')</script>";
                                    echo "<script>window.open('./dashboard.php?products','_self')</script>";
                                }
                        
                            ?>
                        </form> 
                    </table>
                </div>
            </div>

            <h2>Thêm sản phẩm</h2>
            <!-- form -->
            <form action="./dashboard.php?products" method="post" enctype="multipart/form-data">
                Chọn danh mục sản phẩm:
                <select class="form-control" name="cate" id="">
                    <?php
                        $sql = "select * from tbl_category order by cate_id ASC";                             
                        //Khai báo sql, liên kết sql hiển thị bảng
                        $result = mysqli_query($conn,$sql);               
                        if(mysqli_num_rows($result)>0) {
                            while($row = mysqli_fetch_assoc($result)) {
                                echo"<option value='".$row["cate_id"]."'>".$row["cate_name"]."</option>";
                            }                                
                        }
                    ?>
                </select>
                Nhập mã sản phẩm:
                <input type="text" name="txt_prd_code" id="" class="form-control">
                Nhập tên sản phẩm:
                <input type="text" name="txt_prd_name" id="" class="form-control">
                Nhập màu sản phẩm:
                <input type="text" name="txt_prd_color" id="" class="form-control">
                Nhập mô tả sản phẩm:
                <textarea class="form-control" name="txt_prd_desc" id="editor"></textarea>
                <script>
                        ClassicEditor
                                .create( document.querySelector( '#editor' ) )
                                .then( editor => {
                                        console.log( editor );
                                } )
                                .catch( error => {
                                        console.error( error );
                                } );
                </script>
                Nhập giá sản phẩm:
                <input type="number" name="txt_prd_price" id="" class="form-control">
                Nhập hình ảnh sản phẩm:
                <input type="file" name="prd_img" id="" class="form-control">
                <br>
                Nhập hình ảnh sản phẩm (hover):
                <input type="file" name="prd_img_hover" id="" class="form-control">
                <br>
                Nhập số lượng sản phẩm:
                <input type="number" name="txt_prd_quantity" id="" required class="form-control">
                Nhập trạng thái sản phẩm:
                <input type="text" name="txt_prd_status" id="" class="form-control">
                <br>
                <input class="btn btn-primary" name="btn_insert" type="submit" value="Thêm sản phẩm">
            </form>

        </div>
            
    </body>
</html>