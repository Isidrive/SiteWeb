<html>
<head>
	<title>Produits</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
	<?php include("includes/pageentete.php");
// Utilisation de connexion.inc.php pour ce connecter à la base de donnée
	require_once("connexion.inc.php");
	?>
</head>
<body>

	<center>
		<div class="p-3 mb-2 bg-primary text-white"><h3>Produits<h3></div>

			<form method="get" action ="produits.php">
				Catégorie : <select class="form-select mb-2 mt-2 mx-auto" aria-label="Default"  onchange='form.submit()' name="catnum">
                    <option></option>
					<?php
// Requête permettant d'extraire les catégories
					$reqresult = $cnn->prepare("select * from categorie");
// Execution de la requête
					$reqresult->execute();
					$uneligne = $reqresult->fetch();
					while ($uneligne!=null)
					{
						if(isset($_GET["catnum"]) && $uneligne["catnum"] == $_GET["catnum"])
						{
							echo("<option value='$uneligne[catnum]'selected='selected'> " . utf8_encode($uneligne["catlib"]) ."</option selected='selected'>");
						}
						else
						{
							echo("<option value='$uneligne[catnum]'>" . utf8_encode($uneligne["catlib"]) ."</option>");
						}
						$uneligne = $reqresult->fetch();
					}
					$reqresult->closeCursor();
					?>
				</select>
				<!--Fin de la requête permettant d'extraire les catégories-->
				<?php
				if (isset($_GET["catnum"]) && $_GET["catnum"]!="" )
				{
					?>
					<br>Sous-catégorie : <select class="form-select mb-2 mt-2 mx-auto" aria-label="Default"  onchange='form.submit()' name="sounum">
                    <option></option>
						<?php
// Utilisation de connexion.inc.php pour ce connecter à la base de donnée
// Requête permettant d'extraire les catégories
						$reqresult = $cnn->prepare("select * from soucat where catnum= :catnum");
						$reqresult->bindParam(':catnum',$_GET["catnum"],PDO::PARAM_INT);
// Execution de la requête
						$reqresult->execute();
						$uneligne = $reqresult->fetch();
						while ($uneligne!=null)
						{
							if(isset($_GET["sounum"]) && $uneligne["sounum"] == $_GET["sounum"] )
							{
								echo("<option value='$uneligne[sounum]'selected='selected'> " . utf8_encode($uneligne["soulib"]) ."</option selected='selected'>");
							}
							else
							{
								echo("<option value='$uneligne[sounum]'>" . utf8_encode($uneligne["soulib"]) ."</option>");
							}
							$uneligne = $reqresult->fetch();
						}
						$reqresult->closeCursor();
						?>
					</select>
					<?php
} // Fermeture du if sur le cbo des soucat

if(isset($_GET['txtrech'])!="")
{
	$textrech = $_GET['txtrech']
	?>
	<br>Recherche par texte <input type ="text" name ="txtrech" id="txtrech" value=<?php echo($textrech) ?> >
<?php
}
else
{
	?>
<br>Recherche par texte <input type ="text" name ="txtrech" id="txtrech" value="">
<?php
}
?>
<button type="submit" class="btn btn-primary" name=btnrechercher>Rechercher</button>
</form>
<?php

// Afficher les produits selon le numéro de page
if (isset($_GET['id']) == true) {
//affichage pour le txt seulement
	if( $_GET['sounum'] == '')
	{
		$sounum = $_GET['sounum'];
		$txtrech = $_GET['txtrech'];
		$reqresult = $cnn->prepare("select COUNT(*) AS nbtoto from produit where prolib LIKE '%". $txtrech ."%' ");
		$reqresult->execute();
		$uneligne = $reqresult->fetch();
		$n=1;
		?>

        <nav aria-label="Page">
  <ul class="pagination">

      <?php
      for ($i=0; $i <$uneligne['nbtoto'] ; $i=$i+10)
      {
          echo '<li class="page-item"><a class="page-link" href="produits.php?id=' .$i. '&txtrech=' .$txtrech. '&sounum=' .$sounum. '">' .$n. '</a></li>';
          $n++;
          echo(". ");
      }
      $reqresult->closeCursor();
      ?>
  </ul>
</nav>
	<?php



//Affichage des produits selon le numéro de la page
		$id = $_GET['id'];


		$reqresult = $cnn->prepare("select pronum,prolib,proprix,proimg,sounum from produit where prolib LIKE '%". $txtrech ."%' and pronum NOT IN (SELECT pronum from produit where prolib LIKE '%". $txtrech ."%' limit $id ORDER BY pronum) limit 10 ORDER BY pronum");

		$reqresult->execute();
		$uneligne = $reqresult->fetch();
		echo("<table class='table table-striped w-auto' >");


		while ($uneligne!=null)
		{
			echo ("<tr><td><b>" . utf8_encode($uneligne["prolib"]) . "</b></td> <td>" . $uneligne["proprix"] . "€" . " </td> <td> " ."<button type='button' class='btn btn-primary'><a href ='leproduit.php?pronum=$uneligne[pronum]' style='color:white; text-decoration: none;'> Ajouter au panier </a></button>" ."</td> </tr> ");


			echo("<tr><td colspan=5 class='mx-auto text-center'><img id='$uneligne[proimg]' src='photos/$uneligne[proimg]' alt='$uneligne[proimg]' width=200 /></td></tr>");
			$uneligne = $reqresult->fetch();
		}
		echo("</table>");
		$reqresult->closeCursor();
	}
	else
	{

// Affichage du nombre de pages
		$txtrech = $_GET['txtrech'];
		$sounum = $_GET["sounum"];
		$reqresult = $cnn->prepare("select COUNT(*) AS nbtoto from produit where sounum = :sounum and prolib LIKE '%". $txtrech ."%' ");
		$reqresult->bindParam(':sounum',$_GET["sounum"],PDO::PARAM_INT);
		$reqresult->execute();
		$uneligne = $reqresult->fetch();
		$n=1;
		echo "Page : ";

		$catnum = $_GET['catnum'];
		for ($i=0; $i <$uneligne['nbtoto'] ; $i=$i+10)
		{

			echo '<a href="produits.php?id=' .$i. '&sounum=' .$sounum. '&txtrech=' .$txtrech. '&catnum=' .$catnum. '">' .$n. '</a>';
			$n++;
			echo(". ");
		}
		$reqresult->closeCursor();



//Affichage des produits selon le numéro de la page
		$id = $_GET['id'];
		$sousnum =$_GET['sounum'];


		$reqresult = $cnn->prepare("select pronum,prolib,proprix,proimg,sounum from produit where sounum = $sousnum and prolib LIKE '%". $txtrech ."%' and pronum NOT IN (SELECT pronum from produit where sounum = $sousnum and prolib LIKE '%". $txtrech ."%' limit $id ORDER BY pronum) LIMIT 10 ORDER BY pronum");

		$reqresult->execute();
		$uneligne = $reqresult->fetch();
		echo("<table class='table table-striped w-auto' >");


		while ($uneligne!=null)
		{
			echo ("<tr><td><b>" . utf8_encode($uneligne["prolib"]) . "</b></td> <td>" . $uneligne["proprix"] . "€" . " </td> <td> " ."<button type='button' class='btn btn-primary'><a href ='leproduit.php?pronum=$uneligne[pronum]' style='color:white; text-decoration: none;'> Ajouter au panier </a></button>" ."</td> </tr> ");


			echo("<tr><td colspan=5 class='mx-auto text-center' ><img id='$uneligne[proimg]' src='photos/$uneligne[proimg]' alt='$uneligne[proimg]' width=200 /></td></tr>");
			$uneligne = $reqresult->fetch();
		}
		echo("</table>");
		$reqresult->closeCursor();

	}}
	else
	{
		if (isset($_GET["catnum"]) == true && isset($_GET["sounum"]) == true && $_GET["sounum"]!="" )
		{
			$sounum = $_GET["sounum"];
			$reqresult = $cnn->prepare("select COUNT(*) AS nbtoto from produit where sounum = :sounum and prolib LIKE '%". $_GET["txtrech"] ."%'");
			$reqresult->bindParam(':sounum',$_GET["sounum"],PDO::PARAM_INT);
			$reqresult->execute();
			$uneligne = $reqresult->fetch();
			$n=1;
			$catnum = $_GET['catnum'];
			echo "Page : ";
			$txtrech = $_GET["txtrech"];
			for ($i=0; $i <$uneligne['nbtoto'] ; $i=$i+10)
			{

				echo '<a href="produits.php?id=' .$i. '&sounum=' .$sounum. '&txtrech=' .$txtrech. '&catnum=' .$catnum. '">' .$n. '</a>';
				$n++;
				echo(". ");
			}

// Utilisation de connexion.inc.php pour ce connecter à la base de donnée
//require_once("connexion.inc.php");
		//$id = 1;

			$reqresult = $cnn->prepare("select pronum,prolib,proprix,proimg,sounum from produit where sounum = :sounum and prolib LIKE '%". $_GET["txtrech"] ."%' limit 10" );
			$reqresult->bindParam(':sounum',$_GET["sounum"],PDO::PARAM_INT);
			$reqresult->execute();
			$uneligne = $reqresult->fetch();
			echo("<table class='table table-striped w-auto'>");


			while ($uneligne!=null)
			{
				echo ("<tr><td><b>" . utf8_encode($uneligne["prolib"]) . "</b></b></td> <td>" . $uneligne["proprix"] . "€" . " </td> <td> " ."<button type='button' class='btn btn-primary'><a href ='leproduit.php?pronum=$uneligne[pronum]' style='color:white; text-decoration: none;'> Ajouter au panier </a></button>" ."</td> </tr> ");


				echo("<tr><td colspan=5 class='mx-auto text-center'><img id='$uneligne[proimg]' src='photos/$uneligne[proimg]' alt='$uneligne[proimg]' width=200 /></td></tr>");
				$uneligne = $reqresult->fetch();
			}
			echo("</table>");
			$reqresult->closeCursor();
		}

// Si aucune catégorie et sous catégorie n'est sélectionné mais qu'on veut faire une recherche du nom du produit directement
		else
		{
			if(isset($_GET["txtrech"]) == true && $_GET["txtrech"]!="" )
			{
				$reqresult = $cnn->prepare("select COUNT(*) AS nbtoto from produit where prolib LIKE '%". $_GET["txtrech"] ."%'");
				$reqresult->execute();
				$uneligne = $reqresult->fetch();
				$n=1;
				echo "Page : ";
				$txtrech = $_GET["txtrech"];
				for ($i=0; $i <$uneligne['nbtoto'] ; $i=$i+10)
				{

					echo '<a href="produits.php?id=' .$i. '&sounum=&txtrech=' .$txtrech. '&catnum=">' .$n. '</a>';
					$n++;
					echo(". ");
				}


				$reqresult = $cnn->prepare("select pronum,prolib,proprix,proimg,sounum from produit where prolib LIKE '%". $_GET["txtrech"] ."%' limit 10");
				$reqresult->execute();
				$uneligne = $reqresult->fetch();
				echo("<table class='table table-striped w-auto' >");


				while ($uneligne!=null)
				{
					echo ("<tr><td><b>" . utf8_encode($uneligne["prolib"]) . "</b></td> <td>" . $uneligne["proprix"] . "€" . " </td> <td> " ."<button type='button' class='btn btn-primary'><a href ='leproduit.php?pronum=$uneligne[pronum]' style='color:white; text-decoration: none;'> Ajouter au panier </a></button>" ."</td> </tr> ");


					echo("<tr><td colspan=5 class='mx-auto text-center'><img id='$uneligne[proimg]' src='photos/$uneligne[proimg]' alt='$uneligne[proimg]' width=200 /></td></tr>");
					$uneligne = $reqresult->fetch();
				}
				echo("</table>");
				$reqresult->closeCursor();
			}


		}
	}


/*
?>
<?php
if (isset($_GET["txtrech"]) == true)
	{
		// Utilisation de connexion.inc.php pour ce connecter à la base de donnée
//require_once("connexion.inc.php");
		$reqresult = $cnn->prepare("select pronum,prolib,proprix,proimg,sounum from produit where prolib LIKE '%". $_GET["txtrech"] ."%'");
		//$reqresult->bindParam(':prolib',$_GET["txtrech"],PDO::PARAM_STR);
		$reqresult->execute();
		$uneligne = $reqresult->fetch();
		echo("<table border=1 >");

		while ($uneligne!=null)
			{
				echo ("<tr><td>" . utf8_encode($uneligne["prolib"]) . "</td> <td>" . $uneligne["proprix"] . "€" . " </td> <td> " ."<a href ='leproduit.php?pronum=$uneligne[pronum]'> Ajouter au panier </a>" ."</td> </tr> ");


    			echo("<tr><td colspan=5 ><img id='$uneligne[proimg]' src='photos/$uneligne[proimg]' alt='$uneligne[proimg]' width=200 /></td></tr>");
    			$uneligne = $reqresult->fetch();
	}
echo("</table>");
$reqresult->closeCursor();
$cnn=null;}

?>
*/
?>







</center>
</body>
</html>
