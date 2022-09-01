<?php
$cnn = new PDO("odbc:Driver={SQL Server};Server=37.187.143.111;Database=Isidrive;Uid=ISIDRIVE\alexandre;Pwd=A*14nJqXS+");

// Check connection
if ($cnn->connect_error) {
  die("Connection failed: " . $cnn->connect_error);
}
echo "Connected successfully";
?>

