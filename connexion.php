<?php

	require_once("atm.php");
	$code = array();

	// Si au moins un caractère du code a été saisi
	if (isset($_POST['code']))
	{
		$code = ($_POST['code']);
		$code_secret = implode($code);

		// Se protéger de la faille XSS est obligatoire !
		$code_secret = htmlspecialchars($code_secret);

		if (strlen($code_secret) < 1)
		{
			/* 
			   Message d'erreur avec $_GET via ? dans le lien
			   - error = 1: Code non saisi -> $_GET['error'] = 1
			   - error = 2: Code inférieur à 4 chiffres
			   - error = 0: Code incorrect
			*/
			header('Location: index.php?error=1');
			exit();
		}
		else
		{
			if ((strlen($code_secret) < 4) || (strlen($code_secret) > 4))
			{
				header('Location: index.php?error=2');
				exit();
			}
			else
			{
				echo "1<br>";

				if (is_numeric($code_secret) == true)
				{
					// Authentification
					$atm = new ATM();
					$atm = $atm->constructor($code_secret);

					// Le code est correct
					if ($atm->authentification() == true)
					{
						session_start();

						// Un token est obligatoire pour sécuriser la session et les opérations
						$token = generateToken(50);
						$_SESSION['auth'] = true;
				    	$_SESSION['token'] = $token;
				    	$_SESSION['prenom'] = $atm->getPrenom();
				    	$_SESSION['nom'] = $atm->getNom();
				    	$_SESSION['id'] = $atm->getID();

				    	// debug($_SESSION);
				    	// Redirection vers la page des opérations
				    	$redirection = "Location: accueil.php?success=0&token=" . $token;
				    	header($redirection);
						exit();
					}
					else
					{
						// Le code est incorrect: redirection vers la page d'accueil
						header('Location: index.php?error=0');
						exit();
					}
				}
				else
				{
					// Le code est incorrect: redirection vers la page d'accueil
					header('Location: index.php?error=0');
					exit();
				}
			}
		}
	}
?>