<?php

$conn = new mysqli('localhost', 'root', '', 'spk');

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}