<?php
	session_start();
	require_once("atm.php");
	verifierConnexion();

	// debug($_SESSION);
	debug($_GET);

	$atm = null;
	$solde = 0.0;

	if (isset($_SESSION))
	{
		$identite = $_SESSION['prenom'] . " " . $_SESSION['nom'];

		$atm = new ATM();
		$atm = $atm->constructor2($_SESSION['prenom'], $_SESSION['nom'], $_SESSION['id']);
	}

	// Authentification et sécurité de la session
	if ((isset($_GET['token'])) && (isset($_SESSION['token'])))
	{
		if (authentificationToken($_GET['token'], $_SESSION['token']) == false)
		{
			header('Location: index.php?error=3');
	    	exit();
		}

		// Authentification et sécurité de la transaction (le token sera systématiquement détruit après la transaction)
		if ((isset($_GET['token_retrait'])) && (isset($_SESSION['token_retrait'])))
		{
			if (authentificationToken($_GET['token_retrait'], $_SESSION['token_retrait']) == false)
			{
				header('Location: accueil.php?error=1');
		    	exit();
			}
		}
	}
	else
	{
	    header('Location: index.php?error=3');
	    exit();
	}

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
	<title>EFREI BANK - Informations</title>
</head>
<body>
	<header>
		<h1>EFREI BANK - Projet Advanced Databases (EFREI M1)</h1>
		<!-- <h2 id="titre_responsive">EFREI BANK (Projet Advanced Databases)</h2> -->
	</header>
	<div id="enveloppe">
		<div id="contenu">
			<div class="zone_affichage">
				<?php
					if (isset($_SESSION))
					{
						echo "<p id=\"message_client\">$identite</p>";
					}

					$type_carte = $atm->getTypeCarte();

					if ($type_carte == "MasterCard")
					{
						echo '<img src="mastercard_logo.png">';
					}
					else if ($type_carte == "Visa")
					{
						echo '<img src="visa_logo.png">';
					}
					else
					{
						echo "<p>Type de la carte bancaire: $type_carte</p>";
					}
					
					if (isset($_GET['montant']))
					{
						if ($atm->retrait($_GET['montant']))
						{
							$_SESSION['token_retrait'] = "";
							echo "<p id=\"message_client\">Vous avez demandé " . $_GET['montant'] . "€<br>
								  Veuillez recupérer vos billets.</p>";
						}
						else
						{
							echo "<p id=\"erreur\">ERREUR, solde insuffisant !</p>";
						}
					}
					else
					{
						echo "<p id=\"message_client\">ERREUR !</p>";
					}

					echo "<div class=\"retour\">" . $retour . "</div>";
				?>
			</div>
		</div>

		<div id="pied_page">
	    	<span id="date_heure"></span>
		    <script type="text/javascript">window.onload = date_heure('date_heure');</script> &nbsp;&nbsp;&nbsp;
			  	- &nbsp;&nbsp;&nbsp;Copyright Koussaïla BEN MAMAR - Ahmed ABDULHALIM - Ibrahim EL KARRAT - Alexandre SUHAS, Avril 2018, tous droits réservés</p>
	    </div><!-- Pied de page -->
	</div>
</body>
</html>