# Plateforme de Gestion des Voyages d'Etudes - V2

Cette version V2 est volontairement alignee avec un cours classique PHP/JavaScript/MySQL. Elle utilise des pages PHP normales, des includes, des classes simples, PDO, les sessions, les formulaires `$_POST`/`$_GET`, et l'upload avec `$_FILES`.

## Installation

1. Copier le projet dans le dossier web local :
   - XAMPP : `C:\xampp\htdocs\study-trip-management`
   - WAMP : `C:\wamp64\www\study-trip-management`
2. Demarrer Apache et MySQL.
3. Creer/importer la base avec phpMyAdmin :
   - importer `database/schema.sql`
   - importer ensuite `database/seed.sql`
4. Verifier les parametres MySQL dans `config/database.php`.
5. Ouvrir :

```text
http://localhost/study-trip-management/index.php
```

Avec le serveur PHP integre :

```powershell
php -S 127.0.0.1:8000
```

Puis ouvrir :

```text
http://127.0.0.1:8000/index.php
```

## Comptes de test

Mot de passe pour tous les comptes :

```text
password
```

| Role            | Email                   |
|-----------------|-------------------------|
| Administrateur  | admin@example.com       |
| Responsable     | responsable@example.com |
| Etudiant        | etudiant@example.com    |

Les mots de passe sont stockes sous forme hashee dans `database/seed.sql`.

## Fonctionnalites

- Inscription, connexion et deconnexion.
- Sessions PHP avec role `etudiant`, `responsable` ou `admin`.
- Responsable : ajouter, modifier et annuler ses voyages.
- Admin : valider/refuser les voyages, gerer les utilisateurs, voir les statistiques.
- Etudiant : consulter les voyages valides, s'inscrire, suivre ses inscriptions, envoyer des documents.
- Documents : upload PDF/JPG/PNG avec verification extension, taille et type MIME.
- Requetes SQL preparees avec PDO.
- Protection simple CSRF sur les actions POST.

## Correspondance avec les notions du cours

| Notion etudiee  | Utilisation dans le projet                                      |
|-----------------|------------------------------------------------------------------|
| HTML/CSS        | Pages, formulaires, tableaux, navigation                         |
| JavaScript/DOM  | Validation des formulaires dans `assets/js/validation.js`         |
| PHP basics      | Conditions, tableaux, fonctions, includes                         |
| `$_GET`         | Lire les identifiants dans les pages de detail                    |
| `$_POST`        | Traiter les formulaires de connexion, inscription, validation     |
| `$_FILES`       | Upload des documents et `move_uploaded_file`                      |
| POO             | Classes `User`, `Voyage`, `Inscription`, `Document`               |
| PDO/MySQL       | CRUD et requetes preparees                                        |
| Sessions        | Authentification, role connecte, messages flash                   |
| Roles           | Pages protegees pour etudiant, responsable, admin                 |

## Tests manuels par role

### Etudiant

1. Creer un compte depuis `register.php`.
2. Se connecter.
3. Consulter les voyages valides.
4. S'inscrire a un voyage.
5. Verifier que la double inscription est bloquee.
6. Envoyer un document PDF/JPG/PNG.
7. Verifier que les fichiers invalides sont refuses.

### Responsable

1. Se connecter avec `responsable@example.com`.
2. Ajouter un voyage.
3. Modifier ce voyage.
4. Attendre la validation admin.
5. Consulter les inscriptions de ses voyages.
6. Valider/refuser une inscription.
7. Verifier que la capacite est respectee avant validation.

### Administrateur

1. Se connecter avec `admin@example.com`.
2. Ouvrir le dashboard.
3. Valider ou refuser un voyage.
4. Ajouter ou modifier un utilisateur.
5. Verifier qu'un admin ne peut pas se desactiver lui-meme.
6. Verifier que le dernier admin actif ne peut pas etre demote ou desactive.
7. Consulter les documents.

## Securite simple

- `password_hash` et `password_verify`.
- PDO avec requetes preparees.
- `htmlspecialchars` via la fonction `e()`.
- Sessions et verification des roles.
- Actions importantes en POST avec jeton CSRF.
- Upload limite a 5 Mo et formats PDF/JPG/PNG.
- `.htaccess` dans `uploads/documents` pour bloquer l'execution PHP.

## Ameliorations futures

- Module financier ou paiement, hors V2 core.
- Export PDF ou CSV.
- Pagination des grandes listes.
- Notifications email.
- Recherche plus avancee.
