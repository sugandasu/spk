<?php
  include('../app/settings.php');
  include('../app/database.php');
  include('../app/middleware.php');

  $current_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include("components/meta.php") ?>

  <title>SPK PIP</title>
  <?php include("components/style.php") ?>

</head>

<body id="page-top">
  <!-- Page Wrapper -->
  <div id="wrapper">
    <?php include("components/sidebar.php") ?>
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
      <!-- Main Content -->
      <div id="content">
        <?php include("components/topbar.php") ?>
        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Program Indonesia Pintar (PIP)</h1>
          
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">
                
              </h6>
            </div>
            <div class="card-body">
              <h2>Apa itu PIP?</h2>
              <p class="mb-4">
				<h5>Program Indonesia Pintar (PIP) melalui Kartu Indonesia Pintar (KIP) adalah
				pemberian bantuan tunai pendidikan kepada anak usia sekolah (usia 6 - 21 tahun)
				yang berasal dari keluarga miskin, rentan miskin: pemilik Kartu Keluarga Sejahtera (KKS),
				peserta Program Keluarga Harapan (PKH), yatim piatu, penyandang disabilitas,
				korban bencana alam/musibah.
				PIP merupakan bagian dari penyempurnaan program Bantuan Siswa Miskin (BSM).</h5>
			</p><br><br><br>
			<h2>Apa tujuan PIP?</h2>
			<p class="mb-4">
				<h5>PIP dirancang untuk membantu anak-anak usia sekolah dari keluarga miskin/rentan miskin/prioritas 	tetap mendapatkan layanan pendidikan sampai tamat pendidikan menengah, baik melalui jalur pendidikan formal (	mulai SD/MI hingga anak Lulus SMA/SMK/MA) maupun pendidikan non formal (Paket A hingga Paket C serta kursus 	terstandar).
				Melalui program ini pemerintah berupaya mencegah peserta didik dari kemungkinan putus sekolah, dan diharapkan dapat menarik siswa putus sekolah agar kembali melanjutkan pendidikannya.
				PIP juga diharapkan dapat meringankan biaya personal pendidikan peserta didik, baik biaya langsung maupun tidak langsung.</h5>
			</p>
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- End of Main Content -->
      <?php include("components/footer.php") ?>
    </div>
    <!-- End of Content Wrapper -->
  </div>
  <!-- End of Page Wrapper -->
  <!-- Tambah/Edit Modal-->
  <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTitle">Tambah Kriteria</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form id="modalForm" action="" method="POST" role="form" enctype="multipart/form-data">
          <div id="modalBody" class="modal-body">
            <div class="form-group">
              <label for="nama">Nama</label>
              <input type="text" class="form-control" name="nama" id="nama">
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

  <!-- Delete Modal-->
  <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteModalTitle"></h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form id="deleteModalForm" action="" method="POST" role="form" enctype="multipart/form-data">
          <div id="deleteModalBody" class="modal-body"></div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <button class="btn btn-danger" type="submit">Hapus</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php include("components/logout.php") ?>
  
  <?php include("components/script.php") ?>

  <?php include("components/script-form.php") ?>
  <script>
    document.querySelector('#navDashboard').setAttribute('class', 'nav-item active');
  </script>
</body>

</html>