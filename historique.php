<html>
<head>
	<title>Description du produit </title>
	<link rel="stylesheet" type="text/css" href="style.css" />
	<?php include("includes/pageentete.php"); 
// Utilisation de connexion.inc.php pour ce connecter � la base de donn�e
	require_once("connexion.inc.php");
	?>
	<meta charset="UTF-8">
</head>
<body>
	<center>
		<div class="p-3 mb-2 bg-primary text-white"><h3>Historique<h3></div>
			<br
			<?php
            $host ="eu-cdbr-west-03.cleardb.net";
            $dbname = "heroku_ed5518a9c03f82b";
            $user = "b6b5a59b76adf9";
            $pass ="1f4603cc";
            $cnn2 = new PDO("mysql:host=$host; dbname=$dbname;", $user, $pass);
			?>
			<?php
			$clinum = $_SESSION['clinum'];
			$reqresult = $cnn->prepare("select * from commande where clinum=$clinum");
			$reqresult->execute();
			$uneligne = $reqresult->fetch();
			?>
			<div class=container>
				<div class="row">
					<?php
					while ($uneligne!=null)
					{
						?>
						<div class="col-md-4 produit-case">
							<?php
							echo("<b>Commande numéro : " . $uneligne["comnum"] . "</b><br>");
							echo("Date de la commande : <i>" . $uneligne["comdateh"] . "<br>" . "</i>Date du retrait : <i> " . $uneligne["comdatehretrait"] . "</i> <br>");
							$reqresult2 = $cnn2->prepare("select * from commander join produit on commander.pronum=produit.pronum where comnum=". $uneligne["comnum"]);
							$reqresult2->execute();
							$deuxligne = $reqresult2->fetch();
                            echo ("Total de la commande : " . $deuxligne["prixtotal"]. " € <br> Mode de livrason : " . $deuxligne["modeliv"] . "<br>");
							while ($deuxligne!=null)
							{
								echo("Quantité : " . $deuxligne["quantite"] ."<br> Produit : " . utf8_encode($deuxligne["prolib"])  . "<br><br>");
								$deuxligne = $reqresult2->fetch();
							}

							$reqresult2->closeCursor();
							$uneligne = $reqresult->fetch();
							?>
						</div>
						<?php
					} 
					?>
				</body>
				</html>