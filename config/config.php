<?php
//Khai báo biến
    $x = 10;
    $servername = "localhost";
    $username = "root"; //mặc định username
    $password = ""; //password rỗng
    $db = "btl_web06_stt13";

    $conn = mysqli_connect($servername, $username, $password, $db);

    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }
?>