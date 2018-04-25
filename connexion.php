<?php

	require_once("atm.php");
	$code = array();

	// Si au moins un caractère du code a été saisi
	if (isset($_POST['code']))
	{
		$code = $_POST['code'];
		$code_secret = implode($code);

		if (strlen($code_secret) < 1)
		{
			/* 
			   Message d'erreur avec $_GET via ? dans le lien
			   - error = 1: Code non saisi -> $_GET['error'] = 1
			   - error = 2: Code inférieur à 4 chiffres
			*/
			header('Location: index.php?error=1');
			exit();
		}
		else
		{
			if (strlen($code_secret) < 4)
			{
				header('Location: index.php?error=2');
				exit();
			}
			else
			{
				// Authentification
				$atm = new ATM();
				$atm = $atm->constructor($code_secret);

				// Le code est correct
				if ($atm->authentification() == true)
				{
					session_start();
					$token = generateToken(50);
					$_SESSION['auth'] = true;
			    	$_SESSION['token'] = $token;
			    	$_SESSION['prenom'] = $atm->getPrenom();
			    	$_SESSION['nom'] = $atm->getNom();
			    	$_SESSION['id'] = $atm->getID();

			    	// debug($_SESSION);
			    	// Redirection vers la page des opérations
			    	header("Location: accueil.php?success=0");
					exit();
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