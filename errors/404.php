<?php
  include("../app/settings.php");

  $current_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include("../dashboard/components/meta.php") ?>

  <title>404</title>
  <?php include("../dashboard/components/style.php") ?>
  <style>
    body {
      background-color: #f8f9fc;
    }
  </style>
</head>

<body id="page-top">
  <!-- Page Wrapper -->
  <div id="wrapper">
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
      <!-- Main Content -->
      <div id="content">
        <!-- Begin Page Content -->
         <!-- Begin Page Content -->
         <div class="container-fluid mt-5">
          <!-- 404 Error Text -->
          <div class="text-center">
            <div class="error mx-auto" data-text="404">404</div>
            <p class="lead text-gray-800 mb-5">Page not found</p>
            <p class="text-gray-500 mb-0">It looks like you found a glitch in the matrix...</p>
            <a href="<?= $url ?>/login.php">&larr; Login</a>
          </div>

          </div>
          <!-- /.container-fluid -->
        <!-- /.container-fluid -->
      </div>
      <!-- End of Main Content -->
    </div>
    <!-- End of Content Wrapper -->
  </div>
</body>

</html>