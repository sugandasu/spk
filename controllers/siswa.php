<?php

function getSiswa($conn)
{
  $sql = "SELECT * FROM siswas";
  $result = $conn->query($sql);

  return $result;
}

function getSiswaOne($conn, $id)
{
  $sql = "SELECT * FROM siswas WHERE id=$id";
  $result = $conn->query($sql);

  return $result->fetch_row();
}

function tambahSiswa($conn)
{
  $nis = $_POST['nis'] ? $_POST['nis'] : false;
  $nama = $_POST['nama'] ? $_POST['nama'] : false;
  $tempat_lahir = $_POST['tempat_lahir'] ? $_POST['tempat_lahir'] : false;
  $tanggal_lahir = $_POST['tanggal_lahir'] ? $_POST['tanggal_lahir'] : false;
  $gender = $_POST['gender'] ? $_POST['gender'] : false;
  $alamat = $_POST['alamat'] ? $_POST['alamat'] : false;
  $created_at = date('Y-m-d h:i:s', time());
  $updated_at = date('Y-m-d h:i:s', time());

  $sql = "INSERT INTO siswas (nis, nama, tempat_lahir, tanggal_lahir, 
    gender, alamat, created_at, updated_at) VALUES ('$nis', '$nama', '$tempat_lahir', '$tanggal_lahir', '$gender', '$alamat', '$created_at', '$updated_at')";
  if ($conn->query($sql) === TRUE) {
    header("location: ". $url ."/dashboard/siswa/");
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

function editSiswa($conn)
{
  $id = $_GET['id'];
  $nis = $_POST['nis'] ? $_POST['nis'] : false;
  $nama = $_POST['nama'] ? $_POST['nama'] : false;
  $tempat_lahir = $_POST['tempat_lahir'] ? $_POST['tempat_lahir'] : false;
  $tanggal_lahir = $_POST['tanggal_lahir'] ? $_POST['tanggal_lahir'] : false;
  $gender = $_POST['gender'] ? $_POST['gender'] : false;
  $alamat = $_POST['alamat'] ? $_POST['alamat'] : false;
  $updated_at = date('Y-m-d h:i:s', time());

  $sql = "UPDATE siswas SET nis='$nis', nama='$nama', tempat_lahir='$tempat_lahir', tanggal_lahir='$tanggal_lahir', 
    gender='$gender', alamat='$alamat', updated_at='$updated_at' WHERE id='$id'";
  if ($conn->query($sql) === TRUE) {
    header("location: ". $url ."/spk/dashboard/siswa/");
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
};

function hapusSiswa($conn)
{
  $id = $_GET['id'];
  $sql = "DELETE FROM siswas WHERE id='$id'";
  if ($conn->query($sql) === TRUE) {
    header("location: ". $url ."/spk/dashboard/siswa/");
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
    tambahSiswa($conn);
  } else if ($aksi == 'ubah') { 
    editSiswa($conn);
  } else if ($aksi == 'hapus') {
    hapusSiswa($conn);
  }
}
