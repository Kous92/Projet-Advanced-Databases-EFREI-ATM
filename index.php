<?php
	// session_destroy();
	// require_once("atm.php");
	$erreur = "";
	$code_erreur = 0;
	// debug($_GET);

	// Si une erreur existe
	if (isset($_GET['error']))
	{
		if ($_GET['error'] == 0)
		{
			$code_erreur = 0;
			$erreur = "ERREUR: Le code de votre carte est incorrect";
		}
		else if (($_GET['error'] == 1) || ($_GET['error'] == 2))
		{
			$code_erreur = 2;
			$erreur = "ERREUR: Veuillez saisir votre code confidentiel à 4 chiffres";
		}
		else if ($_GET['error'] == 3)
		{
			$code_erreur = 3;
			$erreur = "ERREUR: Veuillez insérer votre carte afin de vous authentifier";
		}
		else
		{
			$code_erreur = 4;
			$erreur = "Une erreur inconnue est survenue";
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
	<title>EFREI BANK (Projet Advanced Databases)</title>
</head>
<body>
	<header>
		<h1>EFREI BANK - Projet Advanced Databases (EFREI M1)</h1>
	</header>
	<div id="enveloppe">
		<div id="contenu">
			<div class="zone_affichage">
				<form action="connexion.php" method="POST">
					<table>
						<tr>
							<td colspan="4"><label for="code"><p id="message">Bonjour, pour insérer votre carte bancaire, veuillez saisir votre code secret.</p></label></td>
						</tr>
						
						<tr>
							<td><input type="password" name="code[]" id="code" maxlength="1"></td>
							<td><input type="password" name="code[]" id="code" maxlength="1"></td>
							<td><input type="password" name="code[]" id="code" maxlength="1"></td>
							<td><input type="password" name="code[]" id="code" maxlength="1"></td>
						</tr>

						<tr>
							<td colspan="4">
							<?php  
								if (isset($_GET['error']))
								{
									echo "<div class=\"error_box\">" . $erreur . "</div>";
								}
							?>
							</td>
						</tr>

						<tr>
							<td colspan="2"><input type="submit" value="Valider" title="Cliquez sur ce bouton pour envoyer les résultats"/></td>
							<td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" value="Réinitialiser" title="Cliquez sur ce bouton pour réinitialiser le formulaire."/></td>
						</tr>
					</table>
				</form>
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