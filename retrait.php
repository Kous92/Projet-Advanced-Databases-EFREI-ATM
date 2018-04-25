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

	// Pour le retrait, un 2ème token doit être créé pour sécuriser la transaction
	$_SESSION['token_retrait'] = generateToken(50);

	// Chaque redirection doit être sécurisée par un token, chaque page ira authentifier la session avec le token 
	$retrait1 = "<a href=\"operation_retrait.php?token=" . $_SESSION['token'] . "&token_retrait=" . $_SESSION['token_retrait'] . "&montant=10\">10€ </a>";
	$retrait2 = "<a href=\"operation_retrait.php?token=" . $_SESSION['token'] . "&token_retrait=" . $_SESSION['token_retrait'] . "&montant=20\">20€</a>";
	$retrait3 = "<a href=\"operation_retrait.php?token=" . $_SESSION['token'] . "&token_retrait=" . $_SESSION['token_retrait'] . "&montant=50\">50€</a>";
	$retrait4 = "<a href=\"operation_retrait.php?token=" . $_SESSION['token'] . "&token_retrait=" . $_SESSION['token_retrait'] . "&montant=100\">100€</a>";
	$retrait5 = "<a href=\"autre_montant.php?token=" . $_SESSION['token'] . "&token_retrait=" . $_SESSION['token_retrait'] . "\">Autre montant</a>";
	$retour = "<a href=\"accueil.php?token=" . $_SESSION['token'] . "\">Retour</a>"
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
	<title>EFREI BANK (Projet Advanced Databases</title>
</head>
<body>
	<header>
		<h1>EFREI BANK - Projet Advanced Databases (EFREI M1)</h1>
		<!-- <h2 id="titre_responsive">EFREI BANK (Projet Advanced Databases)</h2> -->
	</header>
	<div id="enveloppe">
		<div id="contenu">
			<!-- <div class="zone_actions"> -->
				<form action="" method="POST">

					<p id="message_client">Sélectionnez un montant à retirer</p></label></td>

					<?php  
						if (isset($_GET['success']))
						{
							echo "<div class=\"success_box\">" . $succes . "</div>";
						}
					?>

					<table class="action">
						<tr>
							<td class="left"><?php echo $retrait1 ?></td>
							<td></td>
							<td></td>
							<td class="right"><?php echo $retrait2 ?></td>
						</tr>

						<tr>
							<td class="left"><?php echo $retrait3 ?></td>
							<td></td>
							<td></td>
							<td class="right"><?php echo $retrait4 ?></td>
						</tr>

						<tr>
							<td class="left"><?php echo $retrait5 ?></td>
							<td></td>
							<td></td>
							<td class="right"><?php echo $retour ?></td>
						</tr>
					</table>
				</form>
			<!-- </div> -->
		</div>

		<div id="pied_page">
	    	<span id="date_heure"></span>
		    <script type="text/javascript">window.onload = date_heure('date_heure');</script> &nbsp;&nbsp;&nbsp;
			  	- &nbsp;&nbsp;&nbsp;Copyright Koussaïla BEN MAMAR - Ahmed ABDULHALIM - Ibrahim EL KARRAT - Alexandre SUHAS, Avril 2018, tous droits réservés</p>
	    </div><!-- Pied de page -->
	</div>
</body>
</html>	