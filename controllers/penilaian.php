<?php

function getPenilaian($conn, $kriteria_id)
{
  $sql = "SELECT * FROM kriteria_penilaians WHERE kriteria_id=$kriteria_id";
  $result = $conn->query($sql);

  return $result;
}

function tambahPenilaian($conn)
{
  $kriteria_id = $_GET['kriteria_id'] ? $_GET['kriteria_id'] : false;
  $text = $_POST['text'] ? $_POST['text'] : false;
  $nama = str_replace(" ", "_", strtolower($text));
  $bobot = $_POST['bobot'] ? $_POST['bobot'] : false;
  $tipe_nilai = $_POST['tipe_nilai'] ? $_POST['tipe_nilai'] : false;
  $tipe_form = $_POST['tipe_form'] ? $_POST['tipe_form'] : false;
  $created_at = date('Y-m-d h:i:s', time());
  $updated_at = date('Y-m-d h:i:s', time());

  $sql = "INSERT INTO kriteria_penilaians (kriteria_id, text, nama, bobot, tipe_nilai, tipe_form, created_at, updated_at) 
    VALUES ('$kriteria_id', '$text', '$nama', '$bobot', '$tipe_nilai', '$tipe_form', '$created_at', '$updated_at')";
  if ($conn->query($sql) === TRUE) {
    header("location: ". $url ."/dashboard/penilaian?kriteria_id=$kriteria_id");
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

function editPenilaian($conn)
{
  $kriteria_id = $_GET['kriteria_id'] ? $_GET['kriteria_id'] : false;
  $id = $_GET['id'];
  $text = $_POST['text'] ? $_POST['text'] : false;
  $nama = str_replace(" ", "_", strtolower($text));
  $bobot = $_POST['bobot'] ? $_POST['bobot'] : false;
  $tipe_nilai = $_POST['tipe_nilai'] ? $_POST['tipe_nilai'] : false;
  $tipe_form = $_POST['tipe_form'] ? $_POST['tipe_form'] : false;
  $updated_at = date('Y-m-d h:i:s', time());

  $sql = "UPDATE kriteria_penilaians SET text='$text', nama='$nama', bobot='$bobot', tipe_nilai='$tipe_nilai', tipe_form='$tipe_form', updated_at='$updated_at' WHERE id='$id'";
  if ($conn->query($sql) === TRUE) {
    header("location: ". $url ."/dashboard/penilaian?kriteria_id=$kriteria_id");
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
};

function hapusPenilaian($conn)
{
  $kriteria_id = $_GET['kriteria_id'] ? $_GET['kriteria_id'] : false;
  $id = $_GET['id'];
  $sql = "DELETE FROM kriteria_penilaians WHERE id='$id'";
  if ($conn->query($sql) === TRUE) {
    header("location: ". $url ."/dashboard/penilaian?kriteria_id=$kriteria_id");
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
    tambahPenilaian($conn);
  } else if ($aksi == 'ubah') { 
    editPenilaian($conn);
  } else if ($aksi == 'hapus') {
    hapusPenilaian($conn);
  }
}
