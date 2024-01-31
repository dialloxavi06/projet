# Gestion de Projet

Le projet est une application web développée avec le framework Symfony, visant à faciliter la gestion de projets collaboratifs. L'application permet aux utilisateurs de créer, visualiser, et gérer des projets ainsi que leurs collaborateurs associés. Chaque projet peut avoir des tâches spécifiques attribuées et des détails tels que la description, l'échéance, et le statut.

## Installation


### Étapes d'installation

1. **Clonez le dépôt Git:**

   ```bash
   git clone https://github.com/dialloxavi06/projet.git

2. **Accéder au repertoire du projet:**
     
     cd projet
3. **Installation des dépendances avec Composer:**

    composer install

4. **Installation des dépendances avec Composer:**

    composer install

5. **Configurez votre base de données:**

    php bin/console doctrine:database:create
    php bin/console doctrine:migrations:migrate

5. **Lancez le server de développement:**

    php bin/console server:run
    Le projet sera accessible à l'adresse http://localhost:8000.


### Objectifs du Projet

1. **Gestion de Projets:**
Les utilisateurs peuvent ajouter de nouveaux projets via des formulaires dédiés. Chaque projet est associé à un nom, une 
description, un statut, et peut inclure une liste de collaborateurs qui y participent.

2. **Gestion de Collaborateurs:** 
Pour chaque projet, l'utilisateur peut ajouter des collaborateurs spécifiques, facilitant 
ainsi la collaboration et le suivi des membres de l'équipe associée à un projet.

3. **Gestion de Tâches (Non Implémentée):** 
Bien que la gestion de tâches n'ait pas été complètement implémentée, l'architecture du code suggère que chaque projet peut avoir une liste de tâches à accomplir. Cette fonctionnalité peut être étendue pour permettre aux utilisateurs d'ajouter, éditer, et supprimer des tâches pour chaque projet.

4. **ableau de Bord:** 
Le tableau de bord offre un aperçu rapide de la situation actuelle des projets. Il présente des indicateurs tels que le nombre de projets dans chaque statut, les cinq projets les plus récents, et le taux d'avancement des projets.

5. **Sécurité et Authentification :** 
L'application intègre probablement un système d'authentification utilisateur avec Symfony, garantissant que seuls les utilisateurs autorisés peuvent accéder et manipuler les données.


### Perspectives d'Amélioration

1. **Implémentation des Tâches :** Finaliser l'implémentation de la gestion des tâches pour permettre aux utilisateurs de gérer et suivre les tâches associées à chaque projet.

2. **Interface Utilisateur (UI/UX) :** Améliorer l'expérience utilisateur en optimisant l'interface graphique pour une navigation plus intuitive et conviviale.


### Vidéo du Démo:

[Cliquez ici pour regarder la démo](public/assets/video/video_demo_projet.mov)
