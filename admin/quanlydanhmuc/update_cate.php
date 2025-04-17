<?php
    require('../config/config.php'); 
    session_start();
    if(!$_SESSION["ad_name"]) {
        header("location:../admin_login.php");
    }
    else {
    if(isset($_POST["btn_update"])) {
        $cate_name = $_POST["txt_cate_name"];
        $cate_id = $_POST["txt_cate_id"];
        $new_cate_id = $_POST["txt_new_cate_id"];
        $status = $_POST["txt_status"];
        $sql_update = "update tbl_category set cate_id = ".$new_cate_id.", cate_name = N'".$cate_name."', status = ".$status." where cate_id =" .$cate_id;
        if (mysqli_query($conn, $sql_update)) {
            echo "<script>alert('Đã cập nhật thành công')</script>";
            header("location:../dashboard.php?categories");
            // echo "New record created successfully";
        }
        else {
            echo "Error: " .$sql . "</br>" . mysqli_error($conn); 
        }
    }

    if(isset($_POST["btn_cancel"])) {
        header("location:../dashboard.php?categories");
    }
    }
?>

<html>
    <head>
            <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
            <link rel="stylesheet" href="../../assets/bootstrap.bundle.min.js">    
            <link rel="stylesheet" href="../css/styleadmin.css">     
            <title>Update Category</title>
       
    </head>

    <body style = "background-color: antiquewhite;">
        <div class="container">
            <h1>Cập nhật danh mục</h1>
            <div class="row">
                <div class="col-6">
                    <!-- gửi dữ liệu qua form thông thường dùng qua post -->
                    <form action="update_cate.php" method="post">
                        <?php
                            if(isset($_GET["task"]) && $_GET["task"]=="update") {
                                $id = $_GET["id"];
                                $sql_select = "select * from tbl_category where cate_id = " .$id;                             
                                //Khai báo sql, liên kết sql hiển thị bảng
                                $result = mysqli_query($conn,$sql_select);
                                if(mysqli_num_rows($result)>0) {
                                    // Hiển thị các cột dữ liệu
                                    while($row = mysqli_fetch_assoc($result)) {
                                        echo "<input type='hidden' name='txt_cate_id' value ='".$row["cate_id"]."'>";
                                        echo "Nhập vào mã danh mục mới:";
                                        echo "<input class='form-control' value ='".$row["cate_id"]."' type='text' name='txt_new_cate_id' required id=''>";
                                        echo "Nhập vào tên danh mục:";
                                        echo "<input class='form-control' value ='".$row["cate_name"]."' type='text' name='txt_cate_name' required id=''>";
                                        echo "Nhập vào trạng thái danh mục:";
                                        echo "<input class='form-control' value ='".$row["status"]."' type='text' name='txt_status' required id=''>";
                                    }
                                }
                            }
                        ?>
                        <br>
                        <input class="btn btn-primary" name="btn_update" type="submit" value="Cập nhật">
                        <input type="submit" value="Cancel" name="btn_cancel" class="btn btn-danger">
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>