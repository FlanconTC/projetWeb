# Adopte un dev'

## Description
Site de matching entre entreprises et développeurs.
Vidéo de présentation :
https://youtu.be/wmK5gr22Xto

## Table des matières
1. [Description](#description)
2. [Installation](#installation)
3. [Répartition](#répartition)

## Installation

Suivez ces étapes pour installer et exécuter ce projet en local.

1. Clonez le repository :
   ```bash
   git clone https://github.com/FlanconTC/projetWeb.git

2. aller dans adopte-un-dev :
   ```bash
   cd .\adopte-un-dev\

3. executer docker :
    ```bash
    docker-compose up

Attention il se peux que l'entrypoint ne s'execute pas, faire bien attention a se que le ficher soit reconnu comme LF et pas CRLF (sur vscode voir en bas a droite juste a cliquer sur CRLF et choisir LF).

## Répartition

Le groupe de travail est composé de Tagatte Diop, Éloïse Artus, Dorian Le Peillet et Corentin Bot-Le Goascoz
La répartition du travail a été effectuée comme suit :

1. Fonctionnalités proposées

    2.1 Gestion des Utilisateurs

        a) Inscription distincte : développeur ou entreprise

            -> Dorian & Corentin

        b) Profil public/privé : option pour masquer les informations sensibles (contact, salaire)

            -> Dorian & Corentin

        c) Rôles : gestion des droits utilisateur via ROLE_DEV et ROLE_COMPANY.

            -> Dorian

    2.2. Création et Gestion des Profils/Fiches de postes

        -> Dorian

    2.3. Système de Matching (Correspondance)

        -> Corentin

    2.4. Pages d'Accueil Dynamiques

        -> Dorian

    2.5. Recherche Avancée

        -> Corentin

    2.6. Évaluations et Feedbacks

        -> Fonctionnalité non ajoutée

    2.7. Fonctionnalités sociales

        • Favoris : Dorian
        
        Le reste n'a pas été ajouté.

    2.8. Suivi et Analyses

        -> Dorian

    2.9. Backup et Déploiement

        -> Dorian
        
