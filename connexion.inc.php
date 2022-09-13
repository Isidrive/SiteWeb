<?php
$cnn = new PDO("mysql://b6b5a59b76adf9:1f4603cc@eu-cdbr-west-03.cleardb.net");

// Check connection
if ($cnn->connect_error) {
  die("Connection failed: " . $cnn->connect_error);
}
echo "Connected successfully";
?>

