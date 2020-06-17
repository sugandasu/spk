<?php

$user = array();

if (isset($_COOKIE['token'])) {
  $token = $_COOKIE['token'];
  $userSQL = "SELECT * FROM users WHERE token='$token'";
  $userResult = $conn->query($userSQL);
  if($userResult->num_rows > 0) {
    $user = $userResult->fetch_row();
  } else {
    header("location: $url/errors/403.php");
  }
} else {
  header("location: $url/errors/403.php");
}