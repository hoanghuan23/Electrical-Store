<?php
    require('../config/config.php'); 
  
    if(!$_SESSION["ad_name"]) {
        header("location:../admin_login.php");
    }
    
    if(isset($_POST['btn_insert'])) {
        $news_cate_id = $_POST['cate'];
        $title = $_POST['txt_title'];
        $news_desc = $_POST['txt_news_desc'];
        $cont1 = $_POST['txt_cont1'];
        $cont2 = $_POST['txt_cont2'];
        $cont3 = $_POST['txt_cont3'];

        $img_avt = $_FILES['img_avt']['name'];        
        $news_img2 = $_FILES['news_img2']['name'];
        $news_img3 = $_FILES['news_img3']['name'];

        //upload img
        $target_dir = "./quanlytintuc/upload/";
        $target_file1 = $target_dir . basename($_FILES["img_avt"]["name"]);
        $imageFileType1 = strtolower(pathinfo($target_file1,PATHINFO_EXTENSION));
        
        $target_file2 = $target_dir . basename($_FILES["news_img2"]["name"]);
        $imageFileType2 = strtolower(pathinfo($target_file2,PATHINFO_EXTENSION));

        $target_file3 = $target_dir . basename($_FILES["news_img3"]["name"]);
        $imageFileType3 = strtolower(pathinfo($target_file3,PATHINFO_EXTENSION));
        $uploadOk = 1;
        
        $news_img_note = $_POST['txt_img_note'];
        $news_author = $_POST['txt_author'];
        $news_status = $_POST['txt_news_status'];

        $sql_insert = "INSERT INTO tbl_news (cate_id, title, news_desc, author, cont1, cont2, cont3, img, img2, img3,  img_note, date, status)
                                VALUES ('$news_cate_id','$title', '$news_desc','$news_author','$cont1','$cont2','$cont3','$img_avt','$news_img2','$news_img3','$news_img_note',NOW(),'$news_status')";

        move_uploaded_file($_FILES["img_avt"]["tmp_name"], $target_file1);
        move_uploaded_file($_FILES["news_img2"]["tmp_name"], $target_file2);
        move_uploaded_file($_FILES["news_img3"]["tmp_name"], $target_file3);


        if(mysqli_query($conn, $sql_insert)) {
            echo "<script>alert('Đã thêm tin tức thành công')</script>";
        } 
        else {
            echo "Error: " . $sql_insert . "<br>" . mysqli_error($conn);
        }
    }

    
    // Xóa dữ liệu
    if(isset($_GET["news"]) && $_GET["news"]=="delete") {
        $new_id = $_GET["id"];
        $sql_delete = "delete from tbl_news where new_id = " .$new_id;
        if (mysqli_query($conn, $sql_delete)) {
            echo "<script>alert('Đã xóa tin tức thành công')</script>";
        }
        else {
            echo "Error: " .$sql . "</br>" . mysqli_error($conn); 
        }
    }

    // Xóa theo lựa chọn
    if(isset($_POST["delete_check"])) {
        // Mảng new_id với giá trị lấy từ new[]
        $new_id = $_POST["new"];
        // $new_id as $p 
        foreach($new_id as $n) {
            $sql_delete = "delete from tbl_news where new_id = " .$n;
            if (mysqli_query($conn, $sql_delete)) {
                echo "<script>alert('Đã xóa thành công')</script>";
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
        <title>News - Admin Dashboard</title>
        <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="styleadmin.css">        
        <script src="../../assets/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
        <head>
    <style>
        /* Giới hạn độ dài nội dung */
        .table td {
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        .table td:nth-child(3),
        .table td:nth-child(4),
        .table td:nth-child(5) {
            max-width: 200px;
        }

        /* Cho phép các cột hình ảnh hiển thị đầy đủ */
        .table td:nth-child(8),
        .table td:nth-child(9),
        .table td:nth-child(10) {
            max-width: none;
            white-space: normal;
        }
    

        /* Cho phép cột checkbox và nút bấm hiển thị đầy đủ */
        .table td:nth-last-child(-n+3) {
            max-width: none;
            white-space: normal;
        }

        /* Style cho ảnh */
        .table img {
            width: 120px;
            height: 80px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        /* Thêm tooltip khi hover để xem nội dung đầy đủ */
        .table td {
            position: relative;
        }
        
        .table td:hover {
            overflow: visible;
            white-space: normal;
            background-color: #fff;
            z-index: 1;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
    </head>
    <body>
        <div class="container">
            <h1>TIN TỨC</h1>
            <div class="row">
                <div class="col-12">
                    <form class="form-check-inline " action="./dashboard.php?news" method="post">
                            <input class="form-control" style="width: 300px;" type="text" name="txt_search" id="" placeholder="Tìm kiếm theo tin tức....">
                            <br>
                            <input class="btn btn-success" type="submit" value="Tìm kiếm" name="btn_search">
                            <input type="submit" value="Xóa theo lựa chọn" name = "delete_check" class="btn btn-info"> 
                        </div>
                    </form>
            </div>



            <h2>Tất cả tin tức</h2>
            <div class="row">
                <div class="col-12">
                    <table class="table table-striped">
                        <tr>
                            <th>Mã tin tức</th>
                            <th>Mã danh mục</th>
                            <th>Tiêu đề</th>
                            <th>Mô tả</th>
                            <th>ND (1)</th>
                            <th>ND (2)</th>
                            <th>ND (3)</th>
                            <th>Ảnh (đại diện)</th>
                            <th>Ảnh (2)</th>
                            <th>Ảnh (3)</th>
                            <th>Chú thích</th>
                            <th>Tác giả</th>
                            <th>Ngày post</th>
                            <th>Trạng thái</th>
                            <th>Chỉnh sửa</th>
                            <th>Xóa</th>
                            <th>Chọn</th>
                        </tr>
                        <!-- Form bao trọn table -->
                        <form action="./dashboard.php?news" method="post">
                            <?php
                                $sql = "";
                                if(isset($_POST["btn_search"])) {
                                    $sql = "select * from tbl_news where title like '%".$_POST["txt_search"]."%'";
                                }
                                else
                                $sql = "select * from tbl_news order by new_id ASC";                             
                                //Khai báo sql, liên kết sql hiển thị bảng
                                $result = mysqli_query($conn,$sql);               
                                if(mysqli_num_rows($result)>0) {
                                    // Hiển thị các cột dữ liệu
                                    while($row = mysqli_fetch_assoc($result)) {
                                        $s = "";
                                        // Khi status = 0 là Limited Edition, 1 là Online Only, 2 là Sale off, 3 là New Arrival
                                        if($row["status"] == 0) {
                                            $s = "<p style='color:red'>Ẩn</p>";
                                        }
                                        else {
                                            $s = "<p style='color:green'>Hiện</p>";
                                        }

                                        echo "<tr>";
                                            echo "<td>" .$row["new_id"]. "</td>";
                                            echo "<td>" .$row["cate_id"]. "</td>";
                                            echo "<td>" .$row["title"]. "</td>";
                                            echo "<td>" .$row["news_desc"]. "</td>";
                                            echo "<td>" .$row["cont1"]. "</td>";
                                            echo "<td>" .$row["cont2"]. "</td>";                                        
                                            echo "<td>" .$row["cont3"]. "</td>";
                                            echo "<td><img class='table img' src='./quanlytintuc/upload/{$row['img']}' alt='Ảnh đại diện'></td>";
                                            echo "<td><img class='table img' src='./quanlytintuc/upload/{$row['img2']}' alt='Ảnh 2'></td>";
                                            echo "<td><img class='table img' src='./quanlytintuc/upload/{$row['img3']}' alt='Ảnh 3'></td>";
                                            echo "<td>" .$row["img_note"]. "</td>";
                                            echo "<td>" .$row["author"]. "</td>";
                                            echo "<td>" .$row["date"]. "</td>";
                                            echo "<td>".$s."</td>";
                                            echo "<td><a class='btn btn-warning' href='./quanlytintuc/update_news.php?task=update&id=".$row["new_id"]."'>
                                                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil-square' viewBox='0 0 16 16'>
                                                            <path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z'/>
                                                            <path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z'/>
                                                        </svg> 
                                                    </a> 
                                                    </td>";
                                            echo "<td><a class='btn btn-danger' href='./dashboard.php?news=delete&id=".$row["new_id"]."'>
                                                        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash3-fill' viewBox='0 0 16 16'>
                                                            <path d='M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z'/>
                                                        </svg>
                                                    </a></td>";
                                            // Tạo checkbox để lựa chọn xóa. Mảng new[] với các giá trị là các new_id
                                            echo "<td>";
                                                echo "<input class='form-check-input' type='checkbox' name ='new[]' value='".$row["new_id"]."'>";
                                            echo "</td>";
                                        echo "</tr>";
                                    }
                                }
                                else {
                                    echo "<script>alert('Không tìm thấy tin tức này')</script>";
                                    echo "<script>window.open('./dashboard.php?products','_self')</script>";
                                }
                        
                            ?>
                        </form> 
                    </table>
                </div>
            </div>

            
            <h2>Thêm tin tức</h2>
            <!-- form -->
            <form action="./dashboard.php?news" method="post" enctype="multipart/form-data">
                Chọn danh mục tin tức:
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
                Nhập tiêu đề tin tức:
                <input type="text" name="txt_title" id="" class="form-control">
                Nhập mô tả tin tức:
                <input type="text" name="txt_news_desc" id="" class = "form-control">
                Nhập nội dung tin tức(1):
                <textarea class="form-control" name="txt_cont1" id="editor"></textarea>
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
                <br>
                Nhập nội dung tin tức(2):
                <textarea class="form-control" name="txt_cont2" id="editor1"></textarea>
                <script>
                        ClassicEditor
                                .create( document.querySelector( '#editor1' ) )
                                .then( editor => {
                                        console.log( editor );
                                } )
                                .catch( error => {
                                        console.error( error );
                                } );
                </script>
                Nhập nội dung tin tức(3):
                <br>
                <textarea class="form-control" name="txt_cont3" id="editor2"></textarea>
                <script>
                        ClassicEditor
                                .create( document.querySelector( '#editor2' ) )
                                .then( editor => {
                                        console.log( editor );
                                } )
                                .catch( error => {
                                        console.error( error );
                                } );
                </script>
                Nhập ảnh tin tức (đại diện):
                <input type="file" name="img_avt" id="" class="form-control">
                <br>
                Nhập hình ảnh tin tức (2):
                <input type="file" name="news_img2" id="" class="form-control">
                <br>
                Nhập hình ảnh tin tức (3):
                <input type="file" name="news_img3" id="" class="form-control">
                <br>
                Nhập chú thích ảnh:
                <input type="text" name="txt_img_note" id="" class="form-control">
                Nhập tên tác giả:
                <input type="text" name="txt_author" id="" class="form-control">
                <br>
                Nhập trạng thái tin tức:
                <input type="text" name="txt_news_status" id="" class="form-control">
                <br>
                <input class="btn btn-primary" name="btn_insert" type="submit" value="Insert News">
            </form>
        </div>
            
    </body>
</html>