<?php
    require('../config/config.php'); 
    // Kiểm tra xem đã đăng nhập hay chưa
    // Nếu chưa đăng nhập thành công điều hướng về trang login. Nếu đã đăng nhập được rồi thì hiển thị
    if(!$_SESSION["ad_name"]) {
        header("location:../admin_login.php");
    }
    // Xóa dữ liệu
    if(isset($_GET["list_users"]) && $_GET["list_users"]=="delete") {
        $user_id = $_GET["id"];
        $sql_delete = "delete from tbl_users where user_id = " .$user_id;
        if (mysqli_query($conn, $sql_delete)) {
            echo "<script>alert('Đã xóa người dùng thành công')</script>";
        }
        else {
            echo "Error: " .$sql . "</br>" . mysqli_error($conn); 
        }
    }
    
    // Thêm xử lý cập nhật thông tin người dùng
    if(isset($_POST["btn_update"])) {
        $user_id = $_POST["user_id"];
        $user_name = $_POST["user_name"];
        $user_mobile = $_POST["user_mobile"];
        $user_email = $_POST["user_email"];
        $user_address = $_POST["user_address"];
        
        $sql_update = "UPDATE tbl_users SET 
            user_name = '$user_name',
            user_mobile = '$user_mobile',
            user_email = '$user_email',
            user_address = '$user_address'
            WHERE user_id = $user_id";
            
        if(mysqli_query($conn, $sql_update)) {
            echo "<script>alert('Cập nhật thông tin thành công!')</script>";
        } else {
            echo "Error: " . $sql_update . "<br>" . mysqli_error($conn);
        }
    }
?>

<div class="card">
    <div class="card-body">
        <h1>Danh sách người dùng</h1>
        
        <div class="row mb-3">
            <div class="col-md-6">
                <form class="form-check-inline d-flex" action="./dashboard.php?list_users" method="post">
                    <input class="form-control me-2" style="width: 300px;" type="text" name="txt_search" placeholder="Tìm kiếm theo tên người dùng...">
                    <input class="btn btn-success" type="submit" value="Tìm kiếm" name="btn_search">
                </form>
            </div>
        </div>

        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Mã id</th> 
                    <th>Tên người dùng</th>
                    <th>Số điện thoại</th>
                    <th>Email</th>
                    <th>Địa chỉ</th>
                    <th>Lựa chọn</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "";
                if(isset($_POST["btn_search"])) {
                    $sql = "select * from tbl_users where user_name like '%".$_POST["txt_search"]."%'";
                }
                else {
                    $sql = "select * from tbl_users";                             
                }
                
                $result = mysqli_query($conn, $sql);               
                if(mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" .$row["user_id"] . "</td>";
                        echo "<td>" .$row["user_name"] . "</td>";
                        echo "<td>" .$row["user_mobile"] . "</td>";
                        echo "<td>" .$row["user_email"] . "</td>";
                        echo "<td>" .$row["user_address"] . "</td>";
                        echo "<td>";
                        echo "<a href='#' class='btn btn-warning btn-sm me-2' data-bs-toggle='modal' data-bs-target='#editModal".$row["user_id"]."'>
                                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil-square' viewBox='0 0 16 16'>
                                    <path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z'></path>
                                    <path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z'></path>
                                </svg>
                                
                              </a>";
                        echo "<a href='./dashboard.php?list_users=delete&id=".$row["user_id"]."' class='btn btn-danger btn-sm' onclick='return confirm(\"Bạn có chắc chắn muốn xóa người dùng này?\")'>
                                <i class='bi bi-trash'></i>
                              </a>";
                        echo "</td>";
                        echo "</tr>";
                        
                        // Thêm Modal cho từng user
                        echo "<div class='modal fade' id='editModal".$row["user_id"]."' tabindex='-1' aria-labelledby='editModalLabel' aria-hidden='true'>
                            <div class='modal-dialog'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <h5 class='modal-title' id='editModalLabel'>Sửa thông tin người dùng</h5>
                                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                    </div>
                                    <form method='post'>
                                        <div class='modal-body'>
                                            <input type='hidden' name='user_id' value='".$row["user_id"]."'>
                                            <div class='mb-3'>
                                                <label class='form-label'>Tên người dùng</label>
                                                <input type='text' class='form-control' name='user_name' value='".$row["user_name"]."' required>
                                            </div>
                                            <div class='mb-3'>
                                                <label class='form-label'>Số điện thoại</label>
                                                <input type='text' class='form-control' name='user_mobile' value='".$row["user_mobile"]."' required>
                                            </div>
                                            <div class='mb-3'>
                                                <label class='form-label'>Email</label>
                                                <input type='email' class='form-control' name='user_email' value='".$row["user_email"]."' required>
                                            </div>
                                            <div class='mb-3'>
                                                <label class='form-label'>Địa chỉ</label>
                                                <textarea class='form-control' name='user_address' required>".$row["user_address"]."</textarea>
                                            </div>
                                        </div>
                                        <div class='modal-footer'>
                                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Đóng</button>
                                            <button type='submit' class='btn btn-primary' name='btn_update'>Cập nhật</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>Không tìm thấy người dùng nào</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
