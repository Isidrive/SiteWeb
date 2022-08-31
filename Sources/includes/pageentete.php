<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>UDrive</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css"> <!-- Bootstrap -->
	<link rel="stylesheet" href="style.css"> <!-- Surcouche -->
	<script src="https://unpkg.com/ionicons@4.4.6/dist/ionicons.js"></script>
</head>

<body>
	<div class="container-fluid">
		<?php
		if(isset($_SESSION["clinum"]))
		{
			?>
			<nav class="navbar navbar-expand-lg navbar-light bg-light">
				<a class="navbar-brand" href="index.php">
					<img src="logo/logo_drive.png" width="180" height="60" alt="">
				</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
					<div class="navbar-nav">
						<a class="nav-item nav-link active" href="index.php"><ion-icon name="home"></ion-icon> Accueil</a>
						<a class="nav-item nav-link active" href="produits.php"> <ion-icon name="pricetags"></ion-icon> Produits</a>
						<a class="nav-item nav-link active" href="panier.php"> <ion-icon name="cart"></ion-icon> Panier</a>
						<a class="nav-item nav-link active" href="historique.php"> <ion-icon name="menu"></ion-icon> Historique des commandes</a>
						<a class="nav-item nav-link active" href="includes/deconnexioncompte.php"> <ion-icon name="remove-circle"></ion-icon> Deconnexion</a>
					</div>
				</div>
			</nav>
			<?php
		}
		else
		{
			?>
			<nav class="navbar navbar-expand-lg navbar-light bg-light">
				<a class="navbar-brand" href="index.php">
					<img src="logo/logo_drive.png" width="180" height="60" alt="">
				</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
					<div class="navbar-nav">
						<a class="nav-item nav-link active" href="index.php"> <ion-icon name="home"></ion-icon> Accueil</a>
						<a class="nav-item nav-link active" href="produits.php"> <ion-icon name="pricetags"></ion-icon> Produits</a>
						<a class="nav-item nav-link active" href="panier.php"> <ion-icon name="cart"></ion-icon> Panier</a>
						<a class="nav-item nav-link active" href="connexioncompte.php"> <ion-icon name="contact"></ion-icon> Se connecter</a>
						<a class="nav-item nav-link active" href="inscriptioncompte.php"> <ion-icon name="person-add"></ion-icon> Créer un compte</a>
					</div>
				</div>
			</nav>
			<?php
		}
		?>
	</center> <!-- FIN Menu -->
</div>
</body>
</html>
