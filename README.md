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
    - un container pour phpmyadmin
    
Une fois l'environnement de travail mis en place, j'ai créer un premier fichier pour ma classe PHP de connexion 
à la base de données.
