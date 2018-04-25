<?php

	class ATM
	{
		private $code_secret;
		private $bdd_sql;
		private $id_compte;
		private $nom;
		private $prenom;

		public function __construct()
		{
			$this->bdd_sql = $this->initialisationMySQL();
		}

		public function constructor($code)
		{
			$instance = new self();

			$instance->code_secret = $code;
			$instance->bdd_sql = $instance->initialisationMySQL();

			return $instance;
		}

		public function constructor2($nom, $prenom, $id)
		{
			$instance = new self();

			$instance->nom = $nom;
			$instance->prenom = $prenom;
			$instance->id_compte = $id;
			$instance->bdd_sql = $instance->initialisationMySQL();

			return $instance;
		}

		private function initialisationMySQL()
		{
			// Connexion à la base de données (méthode 1 avec PDO)
		    try
		    {
		        // Ouverture de la base de données "efrei_bank"
		        $bdd = new PDO('mysql:host=localhost; dbname=efrei_bank; charset=utf8', 'root', 'root');
		        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
		        // echo ">>> Accès établi à la base de données (efrei_bank)<br><br>";

		        return $bdd;
		    }
		    catch (Exception $e)
		    {
		        die('Erreur : ' . $e->getMessage());
		    }
		}

		private function dateFormatFrancais($date_sql)
		{
			// Voici les deux tableaux des jours et des mois traduits en français
			$jour = array('Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi');
			$mois = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');

			// On extrait la date du jour
			$date = $jour[date('w', strtotime($date_sql))] . " " . date('d', strtotime($date_sql)) . " " . $mois[date('m', strtotime($date_sql)) - 1] . " " .date('Y', strtotime($date_sql));

			return $date;
		}

		public function authentification()
		{
			// Le code secret sécurisé est de cette forme: SHA-256(MD5(code à 4 chiffres))
			$this->code_secret = md5($this->code_secret);
			$this->code_secret = hash('sha256', $this->code_secret);

			/* Authentification avec une requête SQL préparée avec le code secret saisi (comparaison avec les hachages)
			   Requête SQL: SELECT * FROM CarteBancaire WHERE codeSecret =  '$this->code_secret' */
			$SQLCommand = "SELECT * FROM CarteBancaire WHERE codeSecret = ?";
	        $requete = $this->bdd_sql->prepare($SQLCommand);
	        $resultat = $requete->execute(array($this->code_secret));

	        // Pas de résultat: requête invalide
	        if (!$resultat) 
	        {
	            die("<p>Erreur: Échec de la requête avec " .$SQLCommand. "</p>");
	            return false;
	        }
	        else
	        {
	        	// Si on a au moins une ligne dans la base de données, le code est correct
	        	if ($requete->rowCount() > 0)
	        	{
	        		// On récupère l'ID du compte qui sera stocké dans l'instance de l'objet ATM
	        		$SQLCommand = "SELECT clientID_fk FROM CarteBancaire WHERE codeSecret = ?";
			        $requete = $this->bdd_sql->prepare($SQLCommand);
			        $resultat2 = $requete->execute(array($this->code_secret));

			        // Pas de résultat: requête invalide
			        if (!$resultat2) 
			        {
			            die("<p>Erreur: Échec de la requête avec " .$SQLCommand. "</p>");
			        }
			        else
			        {
			        	if ($requete->rowCount() > 0)
	        			{
	        				// Récupération du résultat
	        				$ligne = $requete->fetch();
	        				$this->id_compte = $ligne['clientID_fk'];
	        			}
			        }

	        		return true;
	        	}
	        	else
	        	{
	        		// Code incorrect
	        		return false;
	        	} 
	        }
		}

		public function getSolde()
		{
			/* requête SQL préparée: jointures de Clients, CompteCourant et CarteBancaire avec les clés étrangères clientID_fk et clientID
			   -> Requête SQL: SELECT solde FROM CompteCourant, Clients, CarteBancaire WHERE CompteCourant.clientID = Clients.clientID AND Clients.clientID = CarteBancaire.clientID_fk AND CarteBancaire.clientID_fk = $this->id_compte */
			$SQLCommand = "SELECT solde FROM CompteCourant, Clients, CarteBancaire WHERE CompteCourant.clientID = Clients.clientID AND Clients.clientID = CarteBancaire.clientID_fk AND CarteBancaire.clientID_fk = ?";
	        $requete = $this->bdd_sql->prepare($SQLCommand);
	        $resultat = $requete->execute(array($this->id_compte));

	        // Pas de résultat: requête invalide
	        if (!$resultat) 
	        {
	            die("<p>Erreur: Échec de la requête avec " .$SQLCommand. "</p>");
	        }
	        else
	        {
	        	if ($requete->rowCount() > 0)
    			{
    				// Récupération du résultat
    				$ligne = $requete->fetch();

    				return $ligne['solde'];
    			}
    			else
    			{
    				return null;
    			}
	        }
		}

		public function getTypeCarte()
		{
			/* requête SQL préparée: jointures de Clients, CompteCourant et CarteBancaire avec les clés étrangères clientID_fk et clientID
			   -> Requête SQL: SELECT solde FROM CompteCourant, Clients, CarteBancaire WHERE CompteCourant.clientID = Clients.clientID AND Clients.clientID = CarteBancaire.clientID_fk AND CarteBancaire.clientID_fk = $this->id_compte */
			$SQLCommand = "SELECT typeCarte FROM CompteCourant, Clients, CarteBancaire WHERE CompteCourant.clientID = Clients.clientID AND Clients.clientID = CarteBancaire.clientID_fk AND CarteBancaire.clientID_fk = ?";
	        $requete = $this->bdd_sql->prepare($SQLCommand);
	        $resultat = $requete->execute(array($this->id_compte));

	        // Pas de résultat: requête invalide
	        if (!$resultat) 
	        {
	            die("<p>Erreur: Échec de la requête avec " .$SQLCommand. "</p>");
	        }
	        else
	        {
	        	if ($requete->rowCount() > 0)
    			{
    				// Récupération du résultat
    				$ligne = $requete->fetch();

    				return $ligne['typeCarte'];
    			}
    			else
    			{
    				return null;
    			}
	        }
		}

		public function getNom()
		{
			/* requête SQL préparée: jointure de Clients et CarteBancaire avec la clé étrangère clientID_fk
			   -> Requête SQL: SELECT nomClient FROM Clients, CarteBancaire WHERE (CarteBancaire.clientID_fk = Clients.clientID) AND (CarteBancaire.clientID_fk = '$this->id_compte') */
			$SQLCommand = "SELECT nomClient FROM Clients, CarteBancaire WHERE (CarteBancaire.clientID_fk = Clients.clientID) AND (CarteBancaire.clientID_fk = ?)";
	        $requete = $this->bdd_sql->prepare($SQLCommand);
	        $resultat = $requete->execute(array($this->id_compte));

	        // Pas de résultat: requête invalide
	        if (!$resultat) 
	        {
	            die("<p>Erreur: Échec de la requête avec " .$SQLCommand. "</p>");
	        }
	        else
	        {
	        	if ($requete->rowCount() > 0)
    			{
    				// Récupération du résultat
    				$ligne = $requete->fetch();

    				return $ligne['nomClient'];
    			}
    			else
    			{
    				return null;
    			}
	        }
		}

		public function getPrenom()
		{
			/* requête SQL préparée: jointure de Clients et CarteBancaire avec la clé étrangère clientID_fk
			   -> Requête SQL: SELECT nomClient FROM Clients, CarteBancaire WHERE (CarteBancaire.clientID_fk = Clients.clientID) AND (CarteBancaire.clientID_fk = '$this->id_compte') */
			$SQLCommand = "SELECT prenomClient FROM Clients, CarteBancaire WHERE (CarteBancaire.clientID_fk = Clients.clientID) AND (CarteBancaire.clientID_fk = ?)";
	        $requete = $this->bdd_sql->prepare($SQLCommand);
	        $resultat = $requete->execute(array($this->id_compte));

	        // Pas de résultat: requête invalide
	        if (!$resultat) 
	        {
	            die("<p>Erreur: Échec de la requête avec " .$SQLCommand. "</p>");
	        }
	        else
	        {
	        	if ($requete->rowCount() > 0)
    			{
    				// Récupération du résultat
    				$ligne = $requete->fetch();

    				return $ligne['prenomClient'];
    			}
    			else
    			{
    				return null;
    			}
	        }
		}

		public function getDateNaissance()
		{
			/* requête SQL préparée: jointure de Clients et CarteBancaire avec la clé étrangère clientID_fk
			   -> Requête SQL: SELECT nomClient FROM Clients, CarteBancaire WHERE (CarteBancaire.clientID_fk = Clients.clientID) AND (CarteBancaire.clientID_fk = '$this->id_compte') */
			$SQLCommand = "SELECT dateNaissance FROM Clients, CarteBancaire WHERE (CarteBancaire.clientID_fk = Clients.clientID) AND (CarteBancaire.clientID_fk = ?)";
	        $requete = $this->bdd_sql->prepare($SQLCommand);
	        $resultat = $requete->execute(array($this->id_compte));

	        // Pas de résultat: requête invalide
	        if (!$resultat) 
	        {
	            die("<p>Erreur: Échec de la requête avec " .$SQLCommand. "</p>");
	        }
	        else
	        {
	        	if ($requete->rowCount() > 0)
    			{
    				// Récupération du résultat
    				$ligne = $requete->fetch();

    				return $this->dateFormatFrancais($ligne['dateNaissance']);
    			}
    			else
    			{
    				return null;
    			}
	        }
		}

		public function getDateCreation()
		{
			/* requête SQL préparée: jointure de Clients et CarteBancaire avec la clé étrangère clientID_fk
			   -> Requête SQL: SELECT nomClient FROM Clients, CarteBancaire WHERE (CarteBancaire.clientID_fk = Clients.clientID) AND (CarteBancaire.clientID_fk = '$this->id_compte') */
			$SQLCommand = "SELECT dateCreation FROM CompteCourant, Clients, CarteBancaire WHERE CompteCourant.clientID = Clients.clientID AND Clients.clientID = CarteBancaire.clientID_fk AND CarteBancaire.clientID_fk = ?";
	        $requete = $this->bdd_sql->prepare($SQLCommand);
	        $resultat = $requete->execute(array($this->id_compte));

	        // Pas de résultat: requête invalide
	        if (!$resultat) 
	        {
	            die("<p>Erreur: Échec de la requête avec " .$SQLCommand. "</p>");
	        }
	        else
	        {
	        	if ($requete->rowCount() > 0)
    			{
    				// Récupération du résultat
    				$ligne = $requete->fetch();

    				return $this->dateFormatFrancais($ligne['dateCreation']);
    			}
    			else
    			{
    				return null;
    			}
	        }
		}

		public function getNumeroTelephone()
		{
			/* requête SQL préparée: jointure de Clients et CarteBancaire avec la clé étrangère clientID_fk
			   -> Requête SQL: SELECT nomClient FROM Clients, CarteBancaire WHERE (CarteBancaire.clientID_fk = Clients.clientID) AND (CarteBancaire.clientID_fk = '$this->id_compte') */
			$SQLCommand = "SELECT numeroTelephone FROM CompteCourant, Clients, CarteBancaire WHERE CompteCourant.clientID = Clients.clientID AND Clients.clientID = CarteBancaire.clientID_fk AND CarteBancaire.clientID_fk = ?";
	        $requete = $this->bdd_sql->prepare($SQLCommand);
	        $resultat = $requete->execute(array($this->id_compte));

	        // Pas de résultat: requête invalide
	        if (!$resultat) 
	        {
	            die("<p>Erreur: Échec de la requête avec " .$SQLCommand. "</p>");
	        }
	        else
	        {
	        	if ($requete->rowCount() > 0)
    			{
    				// Récupération du résultat
    				$ligne = $requete->fetch();

    				return $ligne['numeroTelephone'];
    			}
    			else
    			{
    				return null;
    			}
	        }
		}

		public function getID()
		{
			return $this->id_compte;
		}
	}

	function logged_only()
	{
	    if (session_status() == PHP_SESSION_NONE)
	    {
	    	// echo "Session pas lancée<br><br>";
	        session_start();
	    }

	    // var_dump($_SESSION);

	    if (!isset($_SESSION['auth']))
	    {
	        header('Location: index.php?error=3');
	        exit();
	    }
	}

	function generateToken($length)
	{
	    $alphabet = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
	    $token = substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);

	    return $token;
	}

	function debug($variable)
	{
		echo "<h3>". print_r($variable, true) . "</h3><br>";
	}
?>