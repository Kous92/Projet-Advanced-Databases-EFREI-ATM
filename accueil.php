<?php
	session_start();
	require_once("atm.php");
	verifierConnexion();

	// debug($_SESSION);
	// debug($_GET);
	$succes = "";
	$code_succes = 0;

	// Si l'utilisateur vient de se connecter
	if (isset($_GET['success']))
	{
		if ($_GET['success'] == 0)
		{
			$code_succes = 0;
			$succes = $_SESSION['nom'] . " " . $_SESSION['prenom'] . ", bienvenue.";
		}
	}

	// Si une erreur existe
	if (isset($_GET['error']))
	{
		if ($_GET['error'] == 1)
		{
			$code_erreur = 1;
			$erreur = "Une erreur est survenue lors du retrait, veuillez réessayer.";
		}
	}

	// Authentification et sécurité de la session
	if ((isset($_GET['token'])) && (isset($_SESSION['token'])))
	{
		if (authentificationToken($_GET['token'], $_SESSION['token']) == false)
		{
			header('Location: index.php?error=3');
	    	exit();
		}
	}
	else
	{
	    header('Location: index.php?error=3');
	    exit();
	}

	// Pour le dépôt, un 2ème token doit être créé pour sécuriser la transaction
	$_SESSION['token_depot'] = generateToken(50);

	// Chaque redirection doit être sécurisée par un token, chaque page ira authentifier la session avec le token 
	$retrait = "<a href=\"retrait.php?token=" . $_SESSION['token'] . "\">Retrait</a>";
	$depot = "<a href=\"depot.php?token=" . $_SESSION['token'] . "&token_depot=" . $_SESSION['token_depot'] . "\">Dépôt</a>";
	$solde = "<a href=\"solde.php?token=" . $_SESSION['token'] . "\">Consultation de compte</a>";
	$releve = "<a href=\"releve_compte.php?token=" . $_SESSION['token'] . "\">Relevé de compte</a>";
	$informations = "<a href=\"informations.php?token=" . $_SESSION['token'] . "\">Vos informations</a>";
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="CSS/style.css">
	<link rel="stylesheet" type="text/css" href="CSS/font-awesome.min.css">
	<script type="text/javascript" src="JS/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="JS/script.js"></script>
	<script type="text/javascript" src="JS/date_heure.js"></script>
	<meta name="robots" content="noindex">
	<title>EFREI BANK - Accueil client</title>
</head>
<body>
	<header>
		<h1>EFREI BANK - Projet Advanced Databases (EFREI M1)</h1>
	</header>
	<div id="enveloppe">
		<div id="contenu">
			<form action="" method="POST">

				<p id="message_client">Bienvenue, choisissez l'opération que vous voulez faire.</p></label></td>

				<?php  
					if (isset($_GET['success']))
					{
						echo "<div class=\"success_box\">" . $succes . "</div>";
					}
					else if (isset($_GET['error']))
					{
						echo "<div class=\"error_box\">" . $erreur . "</div>";
					}
				?>

				<table class="action">
					<tr>
						<td class="left"><?php echo $retrait ?></td>
						<td></td>
						<td></td>
						<td class="right"><?php echo $depot ?></td>
					</tr>

					<tr>
						<td class="left"><?php echo $solde ?></td>
						<td></td>
						<td></td>
						<td class="right"><?php echo $releve ?></td>
					</tr>

					<tr>
						<td class="left"><?php echo $informations ?></td>
						<td></td>
						<td></td>
						<td class="right"><a href="deconnexion.php">Récupérer votre carte bancaire</a></td>
					</tr>
				</table>
			</form>
		</div>

		<div id="pied_page">
	    	<span id="date_heure"></span>
		    <script type="text/javascript">window.onload = date_heure('date_heure');</script> &nbsp;&nbsp;&nbsp;
			  	- &nbsp;&nbsp;&nbsp;Copyright Koussaïla BEN MAMAR - Ahmed ABDULHALIM - Ibrahim EL KARRAT - Alexandre SUHAS, Avril 2018, tous droits réservés</p>
	    </div><!-- Pied de page -->
	</div>
</body>
</html>	