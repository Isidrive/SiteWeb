<?php
//Suppression de SESSION et redirection vers index.php
session_start();
unset($_SESSION["clinum"]);
unset($_SESSION["clinom"]);
header('Location: ../index.php');
?>
