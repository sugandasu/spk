<?php

function getNilai($conn, $siswa_id, $kriteria_id)
{
  $sql = "SELECT * FROM siswa_nilais WHERE siswa_id=$siswa_id AND kriteria_id=$kriteria_id";
  $result = $conn->query($sql);

  return $result;
}

function getPenilaianOne($conn, $kriteria_penilaian_id)
{
  $sql = "SELECT * FROM kriteria_penilaians WHERE id=$kriteria_penilaian_id";
  $result = $conn->query($sql);

  if ($result->num_rows <= 0) {
    return [];
  }

  return $result->fetch_row();
}

function getPilihanOne($conn, $kriteria_penilaian_id, $nilai)
{
  $sql = "SELECT * FROM kriteria_penilaian_pilihans WHERE kriteria_penilaian_id=$kriteria_penilaian_id AND nilai=$nilai";
  $result = $conn->query($sql);

  if ($result->num_rows <= 0) {
    return [];
  }

  return $result->fetch_row();
}

function getFormName($conn, $kriteria_id)
{
  $sql = "SELECT * FROM kriteria_penilaians WHERE kriteria_id=$kriteria_id";
  $result = $conn->query($sql);

  if ($result->num_rows <= 0) {
    return [];
  }

  $list_form_name = array();

  while ($form_result = $result->fetch_object()) {
    $list_form_name[] = $form_result->nama;
  }

  return $list_form_name;
}

function getForm($conn, $kriteria_id)
{
  $sql = "SELECT * FROM kriteria_penilaians WHERE kriteria_id=$kriteria_id";
  $result = $conn->query($sql);

  if ($result->num_rows <= 0) {
    return [];
  }

  $list_form = array();

  while ($form_result = $result->fetch_object()) {
    $input_form = array();
    $input_form['text'] = $form_result->text;
    $input_form['nama'] = $form_result->nama;
    $input_form['inputType'] = $form_result->tipe_form;

    if ($form_result->tipe_form == 'input') {
      $input_form['type'] = 'number';
    } else {
      $input_form['selectData'] = array();
      
      $pilihan_sql = "SELECT * FROM kriteria_penilaian_pilihans WHERE kriteria_penilaian_id=$form_result->id";
      $pilihan_result = $conn->query($pilihan_sql);
      
      if ($result->num_rows > 0) {
        $pilihan = array();
        while ($pilihan_form = $pilihan_result->fetch_object()) {
          $pilihan[] = ['text' => $pilihan_form->nama, 'nilai' => $pilihan_form->nilai];
        }

        $input_form['selectData'] = $pilihan;
      }
    }

    $list_form[] = $input_form;
  }

  return $list_form;
}

function tambahNilai($conn)
{
  $siswa_id = $_POST['siswa_id'] ? $_POST['siswa_id'] : false;
  $kriteria_id = $_POST['kriteria_id'] ? $_POST['kriteria_id'] : false;

  $sql = "SELECT * FROM kriteria_penilaians WHERE kriteria_id=$kriteria_id";
  $result = $conn->query($sql);

  if($result->num_rows <= 0) {
    header("location: ". $url ."/dashboard/nilai-siswa/?siswa_id=$siswa_id&kriteria_id=$kriteria_id");
  }

  while ($penilaian = $result->fetch_object()) {
    $nilai = $_POST[$penilaian->nama];
    $created_at = date('Y-m-d h:i:s', time());
    $updated_at = date('Y-m-d h:i:s', time());

    $nilai_sql = "INSERT siswa_nilais (siswa_id, kriteria_id, kriteria_penilaian_id, nilai, created_at, updated_at) VALUES ('$siswa_id', '$kriteria_id', '$penilaian->id', '$nilai', '$created_at', '$updated_at')";
    if ($conn->query($nilai_sql) === TRUE) {

    }
  }

  header("location: ". $url ."/dashboard/nilai-siswa/?siswa_id=$siswa_id&kriteria_id=$kriteria_id");
}

function editNilai($conn)
{
  $siswa_id = $_POST['siswa_id'] ? $_POST['siswa_id'] : false;
  $kriteria_id = $_POST['kriteria_id'] ? $_POST['kriteria_id'] : false;

  $sql = "SELECT * FROM kriteria_penilaians WHERE kriteria_id=$kriteria_id";
  $result = $conn->query($sql);

  if($result->num_rows <= 0) {
    header("location: ". $url ."/dashboard/nilai-siswa/?siswa_id=$siswa_id&kriteria_id=$kriteria_id");
  }

  while ($penilaian = $result->fetch_object()) {
    $nilai = $_POST[$penilaian->nama];
    $updated_at = date('Y-m-d h:i:s', time());

    $nilai_sql = "UPDATE siswa_nilais SET nilai='$nilai', updated_at='$updated_at' WHERE siswa_id=$siswa_id AND kriteria_penilaian_id=$penilaian->id";
    if ($conn->query($nilai_sql) === TRUE) {
      
    }
  }

  header("location: ". $url ."/dashboard/nilai-siswa/?siswa_id=$siswa_id&kriteria_id=$kriteria_id");
};

function hapusNilai($conn)
{
  $siswa_id = $_GET['siswa_id'] ? $_GET['siswa_id'] : false;
  $kriteria_id = $_GET['kriteria_id'] ? $_GET['kriteria_id'] : false;

  $sql = "DELETE FROM siswa_nilais WHERE siswa_id='$siswa_id' AND kriteria_id='$kriteria_id'";

  if ($conn->query($sql) === TRUE) {
    header("location: ". $url ."/dashboard/nilai-siswa/?siswa_id=$siswa_id&kriteria_id=$kriteria_id");
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

if (isset($_GET['aksi'])) {
  include('../app/settings.php');
  include('../app/database.php');
  include('../app/middleware.php');
  $aksi = $_GET['aksi'];

  if ($aksi == 'tambah') {
    tambahNilai($conn);
  } else if ($aksi == 'ubah') { 
    editNilai($conn);
  } else if ($aksi == 'hapus') {
    hapusNilai($conn);
  }
}
