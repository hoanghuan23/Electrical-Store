<?php
    session_start();
?>
<link rel="stylesheet" href="../chatbot/assets/chatbot.css">
<form action="../config/header.php" method="post">

<div id="header" class="container-fluid">
    <div class="row">
        <ul class="menu">
            <li>
                <a href="#">
                    <img src="../assets/img/header/menu/icon_tim_cua_hang.svg" alt="">
                    Vị trí cửa hàng
                </a>
            </li>
            <li>
                <a href="../page/contact.php">
                    <img src="../assets/img/header/menu/icon_heart_header.svg" alt="">
                    Liên hệ
                </a>
            </li>

            <li>
                <a href="../page/cart.php">
                    <img src="../assets/img/header/menu/icon_gio_hang.svg" alt="">
                    Giỏ hàng (<?php
                    if (!isset($_SESSION['username'])) {echo"0";}
                    else{ cart_item(); cart();}?>)
                </a>
            </li>

            <li>
                <?php
                    if (!isset($_SESSION['username'])) {
                        echo " 
                        <a href='../user_area/login.php'>
                        <img src='../assets/img/header/menu/icon_tra_cuu_don_hang.svg' alt=''> 
                        Tra cứu đơn hàng
                        </a>
                        ";
                    }
                    else {
                        $user_name = $_SESSION['username'];
                        $sql = "SELECT * FROM tbl_users WHERE user_name = '$user_name'";
                        $result = mysqli_query($conn, $sql);
                        while($row=mysqli_fetch_array($result)) {
                            $user_id = $row['user_id'];
                            echo"
                            <a href='../user_area/order.php?user_id=$user_id'>
                            <img src='../assets/img/header/menu/icon_tra_cuu_don_hang.svg' alt=''> 
                            Tra cứu đơn hàng
                            </a>
                            ";
                        }
                    }
                ?>
            </li>

            <li>
                <?php
                    if (!isset($_SESSION['username'])) {
                        echo "
                        <a href='../user_area/login.php'>
                        <img src='../assets/img/header/menu/icon_dang_nhap.svg' alt=''>
                        Đăng nhập
                        </a>
                        ";
                    }
                    else {
                        echo "
                        <a href='../user_area/logout.php'>
                            <img src='../assets/img/header/menu/icon_dang_nhap.svg' alt=''>
                            Đăng xuất
                        </a>
                        ";
                    }
                ?>
            </li>
        </ul>
    </div>
</form>

<div class="row row-nav">
    <!-- Begin: Nav -->
    <div id="nav" class="container">
        <div class="row align-items-center">
            <div class="col-md-2">
                <div class="logo">
                    <a href="../page/index.php">
                        <img src="../assets/img/header/nav/Logo_Header.svg" alt="Logo">
                    </a>
                </div>
            </div>
            <div class="col-md-8">
                <ul class="nav-list d-flex justify-content-center">
                    <li class="nav-item line">
                        <a href="../page/product.php">DANH MỤC SẢN PHẨM</a>
                    </li>
                    <li class="nav-item line">
                        <a href="../page/product.php">
                            TỰ ĐỘNG HÓA & ĐIỀU KHIỂN
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                            </svg>
                        </a>
                        <ul class="subnav">
                            <li><a href="../page/product.php?data_gender=men">Rơ Le Điều Khiển</a></li>
                            <li><a href="../page/product.php?data_gender=women">Động Cơ</a></li>
                            <li><a href="">Biến Tần</a></li>
                            <li><a href="">Công Tắc Điều Khiển</a></li>
                        </ul>
                    </li>
                    <li class="nav-item line">
                        <a href="../page/product.php">
                            NÚT NHẤN & CÔNG TẮC
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                            </svg>
                        </a>
                        <ul class="subnav">
                            <li><a href="../page/product.php?data_gender=men">Phụ Kiện</a></li>
                            <li><a href="../page/product.php?data_gender=women">Đèn Báo</a></li>
                            <li><a href="">Bóng Đèn</a></li>
                            <li><a href="">Công Tắc</a></li>
                        </ul>
                    </li>
                    <li class="nav-item line">
                        <a href="../page/product.php?data_gender=men">
                            CẢM BIẾN
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                            </svg>
                        </a>
                        <ul class="subnav">
                            <li><a href="">Cáp Cảm Biến</a></li>
                            <li><a href="">Cảm Biến Độ Tương Phản</a></li>
                            <li><a href="">Bộ Điều Khiển Nhiệt Độ</a></li>
                        </ul>
                    </li>
                    </ul>
            </div>
            <div class="col-md-2">
                <div class="search-nav">
                    <form action="search_product.php" method="post">
                        <div class="input-group">
                            <input type="text" name="key" class="form-control" placeholder="Search ...">
                            <button class="btn btn-dark" type="submit" name="btn_search">Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div> 
<!-- End: Nav -->    
<!-- Begin: Slider -->
<div class="row">
    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel" data-bs-interval="2000">
        <div class="carousel-inner">
            <div id="pause" class="carousel-item active">
                <a href="#"><i><center>BUY 2 GET 10% OFF - ÁP DỤNG VỚI TẤT CẢ BASIC TEE</center></i></a>
            </div>
            <div id="pause" class="carousel-item">
                <a href="#"><i><center>BUY MORE PAY LESS - ÁP DỤNG KHI MUA PHỤ KIỆN</center></i></a>
            </div>
            <div id="pause" class="carousel-item">
                <a href="#"><i><center>FREE SHIPPING VỚI HÓA ĐƠN 900K !</center></i></a>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                    </svg>
                </span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
                    </svg>
                </span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</div>
<!-- End: Slider-->
</div>
<!-- End Header -->

<!-- start Chatbot -->
<?php include '../chatbot/chatbot.php'; ?>
<!-- end Chatbot -->

<style>

#nav {
    padding: 10px 0;
    width: 100%;
}

.logo {
    padding-left: 0;
    margin-left: 0;
}

#nav .logo {
    padding-left: 0;
}

.nav-list {
    list-style: none;
    margin: 0;
    padding: 0;
    gap: 8px;
    flex-wrap: nowrap;
    display: flex;
    align-items: center;
    justify-content: flex-start;
    width: 100%;
    margin-left: -50px;
}

.nav-item {
    position: relative;
    display: inline-block;
    font-size: 13px;
    padding: 0;
    margin: 0;
}

.nav-item a {
    text-decoration: none;
    color: #333;
    padding: 5px 6px;
    display: block;
    white-space: nowrap;
    line-height: 1.2;
}

.line::after {
    content: "";
    display: block;
    position: absolute;
    border-right: #e3e2e2 1px solid;
    height: 15px;
    right: -4px;
    top: 50%;
    transform: translateY(-50%);
}

.subnav {
    position: absolute;
    background-color: #333;
    list-style-type: none;
    padding: 0;
    margin: 0;
    top: 100%;
    left: 0;
    width: 200px;
    display: none;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    border-radius: 5px;
    z-index: 1000;
}

.subnav li a {
    display: block;
    padding: 10px 15px;
    color: white;
    text-decoration: none;
    font-size: 14px;
    background-color: rgb(83, 107, 121);
    transition: background 0.3s ease;
}

.subnav li a:hover {
    background-color:rgb(81, 63, 248);
    color: white;
}

.subnav li {
    width: 100%;
}

.nav-item:hover .subnav {
    display: block;
}

.nav-item svg {
    transition: transform 0.3s ease;
}

.nav-item:hover svg {
    transform: rotate(180deg);
}

.search-nav {
    display: flex;
    justify-content: flex-end;
    position: relative;
    z-index: 900;
}

.search-nav .input-group {
    max-width: 100%;
    margin-left: 30px;
    min-width: 0;
}

.nav-item a svg {
    width: 12px;
    height: 12px;
}

#nav.container {
    padding-left: 15px;
    padding-right: 15px;
    max-width: 100%;
}

.col-md-2 {
    padding: 0 10px;
    flex: 0 0 auto;
}

.col-md-8 {
    padding: 0 5px;
    flex: 1 1 auto;
}


@media (min-width: 1920px) and (max-width: 1930px) {
    #nav.container {
        max-width: 1600px;
        margin: 0 auto;
    }
}

</style>
