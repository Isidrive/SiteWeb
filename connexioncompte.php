<?php
include("includes/pageentete.php");
//---------------- 1A : Affichage du formulaire avec les catégories 
?>

<!-- Formulaire de connexion -->
<form method="get" action="connexioncompte.php">
	<!--Mise en place des zones de textes-->
	<center>
		<div class="p-3 mb-2 bg-primary text-white"><h3>Connexion au compte</h3></div>
	</center>
	<div class="container">
		<form>
			<div class="form-group">
				<label for="exampleInputEmail1">Adresse mail</label>
				<input type="email" class="form-control" id="exampleInputEmail1" placeholder="Votre adresse mail" name="txtmail">
			</div>
			<div class="form-group">
				<label for="exampleInputPassword1">Mot de passe</label>
				<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Votre mot de passe" name=txtmdp>
			</div>
			<button type="submit" class="btn btn-primary" name=btnconnexion>Se connecter</button>
		</form>

		<!-- Requête de vérification -->
		<?php
		require_once("connexion.inc.php");
		if(isset($_GET["btnconnexion"])==true)
		{
			// Connexion au compte
			$mdp = $_GET["txtmdp"];
			$identifiant = $_GET["txtmail"];
			$reqresult = $cnn -> prepare("select * from client where climail = :climail and climdp = :climdp");
			$reqresult->bindParam(':climail',$_GET["txtmail"],PDO::PARAM_STR);
			$reqresult->bindParam(':climdp',$_GET["txtmdp"],PDO::PARAM_STR);
			$reqresult -> execute();
			$uneligne = $reqresult -> fetch();
			if ($uneligne["clinom"] == null)
			{
				echo("<div class=p-3 mb-2 bg-light text-dark> Identification échouée, veuillez vérifier votre adresse mail et le mot de passe associé.</div>");
			}
			else
			{
				$_SESSION["cliprenom"]=$uneligne["cliprenom"];
				$_SESSION["clinum"]=$uneligne["clinum"];
				$_SESSION["clinom"]=$uneligne["clinom"];
				?> 
				<div class="p-3 mb-2 bg-light text-dark">Identification réussie ! Bienvenue <?php echo("$_SESSION[cliprenom] $_SESSION[clinom]");?>. Redirection à l'accueil automatique dans 3 secondes.</div> 
				<?php
				header("Refresh: 3; URL=index.php");
			}	
			$reqresult -> closeCursor();
		}
		?>
	</div>
	<br>
</body>
</html>    