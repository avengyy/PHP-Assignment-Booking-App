<?php
  require_once('constants.php');

  // Start SQL connection
  $conn = mysqli_connect(HOST, USER, PASSWORD, DBNAME);

  // Check SQL connection
  if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
  }

?>