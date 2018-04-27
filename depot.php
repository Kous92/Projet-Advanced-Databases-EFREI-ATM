<?php
	session_start();
	require_once("atm.php");
	verifierConnexion();

	// debug($_SESSION);
	// debug($_GET);
	// debug($_POST);

	$atm = null;
	$solde = 0.0;
	$erreur_retrait = false;

	if (isset($_SESSION))
	{
		$identite = $_SESSION['prenom'] . " " . $_SESSION['nom'];

		$atm = new ATM();
		$atm = $atm->constructor2($_SESSION['prenom'], $_SESSION['nom'], $_SESSION['id']);
	}

	// Authentification et sécurité de la session
	if ((isset($_GET['token'])) && (isset($_SESSION['token'])) && (isset($_GET['token_depot'])) && (isset($_SESSION['token_depot'])))
	{
		if (authentificationToken($_GET['token'], $_SESSION['token']) == false)
		{
			header('Location: index.php?error=3');
	    	exit();
		}

		// Authentification et sécurité de la transaction (le token sera systématiquement détruit après la transaction)
		if (authentificationToken($_GET['token_depot'], $_SESSION['token_depot']) == false)
		{
			$_SESSION['token_depot'] = "";
			header('Location: accueil.php?error=1');
	    	exit();
		}
	}
	else
	{
	    header('Location: index.php?error=3');
	    exit();
	}

	if (isset($_POST['montant_depot']))
	{
		// La faille XSS ne doit pas être négligée
		$montant = htmlspecialchars($_POST['montant_depot']);

		// Il faut sécuriser impérativement la saisie et protéger la transaction contre les injections SQL !
		if (is_numeric($montant) && (filter_var(intval($montant), FILTER_VALIDATE_INT)))
		{	
			// OK, le montant est valide, on procède au retrait
			if (($atm->verifierMontantDepot($montant) == true) && ($atm->verifierMaximumDepotAutorise($montant) == true) && ($atm->verifierMinimumDepotAutorise($montant) == true))
			{
				$operation = "Location: operation_depot.php?token=" . $_SESSION['token'] . "&token_depot=" . $_SESSION['token_depot'] . "&montant=" . $montant;
				header($operation);
	    		exit();
			}
			else if ($atm->verifierMontantDepot($montant) == false)
			{
				$erreur_retrait = true;
				$erreur = "ERREUR: Le montant de " . $montant . " € est invalide. Veuillez définir un montant multiple de 5€.";
			}
			else if ($atm->verifierMaximumDepotAutorise($montant) == false)
			{
				$erreur_retrait = true;
				$erreur = "ERREUR: Le montant de " . $montant . " € dépasse le maximum autorisé de 1 000 000€.";
			}
			else if ($atm->verifierMinimumDepotAutorise($montant) == false)
			{
				$erreur_retrait = true;
				$erreur = "ERREUR: Vous devez définir un montant d'au minimum 10€";
			}
		}
		else
		{
			$erreur_retrait = true;

			if (empty($montant))
			{
				$erreur = "ERREUR: Veuillez définir un montant à déposer sur votre compte.";
			}
			else
			{
				$erreur = "ERREUR: La saisie de " . $montant . " est invalide.";
			}
		}
	}

	$cible = "depot.php?token=" . $_SESSION['token'] . "&token_depot=" . $_SESSION['token_depot'];
	$retour = "<a href=\"accueil.php?token=" . $_SESSION['token'] . "\">Annuler le dépôt</a>";
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
	<title>EFREI BANK - Dépôt d'espèces</title>
</head>
<body>
	<header>
		<h1>EFREI BANK - Projet Advanced Databases (EFREI M1)</h1>
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
				?>

				<?php echo "<form action=\"" . $cible . "\" method=\"POST\">"; ?>
					<table>
						<td colspan="2">
							<div class="warning_box">Dépôt: 200 billets maximum (de 5 à 500€). Montant maximal autorisé: 1 000 000€</div><br>
						</td>

						<tr>
							<td colspan="2" class="montant"><label for="montant_depot"><p id="message">Définissez le montant que vous voulez déposer, par tranches de 5€ uniquement.</p></label></td>
						</tr>
						
						<tr>
							<?php
								if ($erreur_retrait == true)
								{
									echo "<td class=\"input\"><input type=\"text\" name=\"montant_depot\" id=\"invalide\" value=\"" . $montant. "\" maxlength=\"12\"></td>";
								}
								else
								{
									echo "<td class=\"input\"><input type=\"text\" name=\"montant_depot\" id=\"montant_depot\" maxlength=\"12\"></td>";
								}
							?>
							<td class="symbol">€</td>
						</tr>

						<tr>
							<td colspan="2">
							<?php  
								if ($erreur_retrait == true)
								{
									echo "<div class=\"error_box\">" . $erreur . "</div>";
								}
							?>
							</td>
						</tr>

						<tr>
							<td class="ok"><input type="submit" value="Valider" title="Cliquez sur ce bouton pour envoyer les résultats"/></td>
							<td class="reset">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" value="Réinitialiser" title="Cliquez sur ce bouton pour réinitialiser le formulaire."/></td>
						</tr>
					</table>
				</form>
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