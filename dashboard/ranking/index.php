<?php
  include('../../app/settings.php');
  include('../../app/database.php');
  include('../../app/middleware.php');
  include('../../controllers/dataset.php');
  include('../../controllers/kriteria.php');
  include('../../controllers/ranking.php');
  include('../../controllers/nilai.php');
  include('../../controllers/smart.php');

  $current_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

  $kriteria_id = $_GET['kriteria_id'];
  $kriteria = getKriteriaOne($conn, $kriteria_id);
  $list_dataset = getDataset($conn);

  $bobot = getKriteriaPenilaians($conn, $kriteria_id);
  // echo "<pre>";
  // print_r($bobot);
  // echo "</pre>";

  $smart = new Smart();
  $bobot_baru = $smart->normasilasi_bobot($bobot);
  // echo "<pre>";
  // print_r($bobot_baru);
  // echo "</pre>";

  $list_nilai_dataset = getListDatasetNilai($conn, $kriteria_id);
  // echo "<pre>";
  // print_r($list_nilai_dataset);
  // echo "</pre>";

  $list_nilai_dataset_baru = $smart->hitung_nilai_utility($list_nilai_dataset, $bobot_baru);
  // echo "<pre>";
  // print_r($list_nilai_dataset_baru);
  // echo "</pre>";

  $ranking = $smart->ranking($list_nilai_dataset_baru);
  // echo "<pre>";
  // print_r($ranking);
  // echo "</pre>";
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
          <h1 class="h3 mb-4 text-gray-800"><a href="<?= $url . '/dashboard/kriteria/' ?>"></a> Data Perhitungan Siswa</h1>
          <p class="mb-4">Data Perhitungan TOPSIS Calon Penerima PIP</p>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">
                Jawaban Dataset
              </h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nama</th>
                      <?php foreach($bobot as $b): ?>
                      <th><?= $b["text"] . "(" . $b["bobot"] . ")" ?></th>
                      <?php endforeach ?>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>ID</th>
                      <th>Nama</th>
                      <?php foreach($bobot as $b): ?>
                      <th><?= $b["text"] . "(" . $b["bobot"] . ")" ?></th>
                      <?php endforeach ?>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php if ($list_dataset->num_rows > 0) : ?>
                    <?php while($dataset = $list_dataset->fetch_object()): ?>
                    <?php 
                      $nilai_dataset = getNilaiDataset($conn, $dataset->id, $kriteria_id); 
                      if ($nilai_dataset->num_rows > 0):
                    ?>
                    <tr>
                      <td><?= $dataset->id ?></td>
                      <td><?= $dataset->nama ?></td>
                      <?php while ($nilai = $nilai_dataset->fetch_object()): ?>
                      <?php $kriterianPenilaian = getPenilaianOne($conn, $nilai->kriteria_penilaian_id) ?>
                      <?php if ($kriterianPenilaian[6] == 'select') : ?>
                        <?php $pilihan = getPilihanOne($conn, $nilai->kriteria_penilaian_id, $nilai->nilai) ?>
                        
                        <td><?= $pilihan[2] ?></td>
                      <?php else : ?>
                        
                        <td><?= $nilai->nilai ?></td>
                      <?php endif ?>
                      <?php endwhile ?>
                    </tr>
                    <?php endif ?>
                    <?php endwhile ?>
                    <?php endif ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">
                Nilai Dataset
              </h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTableFuzzy" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nama</th>
                      <?php foreach($bobot as $b): ?>
                      <th><?= $b["text"] . "(" . $b["bobot"] . ")" ?></th>
                      <?php endforeach ?>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>ID</th>
                      <th>Nama</th>
                      <?php foreach($bobot as $b): ?>
                      <th><?= $b["text"] . "(" . $b["bobot"] . ")" ?></th>
                      <?php endforeach ?>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php foreach ($list_nilai_dataset as $dataset): ?>
                    <tr>
                      <td><?= $dataset['id'] ?></td>
                      <td><?= $dataset['nama'] ?></td>
                      <?php $kriteria_penilaian = getKriteriaPenilaian($conn, $kriteria_id); 
                      if($kriteria_penilaian->num_rows > 0): ?>
                      <?php while ($penilaian = $kriteria_penilaian->fetch_object()): ?>
                      <td><?= $dataset[$penilaian->nama] ?></td>
                      <?php endwhile ?>
                      <?php endif ?>
                    </tr>
                    <?php endforeach ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">
                Nilai Utility Dataset
              </h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTableNormalisasi" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nama</th>
                      <?php foreach($bobot_baru as $b): ?>
                      <th><?= $b["text"] . "(" . $b["bobot"] . ")" ?></th>
                      <?php endforeach ?>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>ID</th>
                      <th>Nama</th>
                      <?php foreach($bobot_baru as $b): ?>
                      <th><?= $b["text"] . "(" . $b["bobot"] . ")" ?></th>
                      <?php endforeach ?>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php foreach ($list_nilai_dataset_baru as $d): ?>
                    <tr>
                    <td><?= $d['id'] ?></td>
                      <td><?= $d['nama'] ?></td>
                      <?php foreach($bobot as $b): ?>
                      <td><?= $d[$b["nama"]] ?></td>
                      <?php endforeach ?>
                    </tr>
                    <?php endforeach ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">
                Nilai Akhir Alternatif
              </h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTableBobot" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nama</th>
                      <th>Nilai Akhir</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>ID</th>
                      <th>Nama</th>
                      <th>Nilai Akhir</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php foreach ($list_nilai_dataset_baru as $d): ?>
                    <tr>
                    <td><?= $d['id'] ?></td>
                      <td><?= $d['nama'] ?></td>
                      <td><?= $d["nilai_akhir"] ?></td>
                    </tr>
                    <?php endforeach ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">
                Ranking
              </h6>
            </div>
            <div class="card-body">
              <a class="nav-item" href="<?= $url ?>/dashboard/laporan?kriteria_id=<?= $kriteria_id ?>">
                <i class="fas fa-fw fa-print"></i>
                <span>Cetak</span>
              </a>
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTableBobot" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nama</th>
                      <th>Nilai Akhir</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>ID</th>
                      <th>Nama</th>
                      <th>Nilai Akhir</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php foreach ($ranking as $d): ?>
                    <tr>
                    <td><?= $d['id'] ?></td>
                      <td><?= $d['nama'] ?></td>
                      <td><?= $d["nilai_akhir"] ?></td>
                    </tr>
                    <?php endforeach ?>
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
    $('#dataTableFuzzy').dataTable();
    $('#dataTableNormalisasi').dataTable();
    $('#dataTableBobot').dataTable();
    $('#dataTableSIP').dataTable();
    $('#dataTableSIN').dataTable();
    $('#dataTableJSIP').dataTable();
    $('#dataTableJSIN').dataTable();
    $('#dataTableRank').dataTable( {
      "order": [[ 2, 'desc' ]]
    });
    document.querySelector('#navKriteria').setAttribute('class', 'nav-item active');
  </script>
</body>

</html> 