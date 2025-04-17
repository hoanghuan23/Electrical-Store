<?php
    session_start();

    if(!$_SESSION["ad_name"]) {
        header("location:../user_area/login.php");
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Admin Dashboard</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../NiceAdmin/assets/img/favicon.png" rel="icon">
  <link href="../NiceAdmin/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../NiceAdmin/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../NiceAdmin/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../NiceAdmin/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../NiceAdmin/assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="../NiceAdmin/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="../NiceAdmin/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../NiceAdmin/assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../NiceAdmin/assets/css/style.css" rel="stylesheet">
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="dashboard.php" class="logo d-flex align-items-center">
        <span class="d-none d-lg-block">Admin Panel</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        <li class="nav-item dropdown pe-3">
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $_SESSION["ad_name"]; ?></span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?php echo $_SESSION["ad_name"]; ?></h6>
              <span>Administrator</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="../page/index.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
  </header>

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
      <li class="nav-item">
        <a class="nav-link <?php echo !isset($_GET['products']) && !isset($_GET['categories']) && !isset($_GET['news']) && !isset($_GET['orders']) && !isset($_GET['list_users']) ? 'active' : ''; ?>" href="dashboard.php">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php echo isset($_GET['categories']) ? 'active' : ''; ?>" href="dashboard.php?categories">
          <i class="bi bi-list-ul"></i>
          <span>Danh mục sản phẩm</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php echo isset($_GET['products']) ? 'active' : ''; ?>" href="dashboard.php?products">
          <i class="bi bi-box"></i>
          <span>Sản phẩm</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php echo isset($_GET['news']) ? 'active' : ''; ?>" href="dashboard.php?news">
          <i class="bi bi-newspaper"></i>
          <span>Tin tức</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php echo isset($_GET['orders']) ? 'active' : ''; ?>" href="dashboard.php?orders">
          <i class="bi bi-cart"></i>
          <span>Đơn hàng</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php echo isset($_GET['list_users']) ? 'active' : ''; ?>" href="dashboard.php?list_users">
          <i class="bi bi-people"></i>
          <span>Danh sách người dùng</span>
        </a>
      </li>
    </ul>
  </aside>

  <!-- ======= Main ======= -->
  <main id="main" class="main">
    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <?php
          if(isset($_GET['products'])) echo '<li class="breadcrumb-item active">Sản phẩm</li>';
          elseif(isset($_GET['categories'])) echo '<li class="breadcrumb-item active">Danh mục</li>';
          elseif(isset($_GET['news'])) echo '<li class="breadcrumb-item active">Tin tức</li>';
          elseif(isset($_GET['orders'])) echo '<li class="breadcrumb-item active">Đơn hàng</li>';
          elseif(isset($_GET['list_users'])) echo '<li class="breadcrumb-item active">Người dùng</li>';
          ?>
        </ol>
      </nav>
    </div>

    <section class="section dashboard">
      <div class="row">
        <?php 
        if(isset($_GET['products'])) {
            include ('./quanlysanpham/product.php');
        }
        elseif(isset($_GET['categories'])) {
            include ('./quanlydanhmuc/category.php');
        }
        elseif(isset($_GET['news'])) {
            include ('./quanlytintuc/news.php');
        }
        elseif(isset($_GET['orders'])) {
            include ('./quanlydathang/orders.php');
        }
        elseif(isset($_GET['list_users'])) {
            include ('./quanlynguoidung/list_users.php');
        }
        else {
            // Hiển thị thống kê tổng quan
            include ('./thongke/overview.php');
        }
        ?>
      </div>
    </section>
  </main>

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
  </footer>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="../NiceAdmin/assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="../NiceAdmin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../NiceAdmin/assets/vendor/chart.js/chart.umd.js"></script>
  <script src="../NiceAdmin/assets/vendor/echarts/echarts.min.js"></script>
  <script src="../NiceAdmin/assets/vendor/quill/quill.min.js"></script>
  <script src="../NiceAdmin/assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="../NiceAdmin/assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="../NiceAdmin/assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="../NiceAdmin/assets/js/main.js"></script>

</body>

</html>