        <div class="cartfixed hidden-xs hidden-sm">
            <a href="cart.php">
                <span class="countProduct"><?php
                    if (!isset($_SESSION['username'])) {echo"0";}
                    else{ cart_item(); cart();}?></span>
            </a>
            <a href="index.php">
                <img src="../assets/img/cart/icon_gio_hang.svg" alt="">
            </a>
        </div>

        <div class="social">
            <a href="#">
            <img src="../assets/img/social/icon_facebook_2.svg" alt="">
            </a>
            <a href="#">
            <img src="../assets/img/social/icon_instagram_2.svg" alt="">
            </a>
            <a href="#">
            <img src="../assets/img/social/icon_youtube_2.svg" alt="">
            </a>      
        </div>