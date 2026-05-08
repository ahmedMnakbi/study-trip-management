# Structure du projet

## 1. Structure générale

Le projet est organisé de façon simple pour faciliter la compréhension.

```text
study-trip-management/
│
├── assets/
│   ├── css/
│   └── js/
│
├── classes/
│   ├── User.php
│   ├── Voyage.php
│   ├── Inscription.php
│   └── Document.php
│
├── config/
│   └── database.php
│
├── database/
│   ├── schema.sql
│   └── seed.sql
│
├── includes/
│   ├── auth.php
│   ├── functions.php
│   ├── header.php
│   └── footer.php
│
├── pages/
│   ├── auth/
│   ├── voyages/
│   ├── inscriptions/
│   ├── documents/
│   └── admin/
│
├── uploads/
│   └── documents/
│
└── index.php
```

---

## 2. Rôle de chaque dossier

### `assets/`

Ce dossier contient les fichiers statiques.

- `assets/css/style.css` : style de l’interface.
- `assets/js/validation.js` : validation JavaScript des formulaires.

### `classes/`

Ce dossier contient les classes PHP principales du projet.

| Classe | Rôle |
|---|---|
| `User.php` | Gestion des utilisateurs |
| `Voyage.php` | Gestion des voyages |
| `Inscription.php` | Gestion des inscriptions |
| `Document.php` | Gestion des documents |

Ces classes représentent la partie POO du projet.

### `config/`

Contient la configuration de la base de données.

- `database.php` crée la connexion PDO avec MySQL.

### `database/`

Contient les fichiers SQL.

- `schema.sql` : création des tables.
- `seed.sql` : données de test et comptes de démonstration.

### `includes/`

Contient les fichiers réutilisables.

| Fichier | Rôle |
|---|---|
| `functions.php` | Fonctions communes : redirection, messages, CSRF, échappement |
| `auth.php` | Sessions, utilisateur connecté, vérification des rôles |
| `header.php` | En-tête HTML et navigation |
| `footer.php` | Pied de page et scripts |

### `pages/`

Contient les pages principales de l’application.

| Dossier | Rôle |
|---|---|
| `pages/auth/` | Connexion, inscription, déconnexion |
| `pages/voyages/` | Gestion et consultation des voyages |
| `pages/inscriptions/` | Inscription des étudiants et validation |
| `pages/documents/` | Upload et téléchargement des documents |
| `pages/admin/` | Tableau de bord et gestion des utilisateurs |

### `uploads/documents/`

Contient les fichiers envoyés par les étudiants.

Les fichiers ne sont pas téléchargés directement par lien brut. Le téléchargement passe par une page PHP qui vérifie les droits d’accès.

---

## 3. Rôle de `index.php`

`index.php` est le point d’entrée du projet.

Il redirige l’utilisateur selon son rôle :

- administrateur → tableau de bord ;
- responsable → ses voyages ;
- étudiant ou visiteur → liste des voyages validés.

---

## 4. Pourquoi cette structure est simple

Cette structure est adaptée au cours parce qu’elle montre clairement :

- les pages PHP ;
- les formulaires ;
- les traitements `POST` ;
- les classes PHP ;
- les requêtes PDO ;
- les sessions ;
- les inclusions de fichiers.

Elle est plus facile à expliquer qu’une architecture MVC avancée.
