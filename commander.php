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
	<form method="get" action="commander.php">
		<center>
			<div class="p-3 mb-2 bg-primary text-white"><h3>Passer la commande<h3></div>
				<?php

	// Affichage du récapitulatif de la commande
				$prixtotal = 0;
				$nombreproduit = 0;
				echo("Récapitulatif de la commande : <br>");
				for($i=0 ; $i<count($_SESSION['tblpronum']) ; $i++)
				{
					$pronum = $_SESSION['tblpronum'][$i];
					$quantite = $_SESSION['tblquantite'][$i];
		// Requête
					$reqresult = $cnn->prepare("SELECT * FROM produit WHERE pronum = $pronum");
		// Execution de la requête
					$reqresult->execute();
					$uneligne = $reqresult->fetch();
		// Fin requête
					$prolib = $uneligne["prolib"];
					$numprod = $i+1;
					$prix = $uneligne["proprix"] * $quantite;
					$prixtotal = $prixtotal + $prix;
					$nombreproduit = $nombreproduit + 1;
					echo ("<i> Produit n° $numprod </i> : "  .  utf8_encode($prolib) . " - <b>Quantité :</b> $quantite - <b>Prix :</b> $prix € <br/>");
					$reqresult -> closeCursor();
				}
				echo("<br><b>Nombre de produit : $nombreproduit</b>  -  <b>Prix total : $prixtotal €</b>");

	// Récupère la date et l'heure actuel
				$dateactuelbd = date("Y-m-d H:i:s");
				$dateactuelfr = date("d-m-Y H:i:s");
				echo ("<br> <br>");
				echo("<br> Choississez la date et l'heure à laquelle vous souhaitez récuperer votre commande : <br> Date actuel : $dateactuelfr <br>");
				?>
				<br>
				<div class="container">

						<div class="form-group col-md-4">
							<label for="inputCity">Date de retrait au format Jour - Mois - Annee</label>
							<input type="text" class="form-control" id="inputCity"  placeholder="exemple : 25-09-2022" name="dateretrait">
						</div>
					
					<br>
					<button type="submit" class="btn btn-primary" name="btncommande">Valider la commande</button>
				</div>
			</form>
			<?php


			if(isset($_GET["btncommande"])==true && $_GET["dateretrait"]!="")
			{
                if($_GET["dateretrait"]<= $dateactuelfr){
                echo ('<script>alert("La date de retrait rentrer est invalide ou inférieur a la date du jour! \n\n merci de rentrer une date valide")</script>");
                }
                else{
				$dateretrait = $_GET["dateretrait"];
				$clinum = $_SESSION['clinum'];

				$reqresult = $cnn -> prepare("insert into commande (comdateh,comdatehretrait,comprepareok,comlivreok,clinum) VALUES (NOW(),'$dateretrait',0,0,$clinum)");
				


				$reqresult -> execute();
				$reqresult -> closeCursor();

				$reqresult = $cnn -> prepare("select MAX(comnum) AS maxi from commande");
				$reqresult -> execute();
				$uneligne = $reqresult->fetch();
				$numcommande = $uneligne['maxi'];
				$reqresult -> closeCursor();

				for($i=0 ; $i<count($_SESSION['tblpronum']) ; $i++)
				{
					$pronum = $_SESSION['tblpronum'][$i];
					$quantite = $_SESSION['tblquantite'][$i];
		// Requête
					$reqresult = $cnn->prepare("INSERT INTO commander (quantite,comnum,pronum) VALUES ($quantite,$numcommande,$pronum)");
						// Execution de la requête
					$reqresult->execute();
				}

				unset($_SESSION["tblpronum"]);
				unset($_SESSION["tblquantite"]);
				?>
				<div class="p-3 mb-2 bg-light text-dark">Votre commande a été pris en compte ! Redirection automatique à la page d'acceuil dans 3 secondes</div> 
				<?php
				header("Refresh: 3; URL=index.php");
                }
			}
			?>
		</center>
	</body>
	</html>


