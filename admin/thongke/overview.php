<?php
include '../config/config.php';

// Lấy tổng số sản phẩm
$sql_product = "SELECT COUNT(*) as total_products FROM tbl_product";
$result_product = mysqli_query($conn, $sql_product);
$row_product = mysqli_fetch_assoc($result_product);
$total_products = $row_product['total_products'];

// Lấy tổng số danh mục
$sql_category = "SELECT COUNT(*) as total_categories FROM tbl_category";
$result_category = mysqli_query($conn, $sql_category);
$row_category = mysqli_fetch_assoc($result_category);
$total_categories = $row_category['total_categories'];

// Xử lý filter
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'today';
$today = date('Y-m-d');
$month_start = date('Y-m-01');
$year_start = date('Y-01-01');

// Lấy doanh thu theo filter
switch($filter) {
    case 'today':
        $sql_revenue = "SELECT SUM(total_price) as total_revenue FROM tbl_order WHERE DATE(order_date) = '$today' AND order_status = 'Đã giao hàng'";
        $filter_text = "Hôm nay";
        break;
    case 'month':
        $sql_revenue = "SELECT SUM(total_price) as total_revenue FROM tbl_order WHERE DATE(order_date) >= '$month_start' AND order_status = 'Đã giao hàng'";
        $filter_text = "Tháng này";
        break;
    case 'year':
        $sql_revenue = "SELECT SUM(total_price) as total_revenue FROM tbl_order WHERE DATE(order_date) >= '$year_start' AND order_status = 'Đã giao hàng'";
        $filter_text = "Năm nay";
        break;
    default:
        $sql_revenue = "SELECT SUM(total_price) as total_revenue FROM tbl_order WHERE DATE(order_date) = '$today' AND order_status = 'Đã giao hàng'";
        $filter_text = "Hôm nay";
}

$result_revenue = mysqli_query($conn, $sql_revenue);
$row_revenue = mysqli_fetch_assoc($result_revenue);
$total_revenue = $row_revenue['total_revenue'] ?? 0;

// Lấy số đơn hàng theo filter
switch($filter) {
    case 'today':
        $sql_orders = "SELECT COUNT(*) as total_orders FROM tbl_order WHERE DATE(order_date) = '$today'";
        break;
    case 'month':
        $sql_orders = "SELECT COUNT(*) as total_orders FROM tbl_order WHERE DATE(order_date) >= '$month_start'";
        break;
    case 'year':
        $sql_orders = "SELECT COUNT(*) as total_orders FROM tbl_order WHERE DATE(order_date) >= '$year_start'";
        break;
    default:
        $sql_orders = "SELECT COUNT(*) as total_orders FROM tbl_order WHERE DATE(order_date) = '$today'";
}

$result_orders = mysqli_query($conn, $sql_orders);
$row_orders = mysqli_fetch_assoc($result_orders);
$total_orders = $row_orders['total_orders'];

// Lấy số khách hàng theo filter
switch($filter) {
    case 'today':
        $sql_users = "SELECT COUNT(*) as total_users FROM tbl_users WHERE DATE(created_at) = '$today'";
        break;
    case 'month':
        $sql_users = "SELECT COUNT(*) as total_users FROM tbl_users WHERE DATE(created_at) >= '$month_start'";
        break;
    case 'year':
        $sql_users = "SELECT COUNT(*) as total_users FROM tbl_users WHERE DATE(created_at) >= '$year_start'";
        break;
    default:
        $sql_users = "SELECT COUNT(*) as total_users FROM tbl_users WHERE DATE(created_at) = '$today'";
}

// Check if the 'created_at' column exists in the tbl_users table
$check_column = mysqli_query($conn, "SHOW COLUMNS FROM tbl_users LIKE 'created_at'");
if(mysqli_num_rows($check_column) > 0) {
    $result_users = mysqli_query($conn, $sql_users);
} else {
    // Fallback to count all users if created_at column doesn't exist
    $sql_users = "SELECT COUNT(*) as total_users FROM tbl_users";
    $result_users = mysqli_query($conn, $sql_users);
}
$row_users = mysqli_fetch_assoc($result_users);
$total_users = $row_users['total_users'];

// Tính phần trăm tăng trưởng
$yesterday = date('Y-m-d', strtotime('-1 day'));
$sql_yesterday_revenue = "SELECT SUM(total_price) as yesterday_revenue FROM tbl_order WHERE DATE(order_date) = '$yesterday' AND order_status = 'Đã giao hàng'";
$result_yesterday = mysqli_query($conn, $sql_yesterday_revenue);
$row_yesterday = mysqli_fetch_assoc($result_yesterday);
$yesterday_revenue = $row_yesterday['yesterday_revenue'] ?? 0;

$growth_percentage = $yesterday_revenue > 0 ? (($total_revenue - $yesterday_revenue) / $yesterday_revenue) * 100 : 0;
$growth_class = $growth_percentage >= 0 ? 'text-success' : 'text-danger';
$growth_text = $growth_percentage >= 0 ? 'increase' : 'decrease';
?>

<div class="pagetitle">
  <button onclick="window.print()" class="btn btn-primary float-start">
    <i class="bi bi-printer"></i> In trang
  </button>
</div>

<!-- Overview Cards -->
<div class="col-xxl-4 col-md-6">
  <div class="card info-card sales-card">
    <div class="filter">
      <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
        <li class="dropdown-header text-start">
          <h6>Lọc</h6>
        </li>
        <li><a class="dropdown-item" href="?filter=today">Hôm nay</a></li>
        <li><a class="dropdown-item" href="?filter=month">Tháng này</a></li>
        <li><a class="dropdown-item" href="?filter=year">Năm nay</a></li>
      </ul>
    </div>

    <div class="card-body">
      <h5 class="card-title">Doanh thu <span>| <?php echo $filter_text; ?></span></h5>

      <div class="d-flex align-items-center">
        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
          <i class="bi bi-cart"></i>
        </div>
        <div class="ps-3">
          <h6><?php echo number_format($total_revenue); ?> VNĐ</h6>
          <span class="<?php echo $growth_class; ?> small pt-1 fw-bold"><?php echo number_format(abs($growth_percentage), 1); ?>%</span> 
          <span class="text-muted small pt-2 ps-1"><?php echo $growth_text; ?></span>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="col-xxl-4 col-md-6">
  <div class="card info-card revenue-card">
    <div class="filter">
      <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
        <li class="dropdown-header text-start">
          <h6>Lọc</h6>
        </li>
        <li><a class="dropdown-item" href="?filter=today">Hôm nay</a></li>
        <li><a class="dropdown-item" href="?filter=month">Tháng này</a></li>
        <li><a class="dropdown-item" href="?filter=year">Năm nay</a></li>
      </ul>
    </div>

    <div class="card-body">
      <h5 class="card-title">Đơn hàng <span>| <?php echo $filter_text; ?></span></h5>

      <div class="d-flex align-items-center">
        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
          <i class="bi bi-currency-dollar"></i>
        </div>
        <div class="ps-3">
          <h6><?php echo $total_orders; ?></h6>
          <span class="text-success small pt-1 fw-bold">8%</span> <span class="text-muted small pt-2 ps-1">increase</span>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="col-xxl-4 col-xl-12">
  <div class="card info-card customers-card">
    <div class="filter">
      <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
        <li class="dropdown-header text-start">
          <h6>Lọc</h6>
        </li>
        <li><a class="dropdown-item" href="?filter=today">Hôm nay</a></li>
        <li><a class="dropdown-item" href="?filter=month">Tháng này</a></li>
        <li><a class="dropdown-item" href="?filter=year">Năm nay</a></li>
      </ul>
    </div>

    <div class="card-body">
      <h5 class="card-title">Khách hàng <span>| <?php echo $filter_text; ?></span></h5>

      <div class="d-flex align-items-center">
        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
          <i class="bi bi-people"></i>
        </div>
        <div class="ps-3">
          <h6><?php echo $total_users; ?></h6>
          <span class="text-danger small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">decrease</span>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Recent Sales -->
<div class="col-12">
  <div class="card recent-sales overflow-auto">
    <div class="filter">
      <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
        <li class="dropdown-header text-start">
          <h6>Lọc</h6>
        </li>
        <li><a class="dropdown-item" href="?filter=today">Hôm nay</a></li>
        <li><a class="dropdown-item" href="?filter=month">Tháng này</a></li>
        <li><a class="dropdown-item" href="?filter=year">Năm nay</a></li>
      </ul>
    </div>

    <div class="card-body">
      <h5 class="card-title">Đơn hàng gần đây <span>| <?php echo $filter_text; ?></span></h5>

      <table class="table table-borderless datatable">
        <thead>
          <tr>
            <th scope="col">Mã đơn hàng</th>
            <th scope="col">Khách hàng</th>
            <th scope="col">Sản phẩm</th>
            <th scope="col">Giá</th>
            <th scope="col">Trạng thái</th>
          </tr>
        </thead>
        <tbody>
          <?php
          switch($filter) {
              case 'today':
                  $sql_recent = "SELECT o.*, u.user_name, p.product_name 
                              FROM tbl_order o 
                              JOIN tbl_users u ON o.user_id = u.user_id 
                              JOIN tbl_user_order uo ON o.order_code = uo.order_code 
                              JOIN tbl_product p ON uo.product_id = p.product_id 
                              WHERE DATE(o.order_date) = '$today'
                              ORDER BY o.order_date DESC LIMIT 5";
                  break;
              case 'month':
                  $sql_recent = "SELECT o.*, u.user_name, p.product_name 
                              FROM tbl_order o 
                              JOIN tbl_users u ON o.user_id = u.user_id 
                              JOIN tbl_user_order uo ON o.order_code = uo.order_code 
                              JOIN tbl_product p ON uo.product_id = p.product_id 
                              WHERE DATE(o.order_date) >= '$month_start'
                              ORDER BY o.order_date DESC LIMIT 5";
                  break;
              case 'year':
                  $sql_recent = "SELECT o.*, u.user_name, p.product_name 
                              FROM tbl_order o 
                              JOIN tbl_users u ON o.user_id = u.user_id 
                              JOIN tbl_user_order uo ON o.order_code = uo.order_code 
                              JOIN tbl_product p ON uo.product_id = p.product_id 
                              WHERE DATE(o.order_date) >= '$year_start'
                              ORDER BY o.order_date DESC LIMIT 5";
                  break;
              default:
                  $sql_recent = "SELECT o.*, u.user_name, p.product_name 
                              FROM tbl_order o 
                              JOIN tbl_users u ON o.user_id = u.user_id 
                              JOIN tbl_user_order uo ON o.order_code = uo.order_code 
                              JOIN tbl_product p ON uo.product_id = p.product_id 
                              WHERE DATE(o.order_date) = '$today'
                              ORDER BY o.order_date DESC LIMIT 5";
          }
          $result_recent = mysqli_query($conn, $sql_recent);
          while($row_recent = mysqli_fetch_assoc($result_recent)) {
          ?>
          <tr>
            <th scope="row"><a href="#">#<?php echo $row_recent['order_code']; ?></a></th>
            <td><?php echo $row_recent['user_name']; ?></td>
            <td><?php echo $row_recent['product_name']; ?></td>
            <td><?php echo number_format($row_recent['total_price']); ?> VNĐ</td>
            <td><span class="badge bg-success"><?php echo $row_recent['order_status']; ?></span></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Top Selling -->
<div class="col-12">
  <div class="card top-selling overflow-auto">
    <div class="filter">
      <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
        <li class="dropdown-header text-start">
          <h6>Lọc</h6>
        </li>
        <li><a class="dropdown-item" href="?filter=today">Hôm nay</a></li>
        <li><a class="dropdown-item" href="?filter=month">Tháng này</a></li>
        <li><a class="dropdown-item" href="?filter=year">Năm nay</a></li>
      </ul>
    </div>

    <div class="card-body pb-0">
      <h5 class="card-title">Sản phẩm bán chạy <span>| <?php echo $filter_text; ?></span></h5>

      <table class="table table-borderless">
        <thead>
          <tr>
            <th scope="col">Hình ảnh</th>
            <th scope="col">Sản phẩm</th>
            <th scope="col">Giá</th>
            <th scope="col">Đã bán</th>
            <th scope="col">Doanh thu</th>
          </tr>
        </thead>
        <tbody>
          <?php
          switch($filter) {
              case 'today':
                  $sql_top = "SELECT p.*, COUNT(uo.product_id) as sold_count 
                            FROM tbl_product p 
                            LEFT JOIN tbl_user_order uo ON p.product_id = uo.product_id 
                            LEFT JOIN tbl_order o ON uo.order_code = o.order_code 
                            WHERE DATE(o.order_date) = '$today'
                            GROUP BY p.product_id 
                            ORDER BY sold_count DESC LIMIT 5";
                  break;
              case 'month':
                  $sql_top = "SELECT p.*, COUNT(uo.product_id) as sold_count 
                            FROM tbl_product p 
                            LEFT JOIN tbl_user_order uo ON p.product_id = uo.product_id 
                            LEFT JOIN tbl_order o ON uo.order_code = o.order_code 
                            WHERE DATE(o.order_date) >= '$month_start'
                            GROUP BY p.product_id 
                            ORDER BY sold_count DESC LIMIT 5";
                  break;
              case 'year':
                  $sql_top = "SELECT p.*, COUNT(uo.product_id) as sold_count 
                            FROM tbl_product p 
                            LEFT JOIN tbl_user_order uo ON p.product_id = uo.product_id 
                            LEFT JOIN tbl_order o ON uo.order_code = o.order_code 
                            WHERE DATE(o.order_date) >= '$year_start'
                            GROUP BY p.product_id 
                            ORDER BY sold_count DESC LIMIT 5";
                  break;
              default:
                  $sql_top = "SELECT p.*, COUNT(uo.product_id) as sold_count 
                            FROM tbl_product p 
                            LEFT JOIN tbl_user_order uo ON p.product_id = uo.product_id 
                            LEFT JOIN tbl_order o ON uo.order_code = o.order_code 
                            WHERE DATE(o.order_date) = '$today'
                            GROUP BY p.product_id 
                            ORDER BY sold_count DESC LIMIT 5";
          }
          $result_top = mysqli_query($conn, $sql_top);
          while($row_top = mysqli_fetch_assoc($result_top)) {
          ?>
          <tr>
            <th scope="row">
              <a href="#"><img src="../assets/img/products/<?php echo $row_top['img']; ?>" alt=""></a>
            </th>
            <td><a href="#" class="text-primary fw-bold"><?php echo $row_top['product_name']; ?></a></td>
            <td><?php echo number_format($row_top['product_price']); ?> VNĐ</td>
            <td class="fw-bold"><?php echo $row_top['sold_count']; ?></td>
            <td><?php echo number_format($row_top['product_price'] * $row_top['sold_count']); ?> VNĐ</td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div> 