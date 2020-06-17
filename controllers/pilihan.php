<?php

function getPilihan($conn, $kriteria_penilaian_id)
{
  $sql = "SELECT * FROM kriteria_penilaian_pilihans WHERE kriteria_penilaian_id=$kriteria_penilaian_id";
  $result = $conn->query($sql);

  return $result;
}

function tambahPilihan($conn)
{
  $kriteria_penilaian_id = $_GET['kriteria_penilaian_id'] ? $_GET['kriteria_penilaian_id'] : false;
  $nama = $_POST['nama'] ? $_POST['nama'] : false;
  $nilai = $_POST['nilai'] ? $_POST['nilai'] : false;
  $created_at = date('m/d/Y h:i:s', time());
  $updated_at = date('m/d/Y h:i:s', time());

  $sql = "INSERT INTO kriteria_penilaian_pilihans (kriteria_penilaian_id, nama, nilai, created_at, updated_at) 
    VALUES ('$kriteria_penilaian_id', '$nama', '$nilai', '$created_at', '$updated_at')";
  if ($conn->query($sql) === TRUE) {
    header("location: http://localhost/spk/dashboard/pilihan?kriteria_penilaian_id=$kriteria_penilaian_id");
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

function editPilihan($conn)
{
  $kriteria_penilaian_id = $_GET['kriteria_penilaian_id'] ? $_GET['kriteria_penilaian_id'] : false;
  $id = $_GET['id'];
  $nama = $_POST['nama'] ? $_POST['nama'] : false;
  $nilai = $_POST['nilai'] ? $_POST['nilai'] : false;
  $updated_at = date('m/d/Y h:i:s', time());

  $sql = "UPDATE kriteria_penilaian_pilihans SET nama='$nama', nilai='$nilai', updated_at='$updated_at' WHERE id='$id'";
  if ($conn->query($sql) === TRUE) {
    header("location: http://localhost/spk/dashboard/pilihan?kriteria_penilaian_id=$kriteria_penilaian_id");
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
};

function hapusPilihan($conn)
{
  $kriteria_penilaian_id = $_GET['kriteria_penilaian_id'] ? $_GET['kriteria_penilaian_id'] : false;
  $id = $_GET['id'];
  $sql = "DELETE FROM kriteria_penilaian_pilihans WHERE id='$id'";
  if ($conn->query($sql) === TRUE) {
    header("location: http://localhost/spk/dashboard/pilihan?kriteria_penilaian_id=$kriteria_penilaian_id");
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

if (isset($_GET['aksi'])) {
  include('../app/database.php');
  include('../app/middleware.php');
  $aksi = $_GET['aksi'];

  if ($aksi == 'tambah') {
    tambahPilihan($conn);
  } else if ($aksi == 'ubah') { 
    editPilihan($conn);
  } else if ($aksi == 'hapus') {
    hapusPilihan($conn);
  }
}
