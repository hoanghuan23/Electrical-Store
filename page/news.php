<?php
  require('../config/config.php');
  include('../functions/common_function.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
      <link rel="stylesheet" href="../assets/css/style.css">
      <link rel="stylesheet" href="../assets/css/news.css">
      <link rel="stylesheet" href="../assets/css/responsive.css">
      <script src="../assets/js/bootstrap.bundle.min.js"></script>
      <script src="../assets/js/app.js"></script>
    <title>News</title>
</head>
<body>
    <div id="news">
      <?php
        include('../config/header.php');
        echo "
          <div class='row'>
            <a href='index.php' class='back'>
              <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-chevron-left' viewBox='0 0 16 16'>
                <path fill-rule='evenodd' d='M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z'/>
              </svg>
              Trở lại
            </a>
          </div>";
        get_new_detail();
      ?>
    </div>
</body>
</html>