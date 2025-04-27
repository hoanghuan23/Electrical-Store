<?php
    include('../config/config.php');
    
        // displaying category 
        function getcategory() {
            global $conn;
            $select_cate = "SELECT * FROM tbl_category";
            $result_cate = mysqli_query($conn,$select_cate);
            while($row_data = mysqli_fetch_assoc($result_cate)) {
                    $cate_name = $row_data['cate_name'];
                    $cate_id = $row_data['cate_id'];
                    echo "<li><a href='product.php?category=$cate_id'><label>$cate_name</label></a></li>";
                }
            }

        // display status
        function getstatus() {
            global $conn; 
            echo"<li><a href='product.php?status=3'><label>Hàng có sẵn</label></a></li>";
            echo"<li><a href='product.php?status=0'><label>Phiên bản mới</label></a></li>";
            echo"<li><a href='product.php?status=1'><label>Khuyến mãi</label></a></li>";
            echo"<li><a href='product.php?status=2'><label>Sản phẩm đặc biệt</label></a></li>";
        }

        // display color 
        function getcolor(){
            global $conn; 
            echo "<li><label>Jet Black</label></li>";
            echo "<li><label>White</label></li>";
            echo "<li><label>Offwhite/Gum</label></li>";
            echo "<li><label>Bluewash</label></li>";
            echo "<li><label>Corluray Mix</label></li>";
            echo "<li><label>Golden Orange</label></li>";
            echo "<li><label>Snow White</label></li>";
            echo "<li><label>Vibrant Orange</label></li>";
            echo "<li><label>Offwhite</label></li>";
            echo "<li><label>Black/White</label></li>";
            echo "<li><label>Tie Dye</label></li>";
            echo "<li><label>Black/Brown</label></li>";
            echo "<li><label>Red</label></li>";
        }


        //getting products
        function getproduct() {
            global $conn;
            
            // condition to check isset or not 
            if(!isset($_GET['category'])) {
                if(!isset($_GET['data_gender'])) {
                    if(!isset($_GET['status'])) {
                        // rand() hiển thị ngẫu nhiên
                        // BƯỚC 2: TÌM TỔNG SỐ RECORDS
                        $select_query="SELECT count(product_id) as total from tbl_product";
                        $result_query=mysqli_query($conn,$select_query);
                        $row=mysqli_fetch_assoc($result_query);
                        $total_records = $row['total'];
        
                        // BƯỚC 3: TÌM LIMIT VÀ CURRENT_PAGE
                        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                        $limit = 6; 
        
                        // BƯỚC 4: TÍNH TOÁN TOTAL_PAGE VÀ START
                        // tổng số trang
                        $total_page = ceil($total_records / $limit);
                        // Giới hạn current_page trong khoảng 1 đến total_page
                        if ($current_page > $total_page){
                            $current_page = $total_page;
                        }
                        else if ($current_page < 1){
                            $current_page = 1;
                        }             
                        // Tìm Start
                        $start = ($current_page - 1) * $limit;
                        // BƯỚC 5: TRUY VẤN LẤY DANH SÁCH SẢN PHẨM
                        // Có limit và start rồi thì truy vấn CSDL lấy danh sách SẢN PHẨM
                        $result_query = mysqli_query($conn, "SELECT * FROM tbl_product LIMIT $start, $limit");
                        // PHẦN HIỂN THỊ SẢN PHẨM
                        // BƯỚC 6: HIỂN THỊ DANH SÁCH SẢN PHẨM                                                                  
                        while($row=mysqli_fetch_assoc($result_query)) {
                            $product_id = $row['product_id'];
                            $product_name = $row['product_name'];
                            $product_color = $row['product_color'];
                            $product_price = number_format($row['product_price'], 0, '', '.');
                            $img = $row['img'];
                            $img_hover = $row['img_hover'];
                            $s = "";
                            // Khi status = 0 là Limited Edition, 1 là Online Only, 2 là Sale off, 3 là New Arrival
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
                            echo "
                                <div class='col-sm-6 col-md-4 col-lg-4 list-item'>
                                    <div class='item img-thumbnail'>
                                        <a href='product_detail.php?product_id=$product_id'>
                                            <img src='./../admin/quanlysanpham/upload/$img' alt='' class='img-item'>
                                            <img src='./../admin/quanlysanpham/upload/$img_hover' alt='' class='img-item-hover'>
                                        </a>
                                    </div>
                                    <div class='btn-buy'>";
                            if(!isset($_SESSION['username'])) {
                                echo "<a href='../user_area/login.php' class='btn btn-buy-now'>THÊM VÀO GIỎ HÀNG</a>";
                            } else {
                                echo "<a href='product.php?add_to_cart=$product_id' class='btn btn-buy-now'>THÊM VÀO GIỎ HÀNG</a>";
                            }
                            echo "</div>
                                    <div class='caption'>
                                        <h3 class='type'>$s</h3>
                                        <h3 class='name'>
                                            <a href='product_detail.php?product_id=$product_id' >$product_name</a>
                                        </h3>
                                        <h3 class='color'>$product_color (số lượng {$row['product_quantity']})</h3>
                                                
                                        <h3 class='price'>$product_price VNĐ</h3>
                                    </div>
                                </div>";  
                            
                                // BƯỚC 7: HIỂN THỊ PHÂN TRANG
                            }
                                echo "<div class='row pagination'>";
                                        for ($i = 1; $i <= $total_page; $i++){
                                            if ($i == $current_page){
                                                echo '<span>'.$i.'</span>' ;
                                            }
                                            else{
                                                echo '<a href="product.php?page='.$i.'">'.$i.'</a>  ';
                                            }
                                        }
                                echo "</div>";
                            
                    }                      
                }
            }
        }
        

        // getting unique category
        function get_unique_cate() {
            global $conn; 
            // condition to check isset or not 
            if(isset($_GET['category'])) {
                if(!isset($_GET['data_gender'])) {
                    if(!isset($_GET['status'])) {
                        $cate_id = $_GET['category'];
                        $select_query="SELECT * FROM tbl_product where cate_id=$cate_id";
                        $result_query=mysqli_query($conn,$select_query);
                        $num_of_rows=mysqli_num_rows($result_query);
                        if($num_of_rows == 0) {
                            echo "<h2>Không có sản phẩm nào!</h2>";
                        }

                        // $row=mysqli_fetch_assoc($result_query);
                        while($row=mysqli_fetch_assoc($result_query)) {
                            $product_id = $row['product_id'];
                            $product_name = $row['product_name'];
                            $product_color = $row['product_color'];
                            $product_price = number_format($row['product_price'], 0, '', '.');
                            $img = $row['img'];
                            $img_hover = $row['img_hover'];
                            $s = "";
                            // Khi status = 0 là Limited Edition, 1 là Online Only, 2 là Sale off, 3 là New Arrival
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
                            echo "
                                <div class='col-sm-6 col-md-4 col-lg-4 list-item'>
                                    <div class='item img-thumbnail'>
                                        <a href='product_detail.php?product_id=$product_id'>
                                            <img src='./../admin/quanlysanpham/upload/$img' alt='' class='img-item'>
                                            <img src='./../admin/quanlysanpham/upload/$img_hover' alt='' class='img-item-hover'>
                                        </a>
                                    </div>
                                    <div class='btn-buy'>
                                        <a href='product.php?add_to_cart=$product_id' class='btn btn-buy-now'>THÊM VÀO GIỎ HÀNG</a>
                                    </div>
                                    <div class='caption'>
                                        <h3 class='type'>$s</h3>
                                        <h3 class='name'>
                                            <a href='product_detail.php?product_id=$product_id' >$product_name</a>
                                        </h3>
                                        <h3 class='color'>$product_color</h3>
                                        <h3 class='price'>$product_price VNĐ</h3>
                                    </div>
                                </div>";                          
                        }
                    }   
                }
            }
        }


                // hiển thị sản phẩm theo trạng thái
                function get_unique_status() {
                    global $conn; 
                    // condition to check isset or not 
                    if (isset($_GET['status']) && in_array($_GET['status'], ['0', '1', '2', '3'])) {
                        $status = mysqli_real_escape_string($conn, $_GET['status']);
                        $select_query = "SELECT * FROM tbl_product WHERE status = $status";
                
                        $result_query = mysqli_query($conn, $select_query);
                        $num_of_rows = mysqli_num_rows($result_query);
                
                        if ($num_of_rows == 0) {
                            echo "<h2>Không có sản phẩm nào!</h2>";
                        }           
                        else {
                                    while($row=mysqli_fetch_assoc($result_query)) {
                                        $product_id = $row['product_id'];
                                        $product_name = $row['product_name'];
                                        $product_color = $row['product_color'];
                                        $product_price = number_format($row['product_price'], 0, '', '.');
                                        $img = $row['img'];
                                        $img_hover = $row['img_hover'];
                                        $s = "";
                                        // Khi status = 0 là Limited Edition, 1 là Online Only, 2 là Sale off, 3 là New Arrival
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
                                        echo "
                                            <div class='col-sm-6 col-md-4 col-lg-4 list-item'>
                                                <div class='item img-thumbnail'>
                                                    <a href='product_detail.php?product_id=$product_id'>
                                                        <img src='./../admin/quanlysanpham/upload/$img' alt='' class='img-item'>
                                                        <img src='./../admin/quanlysanpham/upload/$img_hover' alt='' class='img-item-hover'>
                                                    </a>
                                                </div>
                                                <div class='btn-buy'>
                                                    <a href='product.php?add_to_cart=$product_id' class='btn btn-buy-now'>THÊM VÀO GIỎ HÀNG</a>
                                                </div>
                                                <div class='caption'>
                                                    <h3 class='type'>$s</h3>
                                                    <h3 class='name'>
                                                        <a href='product_detail.php?product_id=$product_id' >$product_name</a>
                                                    </h3>
                                                    <h3 class='color'>$product_color</h3>
                                                            
                                                    <h3 class='price'>$product_price VNĐ</h3>
                                                </div>
                                            </div>";           
                                    }               
                                }
                            }
                        }
        
        
        // hiển thị sản phẩm theo giới tính
            function get_unique_gender() {
                global $conn;
            
                if (isset($_GET['data_gender']) && ($_GET['data_gender'] == 'men' || $_GET['data_gender'] == 'women')) {
                    // $gender = mysqli_real_escape_string($conn, $_GET['data_gender']); có nhiệm vụ bảo vệ chống lại tấn công SQL injection bằng cách xử lý chuỗi dữ liệu trước khi sử dụng nó trong một truy vấn SQL
                    // chuỗi đầu vào là $_GET['data_gender'] và chuỗi đã được xử lý an toàn được gán cho biến $gender
                    $gender = mysqli_real_escape_string($conn, $_GET['data_gender']);
                    $select_query = "SELECT * FROM tbl_product WHERE gender = '$gender'";
                    if (!isset($_GET['category']) && !isset($_GET['status'])) {
                        $result_query = mysqli_query($conn, $select_query);
                        while($row=mysqli_fetch_assoc($result_query)) {
                            $product_id = $row['product_id'];
                            $product_name = $row['product_name'];
                            $product_color = $row['product_color'];
                            $product_price = number_format($row['product_price'], 0, '', '.');
                            $img = $row['img'];
                            $img_hover = $row['img_hover'];
                            $s = "";
                            // Khi status = 0 là Limited Edition, 1 là Online Only, 2 là Sale off, 3 là New Arrival
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
                            echo "
                                <div class='col-sm-6 col-md-4 col-lg-4 list-item'>
                                    <div class='item img-thumbnail'>
                                        <a href='product_detail.php?product_id=$product_id'>
                                            <img src='./../admin/quanlysanpham/upload/$img' alt='' class='img-item'>
                                            <img src='./../admin/quanlysanpham/upload/$img_hover' alt='' class='img-item-hover'>
                                        </a>
                                    </div>
                                    <div class='btn-buy'>
                                        <a href='product.php?add_to_cart=$product_id' class='btn btn-buy-now'>THÊM VÀO GIỎ HÀNG</a>
                                    </div>
                                    <div class='caption'>
                                        <h3 class='type'>$s</h3>
                                        <h3 class='name'>
                                            <a href='product_detail.php?product_id=$product_id' >$product_name</a>
                                        </h3>
                                        <h3 class='color'>$product_color</h3>
                                                
                                        <h3 class='price'>$product_price VNĐ</h3>
                                    </div>
                                </div>";                        
                            }
                        }
                    }
                }
        
                
            


        // chi tiết sản phẩm
        function get_product_detail() {
            global $conn;

            if (isset($_GET['product_id'])) {
                $product_id = $_GET['product_id'];
                $select_query="SELECT * FROM `tbl_product` where product_id=$product_id";
                $result_query=mysqli_query($conn,$select_query);
                // $row=mysqli_fetch_assoc($result_query);
                while($row=mysqli_fetch_assoc($result_query)) {
                    $product_name = $row['product_name'];
                    $product_color = $row['product_color'];
                    $product_price = number_format($row['product_price'], 0, '', '.');
                    $product_code = $row['product_code'];
                    $img = $row['img'];
                    $img_hover = $row['img_hover'];
                    $s = "";
                    $product_quantity = $row['product_quantity'];
                    $product_desc = $row['product_desc'];
                    // Khi status = 0 là Limited Edition, 1 là Online Only, 2 là Sale off, 3 là New Arrival
                    if($row["status"] == 0) {
                        $s = "Phiên bản mới";
                    }
                    elseif($row["status"] == 1) {
                        $s = "Khuyến mãi";
                    }
                    elseif($row["status"] == 2) {
                        $s = "Sản phẩm đặc biệt";   
                    }
                    else {
                        $s = "Hàng có sẵn";   
                    }
                    
                    echo "
                        <div class='prd_detail container-fluid'>
                            <div class='row'>
                                <div class='col-md-6 prd-left'>
                                <div id='carouselExampleAutoplaying' class='carousel slide' data-bs-ride='carousel'>
                                    <div class='carousel-inner'>
                                        <div class='carousel-item active'>
                                        <img src='./../admin/quanlysanpham/upload/$img' class='d-block w-100' alt='...'>
                                        </div>
                                        <div class='carousel-item'>
                                        <img src='./../admin/quanlysanpham/upload/$img_hover' class='d-block w-100' alt='...'>
                                        </div>
                                    </div>
                                    <button class='carousel-control-prev' type='button' data-bs-target='#carouselExampleAutoplaying' data-bs-slide='prev'>
                                        <span class='carousel-control-prev-icon' aria-hidden='true'></span>
                                        <span class='visually-hidden'>Previous</span>
                                    </button>
                                    <button class='carousel-control-next' type='button' data-bs-target='#carouselExampleAutoplaying' data-bs-slide='next'>
                                        <span class='carousel-control-next-icon' aria-hidden='true'></span>
                                        <span class='visually-hidden'>Next</span>
                                    </button>
                                    </div>
                                </div>
                                <div class='col-md-6 prd-right'>
                                    <h4>$product_name</h4>
                                    <h5>THÔNG TIN SẢN PHẨM:</h5>
                                    <div class='prd_code'>Mã sản phẩm: <span>$product_code</span></div>
                                    <div class='prd_status'>Tình trạng: <span>$s</span></div>
                                    <div class='prd_color'>Màu sắc: <span>$product_color</span></div>
                                    <div class='prd_price'>Giá: <span>$product_price VNĐ</span></div>
                                    <div class='prd_quantity'>Số lượng: <span>$product_quantity</span></div>
                                    <div class='prd_desc'>
                                        Mô tả:
                                        <p>$product_desc</p>
                                    </div>
                                    <button type='submit'><a href='product.php?add_to_cart=$product_id'>THÊM VÀO GIỎ HÀNG</a></button>
                    
                                </div>
                            </div>
                        </div>";
                }
            }

            
        }
            
        // Hiển thị tin tức trang chủ

        function get_new() {
            global $conn; 

            $select_query = "SELECT * FROM tbl_news";
            $result_query = mysqli_query($conn, $select_query);
            while($row=mysqli_fetch_assoc($result_query)) {
                    $new_id = $row["new_id"];
                    $title = $row["title"];
                    $news_desc = $row["news_desc"];
                    $img = $row["img"];
                    echo "
                        <div class='col-sm-6 col-md-6 col-lg-6 post-item'>
                            <a href='news.php?new_id=$new_id'>
                                <img src='./../admin/quanlytintuc/upload/$img' alt=''>
                            </a>
                            <h3 class='post-title'>
                                <a href='news.php?new_id=$new_id'>$title</a>
                            </h3>
                            <h3 class='post-desc'>$news_desc</h3>
                            <h3 class='post-detail'>
                                <a href='news.php?new_id=$new_id'>Đọc thêm</a>
                            </h3>
                        </div>";
                  }
        }

        // Hiển thị video trang chủ
        function get_video() {
            global $conn;
            $youtube_video_id = "OIO3hKyN7ko";
            
            echo '
                <div class="video-container">
                    <iframe width="600" height="780" 
                        src="https://www.youtube.com/embed/'.$youtube_video_id.'" 
                        title="YouTube video player" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen>
                    </iframe>
                </div>
            ';
        }

        // Hiển thị chi tiết tin tức
        function get_new_detail() {
            global $conn;

            if (isset($_GET['new_id'])) {
                $new_id = $_GET['new_id'];
                $select_query="SELECT * FROM `tbl_news` where new_id=$new_id";
                $result_query=mysqli_query($conn,$select_query);
                // $row=mysqli_fetch_assoc($result_query);
                while($row=mysqli_fetch_assoc($result_query)) {
                    $new_id = $row["new_id"];
                    $title = $row["title"];
                    $news_desc = $row["news_desc"];
                    $img = $row["img"];
                    $img2 = $row["img2"];
                    $img3 = $row["img3"];
                    $img_note = $row["img_note"];
                    $cont1 = $row["cont1"];
                    $cont2 = $row ["cont2"];
                    $cont3 = $row ["cont3"];
                    $post_date = $row["date"];
                    $author = $row["author"];
        
                    echo "
                        <div class='news-detail-banner container-fluid'>
                        <img src='./../admin/quanlytintuc/upload/$img' alt=''>
                        </div>
            
                        <div class='news-detail-content container-fluid'>
                          <div class='news-detail-title container-fluid'>
                            <h3 class='title'>$title</h3>
                          </div>
            
                          <div class='news-detail-date container-fluid'>
                              <span class='date'>$post_date |</span> $author
                          </div>
            
                          <div class='news-detail-cont container-fluid'>
                            <br>
                              <p>$cont1</p>
                            <br>
                              <p>$cont2</p>
                            <br>
                              <p>$cont3</p>
                            <br>
                            <div class='row cont-img'>
                              <div class='col-sm-6 col-md-6 left'>
                                  <img src='./../admin/quanlytintuc/upload/$img2' alt=''>
                              </div>
                              <div class='col-sm-6 col-md-6 right'>
                                  <img src='./../admin/quanlytintuc/upload/$img3' alt=''>
                              </div>
                            </div>  
                            <br>
                            <div class='img-note'>$img_note</div>
                          </div>
                        </div>  
                    ";        
                }
            }
        }


        // searching product
        function search_product() {
            global $conn;        
            $search_query = "";    
            if(isset($_POST['btn_search'])){
                $key = $_POST['key'];
                $search_query="SELECT * FROM tbl_product where product_name like '%".$key."%' ";
            }
            else {
                $search_query = "SELECT * FROM tbl_product";
            }
            $result_query = mysqli_query($conn, $search_query);    
            if(mysqli_num_rows($result_query) == 0) {
                echo "<h2>No results match. No products found on this category!</h2>";
            }            
            if (mysqli_num_rows($result_query) > 0) {
                while($row=mysqli_fetch_assoc($result_query)) {
                    $product_id = $row['product_id'];
                    $product_name = $row['product_name'];
                    $product_color = $row['product_color'];
                    $product_price = number_format($row['product_price'], 0, '', '.');
                    $img = $row['img'];
                    $img_hover = $row['img_hover'];
                    $s = "";
                    // Khi status = 0 là Limited Edition, 1 là Online Only, 2 là Sale off, 3 là New Arrival
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
                    echo "
                        <div class='col-sm-6 col-md-4 col-lg-4 list-item'>
                            <div class='item img-thumbnail'>
                                <a href='product_detail.php?product_id=$product_id'>
                                    <img src='./../admin/quanlysanpham/upload/$img' alt='' class='img-item'>
                                    <img src='./../admin/quanlysanpham/upload/$img_hover' alt='' class='img-item-hover'>
                                </a>
                            </div>
                            <div class='btn-buy'>
                                <a href='product.php?add_to_cart=$product_id' class='btn btn-buy-now'>THÊM VÀO GIỎ HÀNG</a>
                            </div>
                            <div class='caption'>
                                <h3 class='type'>$s</h3>
                                <h3 class='name'>
                                    <a href='product_detail.php?product_id=$product_id' >$product_name</a>
                                </h3>
                                <h3 class='color'>$product_color</h3>
                                        
                                <h3 class='price'>$product_price VNĐ</h3>
                            </div>
                        </div>";                          
                    
                }
            }
        }
        

        // get IP Address function
        function getIPAddress() {  
            //Hàm kiểm tra xem có tồn tại địa chỉ IP từ "share internet" không. Điều này thường được sử dụng khi người dùng truy cập trang web từ một mạng chia sẻ 
             if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
                        $ip = $_SERVER['HTTP_CLIENT_IP'];  
                }  
            //Truy cập trang web qua một proxy server  
            elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
                        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
             }  
            //Đây là địa chỉ IP thực của máy tính hoặc thiết bị kết nối đến trang web  
            else{  
                     $ip = $_SERVER['REMOTE_ADDR'];  
             }  
             return $ip;  
        }  
        // $ip = getIPAddress();  
        // echo 'User Real IP Address - '.$ip;  
        

        // cart function
        function cart() {
            if(isset($_GET['add_to_cart'])) {
                global $conn;
                if (!isset($_SESSION['username'])) {
                    header(location: "../user_area/login/php");
                }
                else {
                    $get_ip_add = getIPAddress();
                    $get_product_id = $_GET['add_to_cart'];
                    $select_query = "SELECT * from  `tbl_cart_detail` where ip_address='$get_ip_add' and product_id=$get_product_id";
                    $result_query = mysqli_query($conn, $select_query);
                    $num_of_rows = mysqli_num_rows($result_query);
                    if ($num_of_rows > 0) {
                        echo "<script>alert('Sản phẩm này đã có trong giỏ hàng')</script>";
                        echo "<script>window.open('cart.php','_self')</script>";
                    } 
                    else {
                        $insert_query = "INSERT INTO `tbl_cart_detail` (product_id, ip_address, quantity)
                                            VALUES ($get_product_id,'$get_ip_add',1)";
                        $result_query = mysqli_query($conn, $insert_query);
                        echo "<script>window.open('cart.php','_self')</script>";
                    }
                }
            }
        }

        // function to get cart item numbers
        function cart_item() {
            $total_quantity = 0;
            if(isset($_GET['add_to_cart'])) {
                global $conn;
                $get_ip_add = getIPAddress();
                $select_query = "SELECT * from  `tbl_cart_detail` where ip_address='$get_ip_add'";
                $result_query = mysqli_query($conn, $select_query);
                // tổng số sản phẩm
                while($row=mysqli_fetch_array($result_query)) {
                    $quantiy = array(($row['quantity']));
                    $quantity_value = array_sum($quantiy);
                    $total_quantity += $quantity_value;
                }
            }
            else {
                global $conn;
                $get_ip_add = getIPAddress();
                $select_query = "SELECT * from  `tbl_cart_detail` where ip_address='$get_ip_add'";
                $result_query = mysqli_query($conn, $select_query);
                // tổng số sản phẩm
                while($row=mysqli_fetch_array($result_query)) {
                    $quantiy = array(($row['quantity']));
                    $quantity_value = array_sum($quantiy);
                    $total_quantity += $quantity_value;                }
            }
            echo $total_quantity;
        }
        
        // total price function
        function total_cart_price() {
            global $conn;
            $get_ip_add = getIPAddress();
            $total_price = 0;
            $cart_query = "SELECT * FROM `tbl_cart_detail` WHERE ip_address = '$get_ip_add'";
            $result = mysqli_query($conn, $cart_query);
            while($row=mysqli_fetch_array($result)) {
                $product_id = $row['product_id'];
                $select_product = "SELECT * FROM `tbl_product` WHERE product_id = '$product_id'";            
                $result_product = mysqli_query($conn, $select_product);
                while($row_prd_price=mysqli_fetch_array($result_product)) {
                    $product_price = array($row_prd_price['product_price']);
                    $product_values = array_sum($product_price);
                    $total_price += $product_values;
                }                
            }
            echo $total_price;
        }


        function checkout() {
            global $conn;
            if(isset($_GET["task"]) && $_GET["task"]=="checkout") {
                if(isset($_SESSION['username'])) {
                    $user_ip = $_GET['ip'];
                    $select_query="SELECT * FROM tbl_users where user_ip ='$user_ip'";
                    $result_query=mysqli_query($conn,$select_query);
                    while($row=mysqli_fetch_assoc($result_query)) {
                        $user_name = $row['user_name'];
                        $user_mobile = $row['user_mobile'];
                        $user_address = $row['user_address'];
                        $user_email = $row['user_email'];

                        echo "
                                <p class='form-row form-row-wide'>
                                    <input type='text' class='input-text' id='inputSuccess2' placeholder='HỌ TÊN' name='customerName' value = $user_name>
                                </p>
                                <p class='form-row form-row-wide'>
                                    <input type='text' class='input-text' id='inputSuccess2' placeholder='Số điện thoại' name='customerPhone' value = $user_mobile>
                                </p>
                                <p class='form-row form-row-wide'>
                                    <input type='text' class='input-text' id='inputSuccess2' placeholder='Email' name='customerEmail' value = $user_email>
                                </p>
                                <p class='form-row form-row-wide'>
                                    <textarea class='input-text' id='inputError2' placeholder='Địa chỉ' name='customerAddress'>$user_address</textarea>
                                </p>
                                <p class='form-row form-row-wide'>
                                    <input type='checkbox' class='information'>
                                    <label class='checkbox'>Cập nhật các thông tin mới nhất về chương trình từ Ananas</label>
                                </p>
                        ";
                    }
                }
        
            } 
        }

        // chi tiết người dùng đặt hàng
        function get_user_order_detail() {
            global $conn;
            
            // Xử lý hủy đơn hàng
            if(isset($_GET['cancel_order']) && isset($_GET['user_id'])) {
                $order_code = mysqli_real_escape_string($conn, $_GET['cancel_order']);
                $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
                
                // Kiểm tra kết nối database
                if($conn) {
                    $update_status = "UPDATE tbl_order SET order_status = 'Đã hủy' WHERE order_code = '$order_code'";
                    $result_update = mysqli_query($conn, $update_status);
                    
                    if($result_update) {
                        echo "<script>window.location.href='../user_area/order.php?user_id=" . $user_id . "'</script>";
                    } else {
                        echo "<script>alert('Có lỗi xảy ra khi hủy đơn hàng: " . mysqli_error($conn) . "')</script>";
                    }
                } else {
                    echo "<script>alert('Không thể kết nối đến cơ sở dữ liệu!')</script>";
                }
            }
            
            echo"
                     <table class='table'>
                     <thead>
                         <tr>
                             <th class = 'infor order-code' style='width: 10%'>Mã đơn hàng</th>
                             <th class = 'infor order-products' style='width: 20%'>Sản phẩm</th>
                             <th class = 'infor order-quantity' style='width: 8%'>Số lượng</th>
                             <th class = 'infor order-name' style='width: 12%'>Họ tên</th>
                             <th class = 'infor order-phone' style='width: 10%'>Điện thoại</th>
                             <th class = 'infor order-date' style='width: 10%'>Ngày đặt</th>
                             <th class = 'infor order-total' style='width: 12%'>Thành tiền</th>
                             <th class = 'infor order-add' style='width: 12%'>Địa chỉ</th>
                             <th class = 'infor order-note' style='width: 6%'>Trạng thái</th>
                             <th class = 'infor order-action' style='width: 8%'>Thao tác</th>
                         </tr>
                     </thead>
                     <tbody>";

                if(isset($_GET['user_id'])) {
                    $user_id = $_GET['user_id'];
                    $sql_order = "SELECT * FROM `tbl_order` where user_id = $user_id";
                    $result_order = mysqli_query($conn, $sql_order);
                    while($row=mysqli_fetch_array($result_order)) {
                        $status = $row['order_status'];
                        $order_date = $row['order_date'];
                        $order_total_price = $row['total_price'];
                        $order_code = $row['order_code'];
                        $order_id =$row['order_id'];

                        // Lấy thông tin sản phẩm từ bảng user_order
                        $sql_products = "SELECT GROUP_CONCAT(product_name) as products, SUM(quantity) as total_quantity 
                                       FROM `tbl_user_order` 
                                       WHERE order_code = $order_code";
                        $result_products = mysqli_query($conn, $sql_products);
                        $product_info = mysqli_fetch_array($result_products);
                        $products = $product_info['products'];
                        $total_quantity = $product_info['total_quantity'];

                        $sql_contact = "SELECT * FROM `tbl_user_contact` where order_code = $order_code";
                        $result_contact = mysqli_query($conn, $sql_contact);
                        while($row=mysqli_fetch_array($result_contact)) {
                            $user_name = $row['user_name'];
                            $user_phone = $row['user_phone'];
                            $user_email = $row['user_email'];
                            $user_add = $row['user_address'];
                            $user_note = $row['user_note'];
                            
                            // Hiển thị nút hủy đơn hàng chỉ khi trạng thái không phải là "Đã hủy" hoặc "Đã giao hàng"
                            $cancel_button = '';
                            if($status != "Đã hủy" && $status != "Đã giao hàng") {
                                $cancel_button = "<a href='../user_area/order.php?user_id=$user_id&cancel_order=$order_code' class='btn btn-danger btn-sm' onclick='return confirm(\"Bạn có chắc chắn muốn hủy đơn hàng này?\")'>
                                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-x-circle' viewBox='0 0 16 16'>
                                                        <path d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z'/>
                                                        <path d='M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z'/>
                                                    </svg> Hủy 
                                                </a>";
                            }
                            
                            // Hiển thị trạng thái với màu sắc tương ứng
                            $status_display = $status;
                            $status_class = '';
                            
                            if($status == "Đang xử lý") {
                                $status_class = "text-warning";
                            } elseif($status == "Đang giao hàng") {
                                $status_class = "text-primary";
                            } elseif($status == "Đã giao hàng") {
                                $status_class = "text-success";
                            } elseif($status == "Đã hủy") {
                                $status_class = "text-danger";
                            }
                            
                            echo "
                            <tr>
                                <td class= 'order'>$order_code</td>
                                <td class= 'order'>$products</td>
                                <td class= 'order'>$total_quantity</td>
                                <td class= 'order'>$user_name</td>
                                <td class= 'order'>$user_phone</td>
                                <td class= 'order'>$order_date</td>
                                <td class= 'order'>".number_format($order_total_price, 0, ',', '.')." VND</td>
                                <td class= 'order'>$user_add</td>
                                <td class= 'order'><span class='$status_class'>$status_display</span></td>
                                <td class= 'order'>$cancel_button</td>
                            </tr>";
                        }
                    }
                echo "
                        </tbody>
                    </table>";
                }
        }

    ?>