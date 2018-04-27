# Projet ADVANCED DATABASES

Projet officiel du module Advanced Databases en M1 à l'EFREI. Thématique: ATM (Distibuteur de billets). Codé en PHP avec HTML + CSS + MySQL via PHPMyAdmin.

Ce simulateur d'ATM a comme fonctionnalités implémentées:
* Simulation de carte bancaire par code secret de 4 chiffres et authentification par hachages successifs avec MD5 et SHA-256 -> SHA-256(MD5(code))
* Sécurisation des sessions avec des tokens de 50 caractères aléatoires + vérification de chaque page avec les variables superglobales
  * ` $_SESSION['token'] `
  * ` $_GET['token'] `


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