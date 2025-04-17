<?php
  include('../config/config.php');
  include('../functions/common_function.php');
  ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thiết bị điện công nghiệp</title>
    <link rel="icon" href="../assets/img/logo/lego.png">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/responsive.css">
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/app.js"></script>
  </head>

  <body>
    <div id="main">
      <!-- Header -->
      <?php
                include '../config/header.php';
      ?>
      <!-- End Header -->


      <!-- Banner -->
      <div id="home-banner1">
        <a href="product.php">
          <img src="../assets/img/banner1/electronics.png" alt="" class="slider">
        </a>
      </div>
      <!-- End Banner -->

      <!-- Content -->
      <div id="content">
        <!-- Home Collection -->
        <div class="home-collection ">
          <div class="row">
            <div class="col-xs-6 col-md-6 col-lg-6 left">
              <div class="collection-list">
                <div class="adv-collection">
                  <a href="product.php">
                    <img src="../assets/img/collection/2.png" alt="">
              </a>
                </div>
                <div class="content-collection">
                  <h3 class="title">
                    <a href="product.php">ALL BLACK IN BLACK</a>
                  </h3>
                  <!-- <p class = desc>Sự kiện giảm giá hàng tháng với nhiều ưu đãi hấp dẫn</p> -->
                </div>
              </div>
            </div>
            <div class="col-xs-6 col-md-6 col-lg-6 right">
              <div class="collection-list">
                <div class="adv-collection">
                  <a href="product.php">
                    <img src="../assets/img/collection/3.png" alt="" >
                  </a>
                </div>
                <div class="content-collection">
                  <h3 class="title">
                    <a href="product.php">OUT LET SALE</a>
                  </h3>
                  <!-- <p class="desc">Ưu đãi điện tử đặc biệt hàng tuần với những món "cực hot: và tiết kiệm tối đa</p> -->
                </div>
            </div>
            </div>
          </div>
        </div>
        <!-- End Home Collection -->

        <!-- Home Buy -->
        <div class="home-buy container-fluid">
          <div class="row title">CÁC SẢN PHẨM NỔI BẬT</div>

          <div class="row">
            <div class="col-md-4 col-lg-4 item">
              <div class="item-background">
                <!-- <div class="item-bg"></div> -->
                <img src="../assets/img/buy/anh1.png" alt="">
              </div>
              <div class="item-group">
                <a href="product.php" class="item-title">MUA NGAY</a>
                <!-- <a href="product.php" class="subgroup">New Arivals</a>
                <a href="product.php" class="subgroup">Best Saller</a>
                <a href="product.php" class="subgroup">Sale-off</a> -->
              </div>
            </div>
            <div class="col-md-4 col-lg-4 item">
              <div class="item-background">
                <!-- <div class="item-bg"></div> -->
                <img src="../assets/img/buy/anh2.png" alt="">
              </div>
              <div class="item-group">
                <a href="product.php" class="item-title">MUA NGAY</a>
                <!-- <a href="product.php" class="subgroup">New Arivals</a>
                <a href="product.php" class="subgroup">Best Saller</a>
                <a href="product.php" class="subgroup">Sale-off</a> -->
              </div>
            </div>
            <div class="col-md-4 col-lg-4 item">
              <div class="item-background">
                <!-- <div class="item-bg"></div> -->
                <img src="../assets/img/buy/anh3.png" alt="">
              </div>
              <div class="item-group">
                <a href="product.php" class="item-title">MUA NGAY</a>
                <!-- <a href="product.php" class="subgroup">Basas</a>
                <a href="product.php" class="subgroup">Vintas</a>
                <a href="product.php" class="subgroup">Urbas</a>
                <a href="product.php" class="subgroup">Pattas</a> -->
              </div>
            </div>
          </div>
        </div>
        <!-- End Home Buy -->


        <!-- Banner 2 -->
        <div class="home-banner2">
            <!-- <a href="#"> -->
              <img src="../assets/img/banner2/slide2.png" alt="">
            <!-- </a> -->
        </div>
        <!-- End Banner 2 -->


        <!-- News -->
        <div class="home-instagram container-fluid">
          <div class="row">
            <!-- Left: Instagram -->
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 left">
              <div class="row title">
                <a href="https://www.instagram.com/" class="title">SẢN PHẨM BÁN CHẠY</a>
              </div>
            </div>
            <!-- Right: News -->
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 right">
              <div class="row title">TIN TỨC & BÀI VIẾT</div>
              <div class="row news-list">
                <?php
                  get_new();
                ?>
              </div>
            </div>
          </div>

          <div class="row news-more">
            <a href="#" class="btn btn-load-more">
              <button class="btn btn-load-more">MUỐN XEM NỮA</button>
            </a>
          </div>
        </div>
        <!-- End News -->

      </div>

      <!-- Footer -->
      <?php
        include '../config/footer.php';
      ?>
      <!-- End Footer -->

      <!-- Cart and Social -->
      <?php
        include '../config/cart&social.php';
      ?>
      
    </div>
  </body>
</html>