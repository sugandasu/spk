<?php
  include('app/settings.php');

  $current_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include("dashboard/components/meta.php") ?>

  <title>SPK PIP</title>
  <?php include("dashboard/components/style.php") ?>

</head>

<body id="page-top">
  <!-- Page Wrapper -->
  <div id="wrapper">
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
      <!-- Main Content -->
      <div id="content">
        <!-- Begin Page Content -->
        <div class="container-fluid col-lg-4 col-md-6 col-sm-8">
          <!-- Page Heading -->
          <div class="card shadow mb-4 mt-5">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">
                Login
              </h6>
            </div>
            <div class="card-body">
              <form id="modalForm" action="<?= $url ?>/controllers/admin.php?aksi=login" method="POST" role="form" enctype="multipart/form-data">
                <div id="modalBody" class="modal-body">
                  <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username" id="username">
                  </div>
                </div>
                <div id="modalBody" class="modal-body">
                  <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password">
                  </div>
                </div>
                <div class="modal-footer">
                  <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                  <button id="modalButton" class="btn btn-primary" type="submit">Login</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- End of Main Content -->
    </div>
    <!-- End of Content Wrapper -->
  </div>
</body>

</html>