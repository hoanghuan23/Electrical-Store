<?php
    require('../../config/config.php'); 

    session_start();
    if(!$_SESSION["ad_name"]) {
        header("location:../admin_login.php");
    }

    
    if(isset($_POST["btn_update"])) {
        $title = $_POST["txt_title"];
        $new_id = $_POST["txt_new_id"];
        $cate_id = $_POST["txt_cate_id"];
        $news_desc = $_POST["txt_news_desc"];
        $cont1 = $_POST["txt_cont1"];
        $cont2 = $_POST["txt_cont2"];
        $cont3 = $_POST["txt_cont3"];
        $status = $_POST["txt_status"];

        // Xử lý upload ảnh
        $img_avt = $_FILES['img_avt']['name'];
        $news_img2 = $_FILES['news_img2']['name'];
        $news_img3 = $_FILES['news_img3']['name'];

        //upload img
        $target_dir = "./upload/";
        $target_file1 = $target_dir . basename($_FILES["img_avt"]["name"]);
        $target_file2 = $target_dir . basename($_FILES["news_img2"]["name"]);
        $target_file3 = $target_dir . basename($_FILES["news_img3"]["name"]);

        // Chỉ upload ảnh mới nếu có
        $sql_update = "update `tbl_news` set cate_id = ".$cate_id.", title = N'".$title."', news_desc = N'".$news_desc."', cont1 = '$cont1', cont2 = '$cont2', cont3 = '$cont3', status = ".$status;
        
        if(!empty($img_avt)) {
            move_uploaded_file($_FILES["img_avt"]["tmp_name"], $target_file1);
            $sql_update .= ", img = '$img_avt'";
        }
        if(!empty($news_img2)) {
            move_uploaded_file($_FILES["news_img2"]["tmp_name"], $target_file2);
            $sql_update .= ", img2 = '$news_img2'";
        }
        if(!empty($news_img3)) {
            move_uploaded_file($_FILES["news_img3"]["tmp_name"], $target_file3);
            $sql_update .= ", img3 = '$news_img3'";
        }
        
        $sql_update .= " where new_id =" .$new_id;

        if (mysqli_query($conn, $sql_update)) {
            echo "<script>alert('Đã cập nhật thành công')</script>";
            header("location:../dashboard.php?news");
        }
        else {
            echo "Error: " .$sql . "</br>" . mysqli_error($conn); 
        }
    }

    if(isset($_POST["btn_cancel"])) {
        header("location:../dashboard.php?news");
        
    }

?>

<html>
    <head>
            <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
            <link rel="stylesheet" href="../../assets/bootstrap.bundle.min.js">    
            <link rel="stylesheet" href="news.css">
            <script src="../../assets/js/bootstrap.bundle.min.js"></script>
            <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
            <title>Update New</title>
    </head>

    <body style = "background-color: antiquewhite;">
        <div class="container">
            <h3>Cập nhật tin tức</h1>
            <div class="row">
                <div class="col-6">
                    <!-- gửi dữ liệu qua form thông thường dùng qua post -->
                    <form action="update_news.php" method="post" enctype="multipart/form-data">
                        <?php
                            if(isset($_GET["task"]) && $_GET["task"]=="update") {
                                $id = $_GET["id"];
                                $sql_select = "select * from `tbl_news` where new_id = " .$id;                             
                                //Khai báo sql, liên kết sql hiển thị bảng
                                $result = mysqli_query($conn,$sql_select);
                                if(mysqli_num_rows($result)>0) {
                                    // Hiển thị các cột dữ liệu
                                    while($row = mysqli_fetch_assoc($result)) {
                                        echo "<input type='hidden' name='txt_new_id' value ='".$row["new_id"]."'>";
                                        
                                        // Add category selection dropdown
                                        echo "Chọn danh mục tin tức:";                                        
                                        echo "<select class='form-control' name='txt_cate_id' required onchange='updateCategoryCode(this.value)'>";
                                        // Get all categories
                                        $sql_categories = "SELECT * FROM tbl_category ORDER BY cate_id ASC";
                                        $result_categories = mysqli_query($conn, $sql_categories);
                                        if(mysqli_num_rows($result_categories) > 0) {
                                            while($category = mysqli_fetch_assoc($result_categories)) {
                                                $selected = ($category["cate_id"] == $row["cate_id"]) ? "selected" : "";
                                                echo "<option value='".$category["cate_id"]."' ".$selected.">".$category["cate_name"]."</option>";
                                            }
                                        }
                                        echo "</select>";
                                        
                                        // Add news code field
                                        echo "Mã danh mục:";                                        
                                        echo "<input class='form-control' value ='".$row["cate_id"]."' type='text' name='txt_news_code'>";
                                        
                                        echo "Nhập vào tên tin tức:";                                        
                                        echo "<input class='form-control' value ='".$row["title"]."' type='text' name='txt_title' required id=''>";
                                        
                                        echo "Nhập mô tả tin tức:";                                        
                                        echo "<textarea class='form-control' name='txt_news_desc' required id=''>".$row["news_desc"]."</textarea>";
                                        
                                        // Thêm phần upload ảnh
                                        echo "<div class='form-group'>";
                                        echo "<label>Ảnh đại diện:</label>";
                                        echo "<input type='file' class='form-control' name='img_avt' accept='image/*'>";
                                        echo "<small>Ảnh hiện tại: " . $row['img'] . "</small>";
                                        echo "</div>";

                                        echo "<div class='form-group'>";
                                        echo "<label>Ảnh 2:</label>";
                                        echo "<input type='file' class='form-control' name='news_img2' accept='image/*'>";
                                        echo "<small>Ảnh hiện tại: " . $row['img2'] . "</small>";
                                        echo "</div>";

                                        echo "<div class='form-group'>";
                                        echo "<label>Ảnh 3:</label>";
                                        echo "<input type='file' class='form-control' name='news_img3' accept='image/*'>";
                                        echo "<small>Ảnh hiện tại: " . $row['img3'] . "</small>";
                                        echo "</div>";

                                        echo "Nhập vào content1 tin tức:";  
                                        echo "<textarea class='form-control' name='txt_cont1' id='editor1'>".$row["cont1"]."</textarea>
                                                <script>
                                                    ClassicEditor
                                                            .create( document.querySelector( '#editor1' ) )
                                                            .then( editor => {
                                                                    console.log( editor );
                                                            } )
                                                            .catch( error => {
                                                                    console.error( error );
                                                            } );
                                            </script>   "  ;                                 
                                        echo "Nhập vào content2 tin tức:";  
                                        echo "<textarea class='form-control' name='txt_cont2' id='editor2'>".$row["cont2"]."</textarea>
                                                <script>
                                                    ClassicEditor
                                                            .create( document.querySelector( '#editor2' ) )
                                                            .then( editor => {
                                                                    console.log( editor );
                                                            } )
                                                            .catch( error => {
                                                                    console.error( error );
                                                            } );
                                            </script>   "  ;  
                                        echo "Nhập vào content3 tin tức:";  
                                        echo "<textarea class='form-control' name='txt_cont3' id='editor3'>".$row["cont3"]."</textarea>
                                                <script>
                                                    ClassicEditor
                                                            .create( document.querySelector( '#editor3' ) )
                                                            .then( editor => {
                                                                    console.log( editor );
                                                            } )
                                                            .catch( error => {
                                                                    console.error( error );
                                                            } );
                                            </script>   "  ;                                         
                                        echo "Nhập vào trạng thái tin tức:";
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