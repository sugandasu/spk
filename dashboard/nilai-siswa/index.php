<?php
  include('../../app/settings.php');
  include('../../app/database.php');
  include('../../app/middleware.php');
  include('../../controllers/siswa.php');
  include('../../controllers/kriteria.php');
  include('../../controllers/nilai.php');

  $current_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

  $siswa_id = $_GET['siswa_id'];
  $kriteria_id = $_GET['kriteria_id'];
  $siswa = getSiswaOne($conn, $siswa_id);
  $kriteria = getKriteriaOne($conn, $kriteria_id);

  $list_nilai = getNilai($conn, $siswa_id, $kriteria_id);
  $form_name = getFormName($conn, $kriteria_id);
  $list_form = getForm($conn, $kriteria_id);

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
          <h1 class="h3 mb-4 text-gray-800"><a href="<?= $url . '/dashboard/kriteria/' ?>"></a> <a href="<?= $url . '/dashboard/nilai/?kriteria_id=' . $kriteria[0] ?>"><?= $kriteria[1] ?></a> Nilai Siswa <?= $siswa[2] ?></h1>
          <p class="mb-4">Data Penilaian siswa <?= $siswa[2] ?> Perkriteria</p>
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">
                Data Kriteria
                <?php if($list_nilai->num_rows <= 0) : ?>
                <a href="#" title="Tambah" id="tambah" class="badge badge-primary" data-toggle="modal" data-target="#modal" onclick="tambahForm()"><i class="fa fa-plus"></i></a>
                <?php else: ?>
                <a href="#" title="Ubah" id="ubah" class="badge badge-info" data-toggle="modal" data-target="#modal" onclick="editForm(1)"><i class="fa fa-edit"></i></a>
                <a href="#" title="hapus" id="hapus" class="badge badge-danger" data-toggle="modal" data-target="#deleteModal" onclick="deleteForm()"><i class="fa fa-trash"></i></a>
                <?php endif ?>
              </h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Kriteria</th>
                      <th>Nilai</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Kriteria</th>
                      <th>Nilai</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php if ($list_nilai->num_rows > 0) : ?>
                    <?php while ($nilai = $list_nilai->fetch_object()) : ?>
                      
                      <tr>
                        <?php $kriterianPenilaian = getPenilaianOne($conn, $nilai->kriteria_penilaian_id) ?>
                        
                        <td><?= $kriterianPenilaian[2] ?></td>
                        <?php if ($kriterianPenilaian[6] == 'select') : ?>
                          <?php $pilihan = getPilihanOne($conn, $nilai->kriteria_penilaian_id, $nilai->nilai) ?>
                          
                          <td id="<?= $kriterianPenilaian[3] . '_1' ?>" data-value="<?= $nilai->nilai ?>"><?= $pilihan[2] ?></td>
                        <?php else : ?>
                          
                          <td id="<?= $kriterianPenilaian[3] . '_1' ?>" data-value="<?= $nilai->nilai ?>"><?= $nilai->nilai ?></td>
                        <?php endif ?>
                      
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
          <input type="hidden" name="siswa_id" value="<?= $siswa_id ?>">
          <input type="hidden" name="kriteria_id" value="<?= $kriteria_id ?>">
          <?php foreach ($list_form as $form) : ?>
            <?php if ($form['inputType'] == 'input') : ?>
              
              <div id="modalBody" class="modal-body">
                <div class="form-group">
                  <label for="<?= $form['nama'] ?>"><?= $form['text'] ?></label>
                  <input type="<?= $form['type'] ?>" class="form-control" name="<?= $form['nama'] ?>" id="<?= $form['nama'] ?>">
                </div>
              </div>
            <?php else : ?>
              
              <div id="modalBody" class="modal-body">
                <div class="form-group">
                  <label for="<?= $form['nama'] ?>"><?= $form['text'] ?></label>
                  <select name="<?= $form['nama'] ?>" id="<?= $form['nama'] ?>" class="form-control">
                    <option value=""></option>                    
                    <?php foreach ($form['selectData'] as $option) : ?>
                
                    <option value="<?= $option['nilai'] ?>"><?= $option['text'] ?></option>
                    <?php endforeach ?>
                  
                  </select>
                </div>
              </div>
            <?php endif ?>
          <?php endforeach ?>
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
          <div id="deleteModalBody" class="modal-body">
            <input type="hidden" name="siswa_id" value="<?= $siswa_id ?>">
            <input type="hidden" name="kriteria_id" value="<?= $kriteria_id ?>">
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <button class="btn btn-danger" type="submit">Hapus</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- End of Page Wrapper -->
  <?php include("../components/logout.php") ?>

  <?php include("../components/script.php") ?>

  <?php include("../components/script-form.php") ?>
  <script>
    document.querySelector('#navKriteria').setAttribute('class', 'nav-item active');

    function tambahForm() {
      const options = {
        url: "<?= $url ?>/controllers/nilai.php?aksi=tambah&siswa_id=<?= $siswa_id ?>&kriteria_id=<?= $kriteria_id ?>",
        title: 'Tambah',
        buttonClass: 'btn btn-primary'
      };
      setForm(options);
    }

    function editForm(id) {
      const options = {
        url: "<?= $url ?>/controllers/nilai.php?aksi=ubah&siswa_id=<?= $siswa_id ?>&kriteria_id=<?= $kriteria_id ?>",
        title: 'Ubah',
        buttonClass: 'btn btn-info'
      };
      setForm(options);
      const columns = <?= json_encode($form_name) ?>;
      setFormInput(columns, id);
    }

    function deleteForm() {
      const url = '<?= $url ?>/controllers/nilai.php?aksi=hapus&siswa_id=<?= $siswa_id ?>&kriteria_id=<?= $kriteria_id ?>';
      const modalForm = document.querySelector('#deleteModalForm');
      const modalTitle = document.querySelector('#deleteModalTitle');
      const modalBody = document.querySelector('#deleteModalBody');

      modalForm.setAttribute('action', url);
      modalTitle.innerHTML = 'Hapus';
      modalBody.innerHTML = 'Apakah anda yakin ingin menghapus nilai siswa dengan nama <?= $siswa[2] ?>';
    }

    $('#dataTable').DataTable({
      "pageLength": 20
    });
  </script>
</body>

</html>