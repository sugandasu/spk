<?php
  include('../../app/settings.php');
  include('../../app/database.php');
  include('../../app/middleware.php');
  include('../../controllers/siswa.php');
  include('../../controllers/kriteria.php');

  $current_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

  $list_siswa = getSiswa($conn);
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
          <h1 class="h3 mb-4 text-gray-800"><a href="<?= $url . '/dashboard/kriteria/' ?>"></a> <?= $kriteria[1] ?> Data Penilaian Siswa</h1>
          <p class="mb-4">Data Penilaian Siswa Calon Penerima PIP SDN Inpress 1 Kawatuna.</p>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Nis</th>
                      <th>Nama</th>
                      <th>Tempat Lahir</th>
                      <th>Tanggal Lahir</th>
                      <th>Gender</th>
                      <th>Alamat</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Nis</th>
                      <th>Nama</th>
                      <th>Tempat Lahir</th>
                      <th>Tanggal Lahir</th>
                      <th>Gender</th>
                      <th>Alamat</th>
                      <th>Aksi</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php if ($list_siswa->num_rows > 0) : ?>
                    <?php while($siswa = $list_siswa->fetch_object()): ?>
                    <tr>
                    <td id="nis_<?= $siswa->id ?>" data-value="<?= $siswa->nis ?>"><?= $siswa->nis ?></td>
                    <td id="nama_<?= $siswa->id ?>" data-value="<?= $siswa->nama ?>"><?= $siswa->nama ?></td>
                    <td id="tempat_lahir_<?= $siswa->id ?>" data-value="<?= $siswa->tempat_lahir ?>"><?= $siswa->tempat_lahir ?></td>
                    <td id="tanggal_lahir_<?= $siswa->id ?>" data-value="<?= $siswa->tanggal_lahir ?>"><?= $siswa->tanggal_lahir ?></td>
                    <td id="gender_<?= $siswa->id ?>" data-value="<?= $siswa->gender ?>"><?= $siswa->gender ? 'Laki-laki' : 'Perempuan' ?></td>
                    <td id="alamat_<?= $siswa->id ?>" data-value="<?= $siswa->alamat ?>"><?= $siswa->alamat ?></td>
                      <td>
                        <a href="<?= $url ?>/dashboard/nilai-siswa?kriteria_id=<?= $kriteria_id ?>&siswa_id=<?= $siswa->id ?>" title="Detail Penilaian" id="detail" class="badge badge-primary"><i class="fa fa-paper-plane"></i></a>
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