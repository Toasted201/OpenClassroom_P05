readme
# Projet OpenclassRooms : Créez votre premier blog en PHP

## Description du projet

Dans le cadre de la formation Développeur d'application - PHP / Symfony d'OpenClassRooms, voici le projet n°5 : créer un blog en PHP.

## Contexte
Ça y est, vous avez sauté le pas ! Le monde du développement web avec PHP est à portée de main et vous avez besoin de visibilité pour pouvoir convaincre vos futurs employeurs/clients en un seul regard. Vous êtes développeur PHP, il est donc temps de montrer vos talents au travers d’un blog à vos couleurs.

## Contraintes
Cette fois-ci, nous n’utiliserons pas WordPress. Tout sera développé par vos soins. Les seules lignes de code qui pourront provenir d’ailleurs seront celles du thème Bootstrap. Il est également autorisé d’utiliser une ou plusieurs librairies externes à condition qu’elles soient intégrées grâce à Composer.

Attention, votre blog doit être navigable aisément sur un mobile (téléphone mobile, phablette, tablette…)
Nous vous conseillons vivement d’utiliser un moteur de templating tel que Twig, mais ce n’est pas obligatoire.

Important : Vous vous assurerez qu’il n’y a pas de failles de sécurité (XSS, CSRF, SQL Injection, session hijacking, upload possible de script PHP…).

Votre projet doit être poussé et disponible sur GitHub.


## Pour commencer

### Pré-requis

- Php 7.4
- Apache 2.2
- Composer 1.10
- Une base de données mySQL 5.7
- Git

### Installation

- Cloner le projet en local
- Importer la base de données d'exemple : /db_blog.sql
- Configuer Apache pour pointer vers le repertoire public/
- Executer la commande composer :
```bash
composer install
```


### Paramétrage

- Base de données : 
Modifier les informations de connexion dans le fichier \.env

- Envoi des mails :
Si vous souhaitez utiliser un serveur de mail afin d'envoyer des mails, vous pouvez le configurer dans $transport de FrontController.php.
Les informations de connexion sont dans le fichier \.env.


## Fabriqué avec

* Visual Studio Code
* Twig Language
* PHP Sniffer & Beautifier
* PHP Intelephense
* Live Server
* phpdotenv 5.1
* bootswatch 4.5 
* twig 3.0
* swiftmailer 6.2


## Versions
- **V2.1** Première version publiée
- **V2.0** Polishing & Refactoring
- **V1.1** Bug Fixes
- **V1.0** Première version
