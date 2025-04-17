<?php
  require('../config/config.php');
  include('../functions/common_function.php');
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/css/style.css">
        <link rel="stylesheet" href="../assets/css/product.css">
        <link rel="stylesheet" href="../assets/css/responsive.css">
        <script src="../assets/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/js/app.js"></script>
        <title>Product</title>
    </head>
    <body>
        <div id="product">
            <!-- Header -->
            <?php
                include '../config/header.php';
            ?>
            <!-- End Header -->

            <!-- Begin: Product -->
            <div class="product-content container-fluid">
                <div class="row">
                    <div class="col-sm-12 col-md-3 col-lg-3 prd-left">
                        <div class="prd-type">
                            <ul class="nav nav-tabs">
                                <?php
                                 $select_query="SELECT * FROM tbl_product";
                                 $result_query=mysqli_query($conn,$select_query);
                                 // $row=mysqli_fetch_assoc($result_query);
                                 if(mysqli_num_rows($result_query)>0) {
                                    echo "<li class='line'><a href='product.php'>TẤT CẢ</a></li>";
                                 }          
                                ?>
                            </ul>
                        </div>

                        <div class="prd-tree">
                            <ul class="nav">
                                <li class="prd-nav">
                                    <label class="opt">
                                        DÒNG SẢN PHẨM
                                    </label>
                                    <ul class="subnav-tree">
                                        <?php
                                            getcategory();
                                        ?>
                                    </ul>
                                </li>
                                <li class="prd-nav">
                                    <label class="opt">
                                            TRẠNG THÁI
                                    </label>
                                    <ul class="subnav-tree">
                                        <?php
                                            getstatus();
                                         ?>
                                    </ul>
                                </li>
                                <li class="prd-nav">
                                    <label class="opt">
                                        GIÁ
                                    </label>
                                    <ul class="subnav-tree">
                                        <li><label>> 600k</label></li>
                                        <li><label>500k - 599k</label></li>
                                        <li><label>400k - 499k</label></li>
                                        <li><label>300k - 399k</label></li>
                                        <li><label>200k - 299k</label></li>
                                        <li><label>0 - 200k</label></li>                                        
                                    </ul>
                                </li>
                                <!-- <li class="prd-nav">
                                    <label class="opt">
                                        MÀU SẮC
                                        
                                    </label>
                                    <ul class="subnav-tree">
                                        <?php
                                            // getcolor();
                                        ?>
                                    </ul>
                                </li> -->
                            </ul>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-9 col-lg-9 prd-right">
                        <div class="row prd-banner">
                            <img src="./../assets/img/product/Desktop_Homepage_Banner.jpg" alt="">
                        </div>
                        <div class="row list-prd">
                                <?php
                                    // calling function
                                    getproduct();
                                    // search_product();
                                    get_unique_cate();
                                    get_unique_status();
                                    get_unique_gender();
                                    // cart();
                                    
                                ?>       
                        </div>
                        <div class="row pagination">
                            <?php
                            // include "../config/pagination.php";
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- End: Product -->
            
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