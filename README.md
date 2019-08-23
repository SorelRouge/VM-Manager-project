# VM-Manager-project
Projet IRT St Exupéry - Virtual Machine Manager

Ce projet a été réalisé lors de mon stage (6 semaines) de première année "Intégrateur Web" à l'IRT St-Exupéry de Toulouse.
L'objectif était de créer une interface utilisteur permettant de gérer les machines virtuelles de l'entreprise. 

J'ai tout d'abord mis en place un environnement de travail:
  - Travail depuis un poste fixe sous Windows 7, installation de Visual Studio Code et de MobaXterm pour se connecter 
  à une machine virtuelle Linux Debian.
  - Configuration de Remote SSH pour pouvoir accéder aux répertoires Linux depuis VS Code sous Windows.
  - Découverte de Docker et mise en place de plusieurs containers regroupant tout le nécessaire pour l'environnement:
    - un container pour un serveur Apache et PHP
    - un container pour Mysql
    - un container pour phpmyadmin.
Le fichier docker-compose.yml permet de configurer les dockers et de faire le lien entre eux.
Le fichier Dockerfile permet de spécifier certains paramètres pour le docker Apache/PHP.
    
Une fois l'environnement de travail mis en place, j'ai créé un premier fichier dbh.inc.php pour ma classe PHP de connexion 
à la base de données.
Un fichier index permet de définir l'arborescence de la page web affichant les informations :
  - un header présentant l'outil
  - une première colonne présentant une liste dans laquelle il est possible d'afficher les machines par ID, commentaire et date de dernière update et une barre de recherche parmettant de trouver les machines par ID, commentaire et date de dernière update
  - une seconde colonne affichant les informations de chaque machine une fois selectionnée
  - un formulaire de connexion à la machine (inactif).
Le fichier requetes.php regroupe les différentes fonctions utilisées pour communiquer avec la BDD et permettre de traiter et d'afficher sur la page web des informations concernant les machines (affichage des machines dans la liste, fonction de recherche etc.).

La fichier displayMachines.php est utilisé dans l'appel AJAX pour mettre en forme l'affichage des informations de chaque machines sur la colonne de droite.

Le dossier vmFiles regroupe les différents fichiers XML qui comprend les machines et leurs informations. Ce sont ces fichiers qui m'ont servi de base de travail. Une fonction boucle dessus et incrémente la base de données selon leur contenu.

Un fichier requetes.sql reprend les différentes requetes SQL qui m'ont été utiles.

Un dossier front comprend le Framework CSS Bulma, que j'ai assez peu utilisé.
Un fichier style.css permet de faire des ajustements de style sans passer par le fichier principal utilisé par Bulma.


    

