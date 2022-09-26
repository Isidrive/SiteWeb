<html>
	<head>
	<title>Description du produit </title>
	<link rel="stylesheet" type="text/css" href="style.css" />
	<?php include("includes/pageentete.php"); 
// Utilisation de connexion.inc.php pour ce connecter à la base de donnée
	require_once("connexion.inc.php");
	?>
</head>
<body>
	<?php
	$reqresult = $cnn->prepare("select * from produit where pronum = :pronum");
	$reqresult->bindParam(':pronum',$_GET["pronum"],PDO::PARAM_INT);
// Execution de la requête
	$reqresult->execute();
	$uneligne = $reqresult->fetch();
	?>
	<center>
		<div class="p-3 mb-2 bg-primary text-white"> <?php echo(utf8_encode("$uneligne[prolib]") . " - " . "$uneligne[proprix] €");?> </div> 
		<?php
		echo(utf8_encode("<img id='$uneligne[proimg]' src='photos/$uneligne[proimg]' alt='$uneligne[proimg]'/><br><br>"));
		echo("<form>");
		echo("<input type='hidden' value='$_GET[pronum]' name='pronum'>");
		echo("<select name='quantite'>");
		for ($i=1 ; $i<=100 ; $i++)
		{
			echo("<option value=$i> $i </option>");
		}
		echo ("</select>");
		?>
		<button type="submit" class="btn btn-primary" name=btnajout>Ajouter au panier</button>
		<?php
		echo("</form>");

		if(isset($_GET["btnajout"])==true)
		{
			$_SESSION["tblpronum"][] = $_GET["pronum"];
			$_SESSION["tblquantite"][] = $_GET["quantite"];
			?>
			<div class="p-3 mb-2 bg-light text-dark">Le produit a bien été ajouté au panier. Redirection automatique dans 3 secondes.</div> 
			<meta http-equiv="refresh" content="5;URL='produits.php'">
				<?php
				
				 //header("Refresh: 3; URL=produits.php");
		}

		$reqresult->closeCursor();

		?>
	</center>
</body>
</html>
