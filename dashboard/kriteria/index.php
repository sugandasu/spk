<?php
  include('../../app/settings.php');
  include('../../app/database.php');
  include('../../app/middleware.php');
  include('../../controllers/kriteria.php');

  $current_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

  $list_kriteria = getKriteria($conn);
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
          <h1 class="h3 mb-4 text-gray-800">Data PIP</h1>
          <p class="mb-4">Data Calon Penerima PIP </p>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">
                Data Kriteria
                <a href="#" title="Tambah" id="tambah" class="badge badge-primary" data-toggle="modal" data-target="#modal" onclick="tambahForm()"><i class="fa fa-plus"></i></a>
              </h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Nama</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Nama</th>
                      <th>Aksi</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php if ($list_kriteria->num_rows > 0) : ?>
                    <?php while($kriteria = $list_kriteria->fetch_object()): ?>
                    <tr>
                    <td id="nama_<?= $kriteria->id ?>" data-value="<?= $kriteria->nama ?>"><?= $kriteria->nama ?></td>
                      <td>
                        <a href="<?= $url ?>/dashboard/penilaian?kriteria_id=<?= $kriteria->id ?>" title="Detail Kriteria" id="detail" class="badge badge-primary"><i class="fa fa-paper-plane"></i></a>
                        <a href="<?= $url ?>/dashboard/nilai?kriteria_id=<?= $kriteria->id ?>" title="Peniaian" id="nilai" class="badge badge-dark"><i class="fa fa-chart-area"></i></a>
                        <a href="<?= $url ?>/dashboard/ranking?kriteria_id=<?= $kriteria->id ?>" title="Perhitugan/Ranking" id="ranking" class="badge badge-warning"><i class="fa fa-star"></i></a>
                        <a href="#" title="Ubah" id="ubah" class="badge badge-info" data-toggle="modal" data-target="#modal"
                          onclick="editForm(<?= $kriteria->id ?>)"><i class="fa fa-edit"></i></a>
                        <a href="#" title="hapus" id="hapus" class="badge badge-danger" data-toggle="modal"
                          data-target="#deleteModal" onclick="deleteForm(<?= $kriteria->id ?>)"><i class="fa fa-trash"></i></a>
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
  <?php include("../components/logout.php") ?>
  
  <?php include("../components/script.php") ?>

  <?php include("../components/script-form.php") ?>
  <script>
    document.querySelector('#navKriteria').setAttribute('class', 'nav-item active');

    function tambahForm() {
      resetForm();
      
      const options = {url: "<?= $url ?>/controllers/kriteria.php?aksi=tambah", method: 'POST', title: 'Tambah', buttonClass: 'btn btn-primary'};
      setForm(options);
    }

    function editForm(id) {
      const options = {url: `<?= $url ?>/controllers/kriteria.php?aksi=ubah&id=${id}`, method: 'PUT', title: 'Ubah', buttonClass: 'btn btn-info'};
      setForm(options);
      const columns = ['nama'];
      setFormInput(columns, id);
    }

    function deleteForm(id) {
      const url = `<?= $url ?>/controllers/kriteria.php?aksi=hapus&id=${id}`;
      const modalForm = document.querySelector('#deleteModalForm');
      const modalTitle = document.querySelector('#deleteModalTitle');
      const modalBody = document.querySelector('#deleteModalBody');
      const data = document.querySelector(`#nama_${id}`);

      modalForm.setAttribute('action', url);
      modalTitle.innerHTML = 'Hapus';
      modalBody.innerHTML = 'Apakah anda yakin ingin menghapus data kriteria ' + data.innerHTML;
    }
  </script>
</body>

</html>