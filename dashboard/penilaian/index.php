<?php
  include('../../app/settings.php');
  include('../../app/database.php');
  include('../../app/middleware.php');
  include('../../controllers/penilaian.php');

  $current_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

  $kriteria_id = $_GET['kriteria_id'];
  $list_penilaian = getPenilaian($conn, $kriteria_id);
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
          <h1 class="h3 mb-4 text-gray-800">Data Kriteria Penerima PIP SDN Inpress 1 Kawatuna</h1>
          
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">
                Tambah Data Kriteria
                <a href="#" title="Tambah Data" id="tambah" class="badge badge-primary" data-toggle="modal" data-target="#modal" onclick="tambahForm()"><i class="fa fa-plus"></i></a>
               </h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Text</th>
                      <th>Nama</th>
                      <th>Bobot</th>
                      <th>Tipe Nilai</th>
                      <th>Tipe Masukan</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Text</th> 
                      <th>Nama</th>
                      <th>Bobot</th>
                      <th>Tipe Nilai</th>
                      <th>Tipe Masukan</th>
                      <th>Aksi</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php if ($list_penilaian->num_rows > 0) : ?>
                    <?php while($penilaian = $list_penilaian->fetch_object()): ?>
                    <tr>
                      <td id="text_<?= $penilaian->id ?>" data-value="<?= $penilaian->text ?>"><?= $penilaian->text ?></td>
                      <td id="nama_<?= $penilaian->id ?>" data-value="<?= $penilaian->nama ?>"><?= $penilaian->nama ?></td>
                      <td id="bobot_<?= $penilaian->id ?>" data-value="<?= $penilaian->bobot ?>"><?= $penilaian->bobot ?></td>
                      <td id="tipe_nilai_<?= $penilaian->id ?>" data-value="<?= $penilaian->tipe_nilai ?>"><?= ucfirst($penilaian->tipe_nilai) ?></td>
                      <td id="tipe_form_<?= $penilaian->id ?>" data-value="<?= $penilaian->tipe_form ?>"><?= $penilaian->tipe_form == 'select' ? 'Pilihan' : 'Nilai' ?></td>
                      <td>
                        <?php if ($penilaian->tipe_form == 'select'): ?>
                        <a href="<?= $url ?>/dashboard/pilihan?kriteria_penilaian_id=<?= $penilaian->id ?>" title="Detail Subkriteria" id="detail" class="badge badge-primary"><i class="fa fa-paper-plane"></i></a>
                        <?php endif ?>
                        <a href="#" title="Ubah" id="ubah" class="badge badge-info" data-toggle="modal" data-target="#modal"
                          onclick="editForm(<?= $penilaian->id ?>)"><i class="fa fa-edit"></i></a>
                        <a href="#" title="hapus" id="hapus" class="badge badge-danger" data-toggle="modal"
                          data-target="#deleteModal" onclick="deleteForm(<?= $penilaian->id ?>)"><i class="fa fa-trash"></i></a>
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
          <input type="hidden" name="kriteria_id" value="<?= $kriteria_id ?>">
          <div id="modalBody" class="modal-body">
            <div class="form-group">
              <label for="text">Text</label>
              <input type="text" class="form-control" name="text" id="text">
            </div>
          </div>
          <div id="modalBody" class="modal-body">
            <div class="form-group">
              <label for="bobot">Bobot</label>
              <input type="number" step="0.01" class="form-control" name="bobot" id="bobot">
            </div>
          </div>
          <div id="modalBody" class="modal-body">
            <div class="form-group">
              <label for="tipe_nilai">Tipe Nilai</label>
              <select name="tipe_nilai" id="tipe_nilai" class="form-control">
                <option value=""></option>
                <option value="max">Max</option>
                <option value="min">Min</option>
              </select>
            </div>
          </div>
          <div id="modalBody" class="modal-body">
            <div class="form-group">
              <label for="tipe_form">Tipe Masukan</label>
              <select name="tipe_form" id="tipe_form" class="form-control">
                <option value=""></option>
                <option value="input">Nilai</option>
                <option value="select">Pilihan</option>
              </select>
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
      
      const options = {url: "<?= $url ?>/controllers/penilaian.php?aksi=tambah&kriteria_id=<?= $kriteria_id ?>", method: 'POST', title: 'Tambah', buttonClass: 'btn btn-primary'};
      setForm(options);
    }

    function editForm(id) {
      const options = {url: `<?= $url ?>/controllers/penilaian.php?aksi=ubah&id=${id}&kriteria_id=<?= $kriteria_id ?>`, method: 'PUT', title: 'Ubah', buttonClass: 'btn btn-info'};
      setForm(options);
      const columns = ['text', 'bobot', 'tipe_nilai', 'tipe_form'];
      setFormInput(columns, id);
    }

    function deleteForm(id) {
      const url = `<?= $url ?>/controllers/penilaian.php?aksi=hapus&id=${id}&kriteria_id=<?= $kriteria_id ?>`;
      const modalForm = document.querySelector('#deleteModalForm');
      const modalTitle = document.querySelector('#deleteModalTitle');
      const modalBody = document.querySelector('#deleteModalBody');
      const data = document.querySelector(`#nama_${id}`);

      modalForm.setAttribute('action', url);
      modalTitle.innerHTML = 'Hapus';
      modalBody.innerHTML = 'Apakah anda yakin ingin menghapus data penilaian ' + data.innerHTML;
    }
  </script>
</body>

</html>