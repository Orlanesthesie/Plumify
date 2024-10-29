# PLUMIFY
## À propos du projet
L'objectif de Plumify est de créer un site web moderne qui facilite l'accès aux livres et permet aux utilisateurs de :
* Parcourir les livres populaires et récents.
* Rechercher des livres dans la bibliothèque.
* Vérifier la disponibilité des livres pour emprunt.
* S'inscrire et se connecter.
* Aimer des livres pour une expérience plus sociale.
* Consulter et gérer leur profil utilisateur.

## Fonctionnalités
* Parcourir et rechercher des livres.
* Vérifier la disponibilité des livres pour emprunt.
* Aimer des livres et voir les livres populaires.
* Gestion des prêts (côté administrateur uniquement).
* Connexion, inscription, et gestion de profil.
* Affichage des livres par genre.

## Technologies utilisées
Framework Backend : Symfony (PHP)
Frontend : Twig, HTML, CSS, Bootstrap
Base de données : PhpMyAdmin (MySQL)

## Installation
* Clonez le dépôt GitHub:
  #### `git clone git@github.com:Orlanesthesie/Plumify.git`
* Installer les dépendances:
  #### `composer install`
* Configurez votre environnement en dupliquant `.env` et en remplissant les informations nécessaires (base de données, etc.).
* Chargez la base de données avec les commandes suivantes:
    #### `php bin/console doctrine:database:create`   
    #### `php bin/console doctrine:migrations:migrate`
* Lancez le serveur Symfony :
    #### `symfony server:start`

## Utilisation
Une fois le serveur en cours d'exécution, vous pouvez accéder à Plumify en naviguant vers [http://localhost:3000](http://localhost:3000)

## Compte administrateur
Seuls les utilisateurs ayant un compte administrateur peuvent gérer les emprunts de livres.
