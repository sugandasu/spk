<?php

function getDataset($conn)
{
  $sql = "SELECT * FROM datasets";
  $result = $conn->query($sql);

  return $result;
}

function getDatasetOne($conn, $id)
{
  $sql = "SELECT * FROM datasets WHERE id=$id";
  $result = $conn->query($sql);

  return $result->fetch_row();
}

function tambahDataset($conn)
{
  $nama = $_POST['nama'] ? $_POST['nama'] : false;
  $created_at = date('Y-m-d h:i:s', time());
  $updated_at = date('Y-m-d h:i:s', time());

  $sql = "INSERT INTO datasets (nama, created_at, updated_at) VALUES ('$nama', '$created_at', '$updated_at')";
  if ($conn->query($sql) === TRUE) {
    header("location: ". $url ."/dashboard/dataset/");
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

function editDataset($conn)
{
  $id = $_GET['id'];
  $nama = $_POST['nama'] ? $_POST['nama'] : false;
  $updated_at = date('Y-m-d h:i:s', time());

  $sql = "UPDATE datasets SET nama='$nama', updated_at='$updated_at' WHERE id='$id'";
  if ($conn->query($sql) === TRUE) {
    header("location: ". $url ."/dashboard/dataset/");
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
};

function hapusDataset($conn)
{
  $id = $_GET['id'];
  $sql = "DELETE FROM datasets WHERE id='$id'";
  if ($conn->query($sql) === TRUE) {
    header("location: ". $url ."/dashboard/dataset/");
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
    tambahDataset($conn);
  } else if ($aksi == 'ubah') { 
    editDataset($conn);
  } else if ($aksi == 'hapus') {
    hapusDataset($conn);
  }
}
