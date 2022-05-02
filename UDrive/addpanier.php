<?php
include("includes/pageentete.php");

session_start();
if(!(isset($_SESSION['panier'])))
{
	$panier = array();
}
else
{
	$panier = $_SESSION['panier'];
}
$index = count($panier);
$panier [$index]['pronum'] = $_POST['refProduit'];
$panier [$index]['proprix'] = $_POST['proprix'];
$panier [$index]['prolib'] = $_POST['prolib'];
$panier [$index]['proimg'] = $_POST['proimg'];
$panier [$index]['quantite'] = $_POST['quantite'];
$_SESSION['panier'] = $panier;
header("location:index.php?panier=1");
?>
