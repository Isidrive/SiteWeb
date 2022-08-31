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
	<center>
		<div class="p-3 mb-2 bg-primary text-white"><h3>Panier<h3></div>
			<?php
	//Vider le panier
			if(isset($_GET["btnsupprimer"])==true)
			{
				unset($_SESSION["tblpronum"]);
				unset($_SESSION["tblquantite"]);
			}
			$prixtotal = 0;
//Si le panier est vide
			if(empty($_SESSION['tblquantite']))
			{
				echo ("Votre panier est vide. Vous pouvez y ajouter des <a href='produits.php' class='menu'>produits</a> !");
			}
//S'il n'est pas vide
			else
			{
				?>
				
				<div class=container>
					<div class="row">
						<?php
						for($i=0 ; $i<count($_SESSION['tblpronum']) ; $i++)
						{
							?>
							<div class="col-md-3 produit-case">
								<?php
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
								echo("<i> Produit n° $numprod </i> <br> <b>" .  utf8_encode($prolib) . "</b> <br> <b>Ref :</b> $pronum <br> <b>Quantité :</b> $quantite <br> <b>Prix :</b> $prix € <br> <img id='$uneligne[proimg]' src='photos/$uneligne[proimg]' alt='$uneligne[proimg]'/></div>");
							}
							?>	
						</div>
					</div>
					<?php
					echo("<br> <b>Prix total : $prixtotal €</b>");
					echo("<form>");
					?>
					<br>
					<?php
					if(isset($_SESSION["clinum"]))
					{
						?>
						<a href="commander.php" class="btn btn-primary" role="button" aria-pressed="true">Passer la commande</a>
						<?php	
					}
					else
					{
						echo("Connectez vous à votre compte client pour pouvoir passer la commande ! <br>");
						?>
						<a href="connexioncompte.php" class="btn btn-primary" role="button" aria-pressed="true">Se connecter</a>
						<?php
					}
					?>
					<button type="submit" class="btn btn-primary" name="btnsupprimer">Vider le panier</button>
					<?php
					echo("</form>");
				}
				?>
			</center>
		</body>
		</html>