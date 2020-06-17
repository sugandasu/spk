<?php
  include('../../app/settings.php');
  include('../../app/database.php');
  include('../../app/middleware.php');
  include('../../controllers/dataset.php');
  include('../../controllers/kriteria.php');

  $current_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

  $list_dataset = getDataset($conn);
  $kriteria_id = $_GET['kriteria_id'];
  $kriteria = getKriteriaOne($conn, $kriteria_id);
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
          <h1 class="h3 mb-4 text-gray-800"><a href="<?= $url . '/dashboard/kriteria/' ?>"></a> <?= $kriteria[1] ?> Data Penilaian Dataset</h1>
          <p class="mb-4">Data Penilaian Dataset.</p>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nama</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>ID</th>
                      <th>Nama</th>
                      <th>Aksi</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php if ($list_dataset->num_rows > 0) : ?>
                    <?php while($dataset = $list_dataset->fetch_object()): ?>
                    <tr>
                    <td id="id_<?= $dataset->id ?>" data-value="<?= $dataset->id ?>"><?= $dataset->id ?></td>
                    <td id="nama_<?= $dataset->id ?>" data-value="<?= $dataset->nama ?>"><?= $dataset->nama ?></td>
                      <td>
                        <a href="<?= $url ?>/dashboard/nilai-dataset?kriteria_id=<?= $kriteria_id ?>&dataset_id=<?= $dataset->id ?>" title="Detail Penilaian" id="detail" class="badge badge-primary"><i class="fa fa-paper-plane"></i></a>
                      </td>
                    </tr>
                    <?php endwhile ?>
                    <?php endif ?>
                  </tbody>
                </table>
              </div>
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
    document.querySelector('#navKriteria').setAttribute('class', 'nav-item active');
  </script>
</body>

</html>