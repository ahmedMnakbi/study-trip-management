# Study Trip Management System - V2

Application web academique de gestion des voyages d'etudes, realisee en PHP, JavaScript et MySQL avec une structure volontairement simple et proche des notions etudiees en cours.

Cette branche `v2-course-aligned` remplace l'ancienne organisation MVC par des pages PHP classiques, des includes, des classes simples, PDO, les sessions et des formulaires HTML.

## Apercu Du Projet

Le systeme gere trois roles principaux :

| Role | Fonction principale |
|---|---|
| Etudiant | Consulter les voyages valides, s'inscrire, envoyer des documents |
| Responsable | Proposer et modifier ses voyages, gerer les inscriptions |
| Administrateur | Valider les voyages, gerer les utilisateurs, consulter les statistiques |

Flux principal :

1. Le responsable cree un voyage.
2. L'administrateur valide ou refuse le voyage.
3. L'etudiant consulte les voyages valides.
4. L'etudiant s'inscrit a un voyage.
5. Le responsable valide ou refuse l'inscription.
6. L'etudiant envoie les documents demandes.

## Pourquoi Cette V2

La V2 est concue pour etre facile a expliquer en soutenance :

- pas de Laravel, Symfony, Composer, namespaces ou autoloading ;
- pas de router avance ni architecture REST ;
- pages PHP normales avec `$_GET`, `$_POST` et `$_FILES` ;
- classes simples : `User`, `Voyage`, `Inscription`, `Document` ;
- PDO et requetes preparees ;
- sessions PHP pour l'authentification et les roles ;
- JavaScript simple pour la validation des formulaires.

Phrase de presentation :

> Ce projet utilise les notions etudiees en classe : JavaScript pour la validation des formulaires, PHP pour le traitement des formulaires, PDO pour communiquer avec MySQL, la POO avec les classes principales, les sessions pour l'authentification, et l'upload de fichiers pour les documents.

## Structure

```text
config/                 Connexion PDO
classes/                Classes PHP simples
includes/               Header, footer, auth, fonctions communes
pages/auth/             Connexion, inscription, deconnexion
pages/voyages/          Voyages et validation admin
pages/inscriptions/     Inscriptions et changement de statut
pages/documents/        Upload et telechargement securise
pages/admin/            Dashboard et gestion utilisateurs
assets/css/             Style CSS
assets/js/              Validation JavaScript
database/               Schema SQL et donnees de test
uploads/documents/      Documents uploades
README_DOCS_PACK/       Documentation detaillee du projet
```

## Documentation Complete

Un pack de documentation a ete ajoute dans `README_DOCS_PACK/`.

Lecture conseillee :

| Fichier | Contenu |
|---|---|
| `README_DOCS_PACK/docs/01_PRESENTATION_PROJET.md` | Presentation generale |
| `README_DOCS_PACK/docs/02_STRUCTURE_DU_PROJET.md` | Organisation des fichiers |
| `README_DOCS_PACK/docs/03_WORKFLOWS.md` | Scenarios et workflows |
| `README_DOCS_PACK/docs/04_BASE_DE_DONNEES.md` | Tables et relations |
| `README_DOCS_PACK/docs/05_ROLES_ET_PERMISSIONS.md` | Roles et permissions |
| `README_DOCS_PACK/docs/06_SECURITE_ET_VALIDATION.md` | Securite et validations |
| `README_DOCS_PACK/docs/07_INSTALLATION_ET_UTILISATION.md` | Installation et lancement |
| `README_DOCS_PACK/docs/08_GUIDE_DEMO_SOUTENANCE.md` | Guide de demonstration |
| `README_DOCS_PACK/docs/09_MAPPING_COURS_PROJET.md` | Mapping cours/projet |
| `README_DOCS_PACK/docs/10_CHECKLIST_TESTS_MANUELS.md` | Checklist de tests |

## Installation Rapide

1. Copier le projet dans le dossier web local :
   - XAMPP : `C:\xampp\htdocs\study-trip-management`
   - WAMP : `C:\wamp64\www\study-trip-management`
2. Demarrer Apache et MySQL.
3. Importer la base :
   - `database/schema.sql`
   - puis `database/seed.sql`
4. Verifier `config/database.php`.
5. Ouvrir :

```text
http://localhost/study-trip-management/index.php
```

Avec le serveur PHP integre :

```powershell
php -S 127.0.0.1:8000 -t .
```

Puis ouvrir :

```text
http://127.0.0.1:8000/index.php
```

## Comptes De Test

Mot de passe pour tous les comptes :

```text
password
```

| Role | Email |
|---|---|
| Administrateur | `admin@example.com` |
| Responsable | `responsable@example.com` |
| Etudiant | `etudiant@example.com` |

Les mots de passe sont stockes sous forme hashee dans `database/seed.sql`.

## Fonctionnalites

### Authentification

- inscription etudiante ;
- connexion/deconnexion ;
- sessions avec role stocke ;
- pages protegees selon le role.

### Voyages

- responsable : ajouter, modifier, annuler ses voyages ;
- administrateur : valider ou refuser les voyages ;
- etudiant : consulter uniquement les voyages valides.

### Inscriptions

- inscription a un voyage valide ;
- blocage des doublons ;
- controle du nombre de places ;
- validation/refus par le responsable.

### Documents

- upload par l'etudiant ;
- verification extension, taille et type MIME ;
- renommage du fichier ;
- telechargement via une page PHP securisee ;
- acces limite selon le role.

### Administration

- gestion des utilisateurs ;
- protection du dernier administrateur actif ;
- dashboard avec statistiques simples.

## Correspondance Avec Le Cours

| Notion etudiee | Utilisation dans le projet |
|---|---|
| HTML/CSS | Pages, formulaires, tableaux, navigation |
| JavaScript/DOM | Validation des formulaires dans `assets/js/validation.js` |
| PHP basics | Conditions, tableaux, fonctions, includes |
| `$_GET` | Recuperation des identifiants dans les URL |
| `$_POST` | Traitement des formulaires |
| `$_FILES` | Upload des documents |
| POO PHP | Classes `User`, `Voyage`, `Inscription`, `Document` |
| PDO/MySQL | CRUD et requetes preparees |
| Sessions | Connexion, deconnexion, roles |
| Roles | Espaces etudiant, responsable, administrateur |

## Securite Simple

- `password_hash` et `password_verify` ;
- requetes preparees PDO ;
- echappement avec `htmlspecialchars` via `e()` ;
- actions importantes en POST ;
- jeton CSRF simple ;
- upload limite aux formats PDF/JPG/PNG ;
- `.htaccess` pour bloquer l'execution PHP dans `uploads/documents`.

## Tests Manuels Recommandes

1. Responsable : creer puis modifier un voyage.
2. Admin : valider ce voyage.
3. Etudiant : consulter, s'inscrire, tester le doublon.
4. Responsable : valider/refuser l'inscription.
5. Etudiant : uploader un document valide puis tester un fichier invalide.
6. Admin : verifier le dashboard et la gestion utilisateurs.

Voir aussi `CHECKLIST_MANUELLE.md` et `README_DOCS_PACK/docs/10_CHECKLIST_TESTS_MANUELS.md`.

## Ameliorations Futures

- module financier ou paiement, hors V2 core ;
- export PDF ou CSV ;
- pagination des grandes listes ;
- notifications email ;
- recherche plus avancee.
