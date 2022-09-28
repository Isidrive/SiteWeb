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

                <div class="form-group">
                    <label for="catnum">Catégorie : </label>
                    <select class="form-select mb-2 mt-2 mx-auto w-25" aria-label="Default"  id="catnum" onchange='form.submit()' name="catnum">

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
                </div>
				<!--Fin de la requête permettant d'extraire les catégories-->
				<?php
				if (isset($_GET["catnum"]) && $_GET["catnum"]!="" )
				{
					?>
                <div class="form-group">
                    <label for="catnum">Sous-catégorie : </label>
                    <select class="form-select mb-2 mt-2 mx-auto w-25" aria-label="Default"  id="sounum" onchange='form.submit()' name="sounum">
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
                </div>
					<?php
} // Fermeture du if sur le cbo des soucat

if(isset($_GET['txtrech'])!="")
{
	$textrech = $_GET['txtrech']
	?>
	<br>
    <div class="input-group mb-3 mx-auto w-25">

        <input type="text" class="form-control "  name="txtrech" id="txtrech" aria-label="Default" aria-describedby="basic-addon2" value=<?php echo($textrech) ?> >
        <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="submit" name="btnrechercher">Rechercher</button>
        </div>
    </div>

<?php
}
else
{
//	?>
    <br>
    <div class="input-group mb-3 mx-auto w-25">

        <input type="text" class="form-control "  name="txtrech" id="txtrech" aria-label="Default" aria-describedby="basic-addon2" value=<?php echo($textrech) ?> >
        <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="submit" name="btnrechercher">Rechercher</button>
        </div>
    </div>

<?php
}
?>
<!--<button type="submit" class="btn btn-primary" name=btnrechercher>Rechercher</button>-->
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


        echo "Page : ";
        for ($i=0; $i <$uneligne['nbtoto'] ; $i=$i+10)
        {

        echo '<a href="produits.php?id=' .$i. '&txtrech=' .$txtrech. '&sounum=' .$sounum. '">' .$n. '</a>';
        $n++;
        echo(". ");
        }
      $reqresult->closeCursor();



//Affichage des produits selon le numéro de la page
		$id = $_GET['id'];


		//$reqresult = $cnn->prepare("select pronum,prolib,proprix,proimg,sounum from produit where prolib LIKE '%". $txtrech ."%' and pronum NOT IN (SELECT pronum from produit where prolib LIKE '%". $txtrech ."%' limit $id ORDER BY pronum) limit 10 ORDER BY pronum");
        var_dump($reqresult = $cnn->prepare("select pronum,prolib,proprix,proimg,sounum from produit where prolib LIKE '%". $txtrech ."%' and pronum (Select * from(SELECT pronum from produit prolib LIKE '%". $txtrech ."%' ORDER BY pronum LIMIT $id ) ORDER BY pronum limit 10"));

        $reqresult->execute();
		$uneligne = $reqresult->fetch();
		echo(" <div class='row'>");

		while ($uneligne!=null)
		{

			echo ("<div class='col-4 mt-2 mb-2'>
                <div class='card' style='width: 25rem;'>
  <img class='mt-2 mb-2 mx-auto text-center' id='$uneligne[proimg]' src='photos/$uneligne[proimg]' alt='$uneligne[proimg]' width=200 />
  <div class='card-body'>
    <h5 class='nameproduit'><b>". utf8_encode($uneligne["prolib"]) . "</b></h5>
    <p class='card-text'>" . $uneligne["proprix"] . "€</p>
    <button type='button' class='btn btn-primary'><a href ='leproduit.php?pronum=$uneligne[pronum]' style='color:white; text-decoration: none;'> Ajouter au panier </a></button>
  </div>
</div></div>");
			$uneligne = $reqresult->fetch();
		}
		echo("</div>");
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


		//$reqresult = $cnn->prepare("select pronum,prolib,proprix,proimg,sounum from produit where sounum = $sousnum and prolib LIKE '%". $txtrech ."%' and pronum NOT IN (SELECT pronum from produit where sounum = $sousnum and prolib LIKE '%". $txtrech ."%' limit $id ORDER BY pronum) LIMIT 10 ORDER BY pronum");
        $reqresult = $cnn->prepare("select pronum,prolib,proprix,proimg,sounum from produit where sounum = $sousnum and prolib LIKE '%". $txtrech ."%' and pronum (Select * from(SELECT pronum from produit where sounum = $sousnum and prolib LIKE '%". $txtrech ."%' ORDER BY pronum LIMIT $id) ORDER BY pronum limit 10");

		$reqresult->execute();
		$uneligne = $reqresult->fetch();
        echo(" <div class='row'>");

        while ($uneligne!=null)
        {

            echo ("<div class='col-4 mt-2 mb-2'>
                <div class='card' style='width: 25rem;'>
  <img class='mt-2 mb-2 text-center mx-auto' id='$uneligne[proimg]' src='photos/$uneligne[proimg]' alt='$uneligne[proimg]' width=200 />
  <div class='card-body'>
    <h5 class='nameproduit'><b>". utf8_encode($uneligne["prolib"]) . "</b></h5>
    <p class='card-text'>" . $uneligne["proprix"] . "€</p>
    <button type='button' class='btn btn-primary'><a href ='leproduit.php?pronum=$uneligne[pronum]' style='color:white; text-decoration: none;'> Ajouter au panier </a></button>
  </div>
</div></div>");
            $uneligne = $reqresult->fetch();
        }
        echo("</div>");
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
            echo(" <div class='row'>");

            while ($uneligne!=null)
            {

                echo ("<div class='col-4 mt-2 mb-2'>
                <div class='card' style='width: 25rem;'>
  <img class='mt-2 mb-2 text-center mx-auto' id='$uneligne[proimg]' src='photos/$uneligne[proimg]' alt='$uneligne[proimg]' width=200 />
  <div class='card-body'>
    <h5 class='nameproduit'><b>". utf8_encode($uneligne["prolib"]) . "</b></h5>
    <p class='card-text'>" . $uneligne["proprix"] . "€</p>
    <button type='button' class='btn btn-primary'><a href ='leproduit.php?pronum=$uneligne[pronum]' style='color:white; text-decoration: none;'> Ajouter au panier </a></button>
  </div>
</div></div>");
                $uneligne = $reqresult->fetch();
            }
            echo("</div>");
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
                echo(" <div class='row'>");

                while ($uneligne!=null)
                {

                    echo ("<div class='col-4 mt-2 mb-2'>
                <div class='card' style='width: 25rem;'>
  <img class='mt-2 mb-2 text-center mx-auto' id='$uneligne[proimg]' src='photos/$uneligne[proimg]' alt='$uneligne[proimg]' width=200 />
  <div class='card-body'>
    <h5 class='nameproduit'><b>". utf8_encode($uneligne["prolib"]) . "</b></h5>
    <p class='card-text'>" . $uneligne["proprix"] . "€</p>
    <button type='button' class='btn btn-primary'><a href ='leproduit.php?pronum=$uneligne[pronum]' style='color:white; text-decoration: none;'> Ajouter au panier </a></button>
  </div>
</div></div>");
                    $uneligne = $reqresult->fetch();
                }
                echo("</div>");
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
