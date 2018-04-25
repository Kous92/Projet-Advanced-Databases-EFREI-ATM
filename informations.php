<?php
	session_start();
	require_once("atm.php");
	logged_only();

	// debug($_SESSION);
	// debug($_GET);

	$atm = null;
	$solde = 0.0;

	if (isset($_SESSION))
	{
		$identite = $_SESSION['prenom'] . " " . $_SESSION['nom'];

		$atm = new ATM();
		$atm = $atm->constructor2($_SESSION['prenom'], $_SESSION['nom'], $_SESSION['id']);
	}

	$retour = "<a href=\"accueil.php\">Retour</a>"
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
					$date_naissance = $atm->getDateNaissance();
					$date_creation = $atm->getDateCreation();
					$numero_telephone = $atm->getNumeroTelephone();

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
				?>

				<p> Vos informations personnelles liées à votre compte </p>
				<ul>
					<li>Compte créé le: <?php echo $date_creation ?></li>
					<li>Numéro utilisé pour authentifier vos paiements en ligne: <?php echo $numero_telephone ?></li>
					<li>Date de naissance: <?php echo $date_naissance ?></li>
				</ul>

				<?php
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