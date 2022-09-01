<?php
$cnn = new PDO("odbc:Driver={SQL Server};Server=SRV-APPLICATION\SQLSERVER2019;Database=Isidrive;Uid=ISIDRIVE\alexandre;Pwd=A*14nJqXS+");

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>

