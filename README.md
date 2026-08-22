Créno : App Laravel, Auth Middleware & Tests Unitaires PHPUnit
Assigné
fr

SH
Salma Harda
créé : 10/08/26
Une application web de prise de rendez-vous développée avec Laravel et Blade, permettant à des clients de réserver un créneau auprès d'un praticien (coiffeur, médecin, garagiste, etc.) et à un administrateur de gérer les créneaux disponibles. L'application repose sur une authentification protégée par middleware Laravel (accès différencié client/administrateur) et sur la logique métier de gestion des créneaux (disponibilité, non chevauchement, annulation). Une part importante du travail consiste à écrire des tests unitaires avec PHPUnit couvrant les modèles Eloquent, les règles métier et les Form Requests .
Référentiels
[2023] Développeur web et web mobile
Compétences transversales
Contexte du projet
Vous êtes développeur junior chez WebCraft Studio. Un client indépendant (salon, cabinet, garage) gère encore ses rendez-vous par téléphone et sur un cahier papier : créneaux oubliés, doubles réservations, aucune vue d'ensemble. Il vous confie le développement d'une application Laravel simple permettant à ses clients de réserver un créneau en ligne, et à lui-même de gérer son planning. Le client insiste moins sur la richesse fonctionnelle que sur la fiabilité : il veut être sûr que "l'application ne plante pas et ne double jamais un créneau", ce qui vous amène naturellement aux tests unitaires.

**Règles de gestion : **

Un utilisateur doit être authentifié pour réserver un rendez-vous.
Deux rôles existent : client et administrateur, distingués par un champ role.
Seul l'administrateur peut créer, modifier ou supprimer les créneaux disponibles (routes protégées par middleware).
Un créneau a une date, une heure de début et une durée fixe.
Un même créneau ne peut pas être réservé par deux clients différents (unicité).
Un client ne peut pas réserver deux créneaux qui se chevauchent.
Un rendez-vous a un statut : en attente, confirmé, annulé.
Un client ne peut annuler que ses propres rendez-vous.
Un créneau passé ne peut plus être réservé.
**User Stories :**

US1 : En tant que visiteur, je dois pouvoir m'inscrire et me connecter afin d'accéder à la réservation.
US2 : En tant que client, je dois voir la liste des créneaux disponibles afin de choisir un rendez-vous.
US3 : En tant que client, je dois pouvoir réserver un créneau libre afin de fixer mon rendez-vous.
US4 : En tant que client, je dois pouvoir annuler mon propre rendez-vous afin de libérer le créneau.
US5 : En tant qu'administrateur, je dois gérer les créneaux (CRUD) afin de tenir mon planning à jour.
US6 : En tant qu'administrateur, je dois accéder à un tableau de bord protégé afin de voir tous les rendez-vous.
US7 : En tant que développeur, je dois écrire des tests unitaires PHPUnit afin de garantir que les règles métier (non-chevauchement, unicité, autorisations) sont respectées.
**Étapes d'accompagnement :**

Étape 1 — Mise en place & authentification : projet Laravel, migrations (users avec role, creneaux, rendez_vous), Laravel Breeze ou auth manuelle, création d'un middleware IsAdmin protégeant les routes d'administration.
Étape 2 — Modèles & relations Eloquent : modèles User, Creneau, RendezVous avec relations (hasMany/belongsTo), scopes utiles (disponibles(), passés()), méthode métier de détection de chevauchement sur le modèle Creneau.
Étape 3 — Vues Blade & fonctionnalités : liste des créneaux, formulaire de réservation, page "mes rendez-vous", espace admin (CRUD créneaux) avec layouts Blade et directives @if/@auth/@can.
Étape 4 — Tests unitaires PHPUnit (cœur du projet) : configuration de la base de test (SQLite en mémoire), tests unitaires sur le modèle Creneau (détection de chevauchement, créneau passé), tests sur les Form Requests (validation des données de réservation), tests sur la logique d'autorisation (un client ne peut pas annuler le rendez-vous d'un autre), utilisation de factories pour générer les données de test.
Étape 5 — Consolidation & couverture : relecture des tests, ajout de cas limites (créneau à la frontière, double clic de réservation), vérification que chaque règle de gestion possède au moins un test associé.
Modalités pédagogiques
Travail en binôme.
Durée : 5 jours.
Lancement : 10/08/2026.
Deadline : 14/08/2026 – 23h59.
Modalités d'évaluation
- Entretien : 30 minutes
- 5 min —> Présentation + démonstration.
- 10 min — >Code Review & Évaluation des savoirs (Q&A).
- 15 min — >Mise en situation.
questions ciblées sur les tests unitaires écrits (pourquoi ce test, que couvre-t-il, que se passe-t-il s'il échoue).
Livrables
- Lien GitHub du dépôt (code + historique de commits du binôme).
- Fichier README expliquant l'installation, le lancement de l'app et l'exécution des tests.
Critères de performance
- Application : authentification opérationnelle, middleware bloquant correctement l'accès admin aux clients, CRUD des créneaux fonctionnel, réservation empêchant tout chevauchement en base.

- Tests unitaires : suite php artisan test entièrement verte, tests couvrant au moins les règles de non-chevauchement, l'unicité de réservation et une règle d'autorisation, usage cohérent de factories/assertions Laravel, tests indépendants les uns des autres.

- Qualité générale : code organisé selon les conventions Laravel (Controllers, Models, Requests, Middleware bien séparés), binôme capable de justifier ses choix de tests à l'oral.
Situation professionnelle
Moderniser une application web en développant une API REST robuste avec un framework backend
Besoin visé ou problème rencontré
Une entreprise dispose d’une application web monolithique nécessitant une modernisation afin d’améliorer sa maintenabilité, sa performance et sa capacité à exposer des services à d’autres applications (front-end, mobile, partenaires). Le développeur backend doit structurer l’application autour d’un framework moderne, créer des APIs REST normalisées, organiser la gestion des données et sécuriser les accès utilisateurs, tout en préparant l’application au déploiement dans un environnement serveur.
13 compétences visées
Compétences visées
C2. Contribuer au pilotage de l’organisation du travail individuel et collectif
niveau 1, imiter
niveau 2, adapter
niveau 3, transposer
C3. Définir le périmètre d’un problème rencontré en adoptant une démarche inductive
niveau 1, imiter
niveau 2, adapter
niveau 3, transposer
C4. Rechercher de façon méthodique une ou des solutions au problème rencontré
niveau 1, imiter
niveau 2, adapter
niveau 3, transposer
Afficher la totalité des compétences
