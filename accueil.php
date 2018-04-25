<?php
	session_start();
	require_once("atm.php");
	logged_only();

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

					<p id="message_client">Bienvenue, choisissez l'opération que vous voulez faire.</p></label></td>

					<?php  
						if (isset($_GET['success']))
						{
							echo "<div class=\"success_box\">" . $succes . "</div>";
						}
					?>

					<table class="action">
						<tr>
							<td class="left"><a href="#">Retrait</a></td>
							<td></td>
							<td></td>
							<td class="right"><a href="#">Dépôt</a></td>
						</tr>

						<tr>
							<td class="left"><a href="solde.php">Consultation du solde</a></td>
							<td></td>
							<td></td>
							<td class="right"><a href="#">Relevé de compte</a></td>
						</tr>

						<tr>
							<td class="left"><a href="informations.php">Vos informations</a></td>
							<td></td>
							<td></td>
							<td class="right"><a href="deconnexion.php">Récupérer votre carte bancaire</a></td>
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