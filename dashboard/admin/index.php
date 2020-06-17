<?php
  include('../../app/settings.php');
  include('../../app/database.php');
  include('../../app/middleware.php');

  $current_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include("../components/meta.php") ?>

  <title>SPK PIP</title>
  <?php include("../components/style.php") ?>

</head>

<body id="page-top">
  <!-- Page Wrapper -->
  <div id="wrapper">
    <?php include("../components/sidebar.php") ?>
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
      <!-- Main Content -->
      <div id="content">
        <?php include("../components/topbar.php") ?>
        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Data User</h1>
          <p class="mb-4">Data admin spk.</p>
          <!-- DataTales Example -->
          <div class="card shadow mb-4 col-lg-6 offset-lg-3">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">
                Data Admin
              </h6>
            </div>
            <div class="card-body">
              <form id="modalForm" action="<?= $url ?>/controllers/admin.php?aksi=ubah&user_id=<?= $user[0] ?>" method="POST" role="form" enctype="multipart/form-data">
                <div id="modalBody" class="modal-body">
                  <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" class="form-control" name="name" id="name">
                  </div>
                </div>
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
                  <button id="modalButton" class="btn btn-primary" type="submit">Simpan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- End of Main Content -->
      <?php include("../components/footer.php") ?>
    </div>
    <!-- End of Content Wrapper -->
  </div>
  <!-- End of Page Wrapper -->
  <?php include("../components/logout.php") ?>
  
  <?php include("../components/script.php") ?>

  <?php include("../components/script-form.php") ?>
  <script>
    document.querySelector('#navAdmin').setAttribute('class', 'nav-item active');
  </script>
</body>

</html>