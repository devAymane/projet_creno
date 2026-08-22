# Créno — Application Laravel de prise de rendez-vous

Créno est une application web de prise de rendez-vous développée avec **Laravel**, **Blade** et **MySQL**.

L'application permet aux clients de consulter les créneaux disponibles, de réserver un rendez-vous et de gérer leurs réservations. Un espace administrateur permet également de gérer les créneaux disponibles et de consulter les rendez-vous.

Le projet met particulièrement l'accent sur la **sécurité**, la **gestion des rôles**, la **validation des données** et les **tests PHPUnit** afin de garantir le bon fonctionnement des principales règles métier.

## 🎯 Objectif du projet

L'objectif de Créno est de proposer une solution simple permettant de remplacer une gestion traditionnelle des rendez-vous par téléphone ou sur papier.

L'application permet notamment de :

- Centraliser les créneaux disponibles.
- Permettre aux clients de réserver en ligne.
- Éviter les doubles réservations.
- Empêcher les chevauchements de rendez-vous.
- Permettre aux clients de gérer leurs propres rendez-vous.
- Permettre à l'administrateur de gérer le planning.
- Sécuriser les fonctionnalités selon le rôle de l'utilisateur.
- Vérifier les règles métier grâce aux tests automatisés.

## 🚀 Fonctionnalités

### 👤 Authentification

- Inscription d'un nouvel utilisateur.
- Connexion.
- Déconnexion.
- Protection des pages nécessitant une authentification.

### 👨‍💼 Client

Un client authentifié peut :

- Consulter les créneaux disponibles.
- Voir les informations d'un créneau.
- Réserver un créneau.
- Consulter la liste de ses rendez-vous.
- Consulter le statut de ses rendez-vous.
- Annuler ses propres rendez-vous.

### 🛠️ Administrateur

L'administrateur dispose d'un espace protégé permettant de :

- Accéder au dashboard.
- Consulter les rendez-vous.
- Consulter les créneaux.
- Créer un nouveau créneau.
- Modifier un créneau existant.
- Supprimer un créneau.
- Gérer le planning.

### 🧪 Tests

Le projet contient des tests permettant de vérifier :

- La disponibilité des créneaux.
- Les créneaux passés.
- Les doubles réservations.
- Les chevauchements de rendez-vous.
- La validation des données.
- Les autorisations des utilisateurs.
- L'annulation des rendez-vous.
- Les principales règles métier.

## 📐 Règles de gestion

L'application respecte plusieurs règles métier :

- Un utilisateur doit être authentifié pour réserver un rendez-vous.
- Deux rôles sont disponibles : `client` et `admin`.
- Seul l'administrateur peut créer, modifier ou supprimer les créneaux.
- Un même créneau ne peut pas être réservé par plusieurs clients.
- Un client ne peut pas réserver deux rendez-vous qui se chevauchent.
- Un client ne peut annuler que ses propres rendez-vous.
- Un créneau passé ne peut plus être réservé.
- Chaque rendez-vous possède un statut.
- Les règles métier principales sont vérifiées avec PHPUnit.

## 🛠️ Technologies

- **PHP** — Langage backend
- **Laravel** — Framework PHP
- **Blade** — Moteur de templates
- **MySQL** — Base de données
- **Eloquent ORM** — Gestion des données et relations
- **Laravel Breeze** — Authentification
- **Tailwind CSS** — Interface utilisateur
- **PHPUnit** — Tests automatisés
- **Git / GitHub** — Gestion de versions

## 🏗️ Architecture

Le projet suit l'architecture **MVC (Model - View - Controller)** de Laravel.

Les principales parties de l'application sont :

```text
app/
├── Http/
│   ├── Controllers/
│   ├── Middleware/
│   └── Requests/
│
└── Models/

resources/
└── views/

database/
├── factories/
├── migrations/
└── seeders/

tests/
├── Feature/
└── Unit/