<?php
  include('../../app/settings.php');
  include('../../app/database.php');
  include('../../app/middleware.php');
  include('../../controllers/siswa.php');
  include('../../controllers/kriteria.php');
  include('../../controllers/ranking.php');
  include('../../controllers/nilai.php');

  $current_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

  $kriteria_id = $_GET['kriteria_id'];
  $kriteria = getKriteriaOne($conn, $kriteria_id);
  $list_siswa = getSiswa($conn);
  $data = Topsis($conn, $kriteria_id);
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
                Nilai Siswa
              </h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Nis</th>
                      <th>Nama</th>
                      <?php $kriteria_penilaian = getKriteriaPenilaian($conn, $kriteria_id); 
                      if($kriteria_penilaian->num_rows > 0): ?>
                      <?php while ($penilaian = $kriteria_penilaian->fetch_object()): ?>
                      <th><?= $penilaian->text ?></th>
                      <?php endwhile ?>
                      <?php endif ?>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Nis</th>
                      <th>Nama</th>
                      <?php $kriteria_penilaian = getKriteriaPenilaian($conn, $kriteria_id); 
                      if($kriteria_penilaian->num_rows > 0): ?>
                      <?php while ($penilaian = $kriteria_penilaian->fetch_object()): ?>
                      <th><?= $penilaian->text ?></th>
                      <?php endwhile ?>
                      <?php endif ?>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php if ($list_siswa->num_rows > 0) : ?>
                    <?php while($siswa = $list_siswa->fetch_object()): ?>
                    <?php 
                      $nilai_siswa = getNilaiSiswa($conn, $siswa->id, $kriteria_id); 
                      if ($nilai_siswa->num_rows > 0):
                    ?>
                    <tr>
                      <td><?= $siswa->nis ?></td>
                      <td><?= $siswa->nama ?></td>
                      <?php while ($nilai = $nilai_siswa->fetch_object()): ?>
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
                Nilai Siswa Fuzzy
              </h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTableFuzzy" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Nis</th>
                      <th>Nama</th>
                      <?php $kriteria_penilaian = getKriteriaPenilaian($conn, $kriteria_id); 
                      if($kriteria_penilaian->num_rows > 0): ?>
                      <?php while ($penilaian = $kriteria_penilaian->fetch_object()): ?>
                      <th><?= $penilaian->text ?></th>
                      <?php endwhile ?>
                      <?php endif ?>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Nis</th>
                      <th>Nama</th>
                      <?php $kriteria_penilaian = getKriteriaPenilaian($conn, $kriteria_id); 
                      if($kriteria_penilaian->num_rows > 0): ?>
                      <?php while ($penilaian = $kriteria_penilaian->fetch_object()): ?>
                      <th><?= $penilaian->text ?></th>
                      <?php endwhile ?>
                      <?php endif ?>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php foreach ($data['siswa_list'] as $siswa): ?>
                    <tr>
                      <td><?= $siswa['nama'] ?></td>
                      <td><?= $siswa['nis'] ?></td>
                      <?php $kriteria_penilaian = getKriteriaPenilaian($conn, $kriteria_id); 
                      if($kriteria_penilaian->num_rows > 0): ?>
                      <?php while ($penilaian = $kriteria_penilaian->fetch_object()): ?>
                      <td><?= $siswa[$penilaian->nama] ?></td>
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
                Nilai Siswa Normalisasi
              </h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTableNormalisasi" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Nis</th>
                      <th>Nama</th>
                      <?php $kriteria_penilaian = getKriteriaPenilaian($conn, $kriteria_id); 
                      if($kriteria_penilaian->num_rows > 0): ?>
                      <?php while ($penilaian = $kriteria_penilaian->fetch_object()): ?>
                      <th><?= $penilaian->text . "(" . $data['kriteria_rumus'][$penilaian->nama] . ")" ?></th>
                      <?php endwhile ?>
                      <?php endif ?>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Nis</th>
                      <th>Nama</th>
                      <?php $kriteria_penilaian = getKriteriaPenilaian($conn, $kriteria_id); 
                      if($kriteria_penilaian->num_rows > 0): ?>
                      <?php while ($penilaian = $kriteria_penilaian->fetch_object()): ?>
                      <th><?= $penilaian->text . "(" . $data['kriteria_rumus'][$penilaian->nama] . ")" ?></th>
                      <?php endwhile ?>
                      <?php endif ?>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php foreach ($data['siswa_normalisasi'] as $siswa): ?>
                    <tr>
                      <td><?= $siswa['nama'] ?></td>
                      <td><?= $siswa['nis'] ?></td>
                      <?php $kriteria_penilaian = getKriteriaPenilaian($conn, $kriteria_id); 
                      if($kriteria_penilaian->num_rows > 0): ?>
                      <?php while ($penilaian = $kriteria_penilaian->fetch_object()): ?>
                      <td><?= $siswa[$penilaian->nama] ?></td>
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
                Nilai Siswa Bobot
              </h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTableBobot" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Nis</th>
                      <th>Nama</th>
                      <?php $kriteria_penilaian = getKriteriaPenilaian($conn, $kriteria_id); 
                      if($kriteria_penilaian->num_rows > 0): ?>
                      <?php while ($penilaian = $kriteria_penilaian->fetch_object()): ?>
                        <th><?= $penilaian->text . "(" . $penilaian->bobot . ")" ?></th>
                      <?php endwhile ?>
                      <?php endif ?>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Nis</th>
                      <th>Nama</th>
                      <?php $kriteria_penilaian = getKriteriaPenilaian($conn, $kriteria_id); 
                      if($kriteria_penilaian->num_rows > 0): ?>
                      <?php while ($penilaian = $kriteria_penilaian->fetch_object()): ?>
                      <th><?= $penilaian->text . "(" . $penilaian->bobot . ")" ?></th>
                      <?php endwhile ?>
                      <?php endif ?>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php foreach ($data['siswa_bobot'] as $siswa): ?>
                    <tr>
                      <td><?= $siswa['nama'] ?></td>
                      <td><?= $siswa['nis'] ?></td>
                      <?php $kriteria_penilaian = getKriteriaPenilaian($conn, $kriteria_id); 
                      if($kriteria_penilaian->num_rows > 0): ?>
                      <?php while ($penilaian = $kriteria_penilaian->fetch_object()): ?>
                      <td><?= $siswa[$penilaian->nama] ?></td>
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
                Nilai Solusi Ideal Positif
              </h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTableSIP" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Nis</th>
                      <th>Nama</th>
                      <?php $kriteria_penilaian = getKriteriaPenilaian($conn, $kriteria_id); 
                      if($kriteria_penilaian->num_rows > 0): ?>
                      <?php while ($penilaian = $kriteria_penilaian->fetch_object()): ?>
                      <th><?= $penilaian->text . "(" . $data['ip'][$penilaian->nama] . ")" ?></th>
                      <?php endwhile ?>
                      <?php endif ?>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Nis</th>
                      <th>Nama</th>
                      <?php $kriteria_penilaian = getKriteriaPenilaian($conn, $kriteria_id); 
                      if($kriteria_penilaian->num_rows > 0): ?>
                      <?php while ($penilaian = $kriteria_penilaian->fetch_object()): ?>
                      <th><?= $penilaian->text . "(" . $data['ip'][$penilaian->nama] . ")" ?></th>
                      <?php endwhile ?>
                      <?php endif ?>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php foreach ($data['siswa_ip'] as $siswa): ?>
                    <tr>
                      <td><?= $siswa['nama'] ?></td>
                      <td><?= $siswa['nis'] ?></td>
                      <?php $kriteria_penilaian = getKriteriaPenilaian($conn, $kriteria_id); 
                      if($kriteria_penilaian->num_rows > 0): ?>
                      <?php while ($penilaian = $kriteria_penilaian->fetch_object()): ?>
                      <td><?= $siswa[$penilaian->nama] ?></td>
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
                Nilai Solusi Ideal Negatif
              </h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTableSIN" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Nis</th>
                      <th>Nama</th>
                      <?php $kriteria_penilaian = getKriteriaPenilaian($conn, $kriteria_id); 
                      if($kriteria_penilaian->num_rows > 0): ?>
                      <?php while ($penilaian = $kriteria_penilaian->fetch_object()): ?>
                      <th><?= $penilaian->text . "(" . $data['in'][$penilaian->nama] . ")" ?></th>
                      <?php endwhile ?>
                      <?php endif ?>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Nis</th>
                      <th>Nama</th>
                      <?php $kriteria_penilaian = getKriteriaPenilaian($conn, $kriteria_id); 
                      if($kriteria_penilaian->num_rows > 0): ?>
                      <?php while ($penilaian = $kriteria_penilaian->fetch_object()): ?>
                      <th><?= $penilaian->text . "(" . $data['in'][$penilaian->nama] . ")" ?></th>
                      <?php endwhile ?>
                      <?php endif ?>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php foreach ($data['siswa_in'] as $siswa): ?>
                    <tr>
                      <td><?= $siswa['nama'] ?></td>
                      <td><?= $siswa['nis'] ?></td>
                      <?php $kriteria_penilaian = getKriteriaPenilaian($conn, $kriteria_id); 
                      if($kriteria_penilaian->num_rows > 0): ?>
                      <?php while ($penilaian = $kriteria_penilaian->fetch_object()): ?>
                      <td><?= $siswa[$penilaian->nama] ?></td>
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
                Nilai Jarak Solusi Ideal Positif
              </h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTableJSIP" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Nis</th>
                      <th>Nama</th>
                      <th>Solusi</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Nis</th>
                      <th>Nama</th>
                      <th>Solusi</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php foreach ($data['siswa_list'] as $siswa): ?>
                    <tr>
                      <td><?= $siswa['nama'] ?></td>
                      <td><?= $siswa['nis'] ?></td>
                      <td><?= $siswa['jarak_sip'] ?></td>
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
                Nilai Jarak Solusi Ideal Negatif
              </h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTableJSIN" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Nis</th>
                      <th>Nama</th>
                      <th>Solusi</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Nis</th>
                      <th>Nama</th>
                      <th>Solusi</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php foreach ($data['siswa_list'] as $siswa): ?>
                    <tr>
                      <td><?= $siswa['nama'] ?></td>
                      <td><?= $siswa['nis'] ?></td>
                      <td><?= $siswa['jarak_sin'] ?></td>
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
                Nilai Preferensi Siswa
              </h6>
            </div>
            <div class="card-body">
               <a class="nav-item" href="<?= $url ?>/dashboard/laporan?kriteria_id=<?= $kriteria_id ?>">
                    <i class="fas fa-fw fa-print"></i>
                    <span>Cetak</span></a>



              <div class="table-responsive">
                <table class="table table-bordered" id="dataTableRank" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Nis</th>
                      <th>Nama</th>
                      <th>Hasil</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Nis</th>
                      <th>Nama</th>
                      <th>Hasil</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php foreach ($data['siswa_list'] as $siswa): ?>
                    <tr>
                      <td><?= $siswa['nama'] ?></td>
                      <td><?= $siswa['nis'] ?></td>
                      <td><?= $siswa['nilai_preferensi'] ?></td>
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