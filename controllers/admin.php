<?php

function login($conn)
{
  $username = $_POST['username'];
  $password = $_POST['password'];

  $username = addslashes($username);
  $password = addslashes($password);

  $userSQL = "SELECT * FROM users WHERE username='$username' AND password=MD5('$password')";
  $userResult = $conn->query($userSQL);
  if($userResult->num_rows > 0) {
    $token = substr(str_shuffle(MD5(uniqid()) . MD5(microtime()) . MD5(microtime())), 0, 60);
    $userSQL = "UPDATE users SET token='$token' WHERE username='$username' AND password=MD5('$password')";
    if ($conn->query($userSQL) === TRUE) {
      setcookie("token", $token, time() + (24 * 60 * 60), "/");
      header("location: ".$url."/dashboard");
    }
  } else {
    header("location: ".$url."/errors/404.php");
  }
}

function logout()
{
  setcookie("token", null, time() - (24 * 60 * 60), "/");
  header("location: ".$url."/login.php");
}

function editAdmin($conn)
{
  include('../app/middleware.php');

  $id = $_GET['user_id'];
  $name = $_POST['name'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $updated_at = date('Y-m-d h:i:s', time());
  
  $userSQL = "UPDATE users SET name='$name', username='$username', password=MD5('$password'), updated_at='$updated_at' WHERE id=$id";
  if($conn->query($userSQL) === TRUE) {
    header("location: ".$url."/dashboard/admin");
  }
}

if (isset($_GET['aksi'])) {
  include('../app/settings.php');
  include('../app/database.php');
  $aksi = $_GET['aksi'];

  if ($aksi == 'ubah') { 
    editAdmin($conn);
  } else if ($aksi == 'login') {
    login($conn);
  } else if ($aksi == 'logout') {
    logout();
  }
}