# Projet ADVANCED DATABASES

Créé par Koussaïla BEN MAMAR, en collaboration avec:
* Ahmed ABDULHALIM
* Ibrahim EL KARRAT
* Alexandre SUHAS.

EFREI Paris M1 Software Engineering Promo 2019

## Projet officiel du module Advanced Databases en M1 à l'EFREI. Thématique: ATM (Distibuteur de billets). Codé en PHP avec HTML + CSS + MySQL via PHPMyAdmin.

Ce simulateur d'ATM a comme fonctionnalités implémentées:
* Simulation de carte bancaire par code secret de 4 chiffres et authentification par hachages successifs avec MD5 et SHA-256 -> SHA-256(MD5(code))
* Sécurisation des sessions avec des tokens de 50 caractères aléatoires + vérification de chaque page avec les variables superglobales en les comparant
  * ` $_SESSION['token'] `
  * Via l'url: ` $_GET['token'] ` 
* Page d'accueil une fois authentifié avec les options
  * Retrait
  * Dépôt
  * Consultation du solde (en €)
  * Relevé de compte
  * Informations du client
* Simulation d'un retrait
  * Montants prédéfinis: 10€, 20€, 50€, 100€
  * Montant personnalisé: doit être un multiple de 10€ (on suppose que le distributeur donne des billets de 10, 20 ou 50€)
  * Conditions pour le retrait: 
    * Le compte doit être suffisamment approvisionné pour que le retrait soit effectif.
    * Maximum autorisé de 1 000€.
* Simulation d'un dépôt
  * Montant personnalisé: doit être un multiple de 5€ (on suppose que le distributeur accepte les billets de 5, 10, 20, 50, 100, 200 ou 500€)
  * Conditions pour le dépot: 
    * Maximum autorisé de 1 000 000€ (on suppose que le distributeur prend 200 billets maximum).

## Importer la base de données efrei_bank via PHPMyAdmin avec le fichier EFREI_BANK.sql

Tables de la base de données:
- Clients 
- CarteBancaire
- CompteCourant
- Operations

Table Clients
- clientID (INT) -> Clé primaire
- nomClient (VARCHAR)
- prenomClient (VARCHAR)
- dateNaissance (DATE)
- numeroTelephone (VARCHAR)

Table CompteCourant
- compteID (INT) -> Clé primaire
- clientID (INT) -> Clé étrangère sur la table Clients (clé primaire clientID)
- solde (FLOAT 12,2)
- dateCreation (DATE)

Table CarteBancaire
- cardID (INT) -> Clé primaire
- clientID_fk (INT) -> Clé étrangère sur la table Clients (clé primaire clientID)
- codeSecret (VARCHAR)
- typeCarte (VARCHAR)

Operation
- operationID (INT) -> Clé primaire
- compteID (INT) -> Clé étrangère sur la table CompteCourant (clé primaire clientID)
- montant (FLOAT 12,2)
- typeOperation (DATE)
- dateOperation (DATE)

Scripts en PHP avec MySQL, la classe PDO sera utilisée

# Requêtes MySQL:
* Authentification de la carte bancaire
  * `SELECT * FROM CarteBancaire WHERE codeSecret =  $code_secret;` (code de 4 chiffres haché en MD5 puis en SHA-256)
* Identifier le compte après authentification de la carte bancaire
  * `SELECT clientID_fk FROM CarteBancaire WHERE codeSecret =  $code_secret;` (code de 4 chiffres haché en MD5 puis en SHA-256)
* Obtenir le solde du compte identifié
  * `SELECT solde FROM CompteCourant, Clients, CarteBancaire WHERE CompteCourant.clientID = Clients.clientID AND Clients.clientID = CarteBancaire.clientID_fk AND CarteBancaire.clientID_fk = id;` ($id: int, clé primaire de la table)
* Obtenir le type de carte bancaire du compte identifié
  * `SELECT typeCarte FROM CompteCourant, Clients, CarteBancaire WHERE CompteCourant.clientID = Clients.clientID AND Clients.clientID = CarteBancaire.clientID_fk AND CarteBancaire.clientID_fk = id;` ($id: int, clé primaire de la table)
* Obtenir le nom du client du compte identifié
  * `SELECT nomClient FROM Clients, CarteBancaire WHERE (CarteBancaire.clientID_fk = Clients.clientID) AND (CarteBancaire.clientID_fk = id;` ($id: int, clé primaire de la table)
* Obtenir le prénom du client du compte identifié
  * `SELECT prenomClient FROM Clients, CarteBancaire WHERE (CarteBancaire.clientID_fk = Clients.clientID) AND (CarteBancaire.clientID_fk = id;` ($id: int, clé primaire de la table)
* Obtenir la date de naissance du client du compte identifié
  * `SELECT dateNaissance FROM Clients, CarteBancaire WHERE (CarteBancaire.clientID_fk = Clients.clientID) AND (CarteBancaire.clientID_fk = id;` ($id: int, clé primaire de la table)