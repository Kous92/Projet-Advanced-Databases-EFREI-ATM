# Projet ADVANCED DATABASES

- Importer la base de données efrei_bank via PHPMyAdmin avec le fichier EFREI_BANK.sql

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
- dateCreation (DATE)

Scripts en PHP avec MySQL, la classe PDO sera utilisée