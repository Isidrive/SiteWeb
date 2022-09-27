<?php
include("includes/pageentete.php");
//---------------- 1A : Affichage du formulaire avec les catégories 
?>
<center>
	<div class="p-3 mb-2 bg-primary text-white"><h3>Inscription</h3></div>
</center>
<div class="container">
	<form method="get" action="inscriptioncompte.php">
		<!--Mise en place des zones de textes-->
		<div class="container">
			<form>
				<div class="form-row">
					<div class="form-group col-md-4">
						<label for="inputCity">Nom</label>
						<input type="text" class="form-control" id="inputCity" name="txtnom">
					</div>
					<div class="form-group col-md-4">
						<label for="inputCity">Prénom</label>
						<input type="text" class="form-control" id="inputCity" name="txtprenom">
					</div>
					<div class="form-group col-md-4">
						<label for="inputCity">Téléphone</label>
						<input type="tel" placeholder="0123456789" form-control" id="inputCity" name="txttel" pattern="[0-9]10">
					</div>
					<div class="form-group col-md-6">
						<label for="inputEmail4">Email</label>
						<input type="email" class="form-control" id="inputEmail4" name="txtmail">
					</div>
					<div class="form-group col-md-6">
						<label for="inputPassword4">Mot de passe</label>
						<input type="password" class="form-control" id="inputPassword4" name="txtmdp">
					</div>
					<div class="form-group col-md-6">
						<label for="inputCity">Adresse 1</label>
						<input type="text" class="form-control" id="inputCity" name="txtadr1">
					</div>
					<div class="form-group col-md-6">
						<label for="inputZip">Adresse 2</label>
						<input type="text" class="form-control" id="inputZip" name="txtadr2">
					</div>
					<div class="form-group col-md-6">
						<label for="inputZip">Ville</label>
						<input type="text" class="form-control" id="inputZip" name="txtville">
					</div>
					<div class="form-group col-md-6">
						<label for="inputZip">Code Postal</label>
						<input type="text" placeholder="69590" class="form-control" id="inputZip" name="txtcp" pattern="[0-9]{5}">
					</div>
				</div>
				<button type="submit" class="btn btn-primary" name="btnajouter">S'incrire</button>
			</form>
		</div>
		<br>
	</form>

	<!--Ouverture du php-->
	<?php
	require_once("connexion.inc.php");
	if(isset($_GET["btnajouter"])==true)
	{
			// Création du compte
		$reqresult = $cnn -> prepare("insert into client (clinom , cliprenom, cliadr1, cliadr2, clicp, cliville, clitel, climail, climdp, magnum) values (:clinom, :cliprenom, :cliadr1, :cliadr2, :clicp, :cliville, :clitel, :climail, :climdp, 3)");
		$reqresult->bindParam(':clinom',$_GET["txtnom"],PDO::PARAM_STR);
		$reqresult->bindParam(':cliprenom',$_GET["txtprenom"],PDO::PARAM_STR);
		$reqresult->bindParam(':cliadr1',$_GET["txtadr1"],PDO::PARAM_STR);
		$reqresult->bindParam(':cliadr2',$_GET["txtadr2"],PDO::PARAM_STR);
		$reqresult->bindParam(':clicp',$_GET["txtcp"],PDO::PARAM_STR);
		$reqresult->bindParam(':cliville',$_GET["txtville"],PDO::PARAM_STR);
		$reqresult->bindParam(':clitel',$_GET["txttel"],PDO::PARAM_STR);
		$reqresult->bindParam(':climail',$_GET["txtmail"],PDO::PARAM_STR);
		$reqresult->bindParam(':climdp',$_GET["txtmdp"],PDO::PARAM_STR);
		$res=$reqresult -> execute();
		$reqresult -> closeCursor();
		?> 
		<div class="p-3 mb-2 bg-light text-dark">Votre compte a été créé ! Redirection automatique à la page de connexion dans 3 secondes</div> 
		<?php
		header("Refresh: 3; URL=connexioncompte.php");
	}
	?>
</center>
</div>
</body>
</html><!--echo("<br> Votre compte a été créé ! Redirection automatique à la page de connexion dans 3 secondes");-->