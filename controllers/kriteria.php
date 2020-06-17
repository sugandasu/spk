<?php
function getKriteria($conn)
{
  $sql = "SELECT * FROM kriterias";
  $result = $conn->query($sql);

  return $result;
}

function getKriteriaOne($conn, $id)
{
  $sql = "SELECT * FROM kriterias WHERE id=$id";
  $result = $conn->query($sql);

  return $result->fetch_row();
}

function tambahKriteria($conn)
{
  $nama = $_POST['nama'] ? $_POST['nama'] : false;
  $created_at = date('Y-m-d h:i:s', time());
  $updated_at = date('Y-m-d h:i:s', time());

  $sql = "INSERT INTO kriterias (nama, created_at, updated_at) VALUES ('$nama', '$created_at', '$updated_at')";
  if ($conn->query($sql) === TRUE) {
    header("location: ". $url ."/dashboard/kriteria/");
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

function editKriteria($conn)
{
  $id = $_GET['id'];
  $nama = $_POST['nama'] ? $_POST['nama'] : false;
  $updated_at = date('Y-m-d h:i:s', time());

  $sql = "UPDATE kriterias SET nama='$nama', updated_at='$updated_at' WHERE id='$id'";
  if ($conn->query($sql) === TRUE) {
    header("location: ". $url ."/dashboard/kriteria/");
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
};

function hapusKriteria($conn)
{
  $id = $_GET['id'];
  $sql = "DELETE FROM kriterias WHERE id='$id'";
  if ($conn->query($sql) === TRUE) {
    header("location: ". $url ."/dashboard/kriteria/");
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
    tambahKriteria($conn);
  } else if ($aksi == 'ubah') { 
    editKriteria($conn);
  } else if ($aksi == 'hapus') {
    hapusKriteria($conn);
  }
}
