<?php

function addCreditCard()
{
	// Connexion à la base de données (méthode 1 avec PDO)
    try
    {
        // Ouverture de la base de données "efrei_bank"
        $bdd = new PDO('mysql:host=localhost; dbname=efrei_bank; charset=utf8', 'root', 'root');
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
        echo ">>> Accès établi à la base de données (efrei_bank)<br><br>";
    }
    catch (Exception $e)
    {
        die('Erreur : ' . $e->getMessage());
    }

    /*
    $codeSecret = "4567";
    $md5 = md5($codeSecret);
    $codeSecretHash = hash('sha256', $md5);
    echo "<ul>
    		<li>Code secret: $codeSecret</li>
    		<li>Hachage MD5: $md5</li>
    		<li>Hachage SHA-256: $codeSecretHash</li>
    	  </ul>";

	// Requête en mode sécurisé pour le mode préparé
    $SQLCommand = "INSERT INTO CarteBancaire(cardID, clientID_fk, codeSecret, typeCarte) VALUES (NULL, 4, '$codeSecretHash', 'Visa')";
    */
    
    $SQLCommand = "INSERT INTO CompteCourant(compteID, clientID, solde, dateCreation) VALUES (NULL, 1, 2854.75 , '2018-04-11')";
    $resultat = $bdd->exec($SQLCommand);

    // Requête d'ajout préparée pour plus de sécurité dans la base de données MySQL
    /*
    $req = $bdd->prepare($SQLCommand);
    $req->bindValue("nomFichier", $nom_fichier, PDO::PARAM_STR);
    $req->bindValue("description", $description, PDO::PARAM_STR);
    $req->bindValue("dateAjout", $date_ajout, PDO::PARAM_STR);
    $req->bindValue("emplacement", $emplacement, PDO::PARAM_STR);
    $req->bindValue("typeFichier", $type_fichier, PDO::PARAM_STR);
    $req->bindValue("id", 'NULL', PDO::PARAM_STR); // id fichier: clé primaire de la table MySQL.
    $resultat = $req->execute();
	*/

    /*
    if (!$resultat) 
    {
        die("<p class=\"erreur\">Erreur: Échec de la requête avec " .$SQLCommand. "</p>");
        return false;
    }
    else
    {
    	echo "Compte courant ajouté<br>";

        return true;
    }
    */
}

addCreditCard();

/*
INSERT INTO Operations(operationID, compteID, montant, typeOperation, dateOperation) VALUES (NULL, 4, 1500.00, 'Encaissement chèque', '2018-11-04');
INSERT INTO Operations(operationID, compteID, montant, typeOperation, dateOperation) VALUES (NULL, 4, 3750.00, 'Crédit virement', '2018-11-04');
INSERT INTO Operations(operationID, compteID, montant, typeOperation, dateOperation) VALUES (NULL, 4, 1799.99, 'CB', '2018-11-04');
INSERT INTO Operations(operationID, compteID, montant, typeOperation, dateOperation) VALUES (NULL, 4, 500.00, 'Retrait', '2018-11-04');
*/
?>