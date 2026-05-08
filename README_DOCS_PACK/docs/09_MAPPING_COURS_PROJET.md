# Correspondance entre le cours et le projet

Ce fichier montre comment les notions étudiées en cours sont utilisées dans le projet.

---

# 1. HTML/CSS

## Dans le cours

- pages HTML ;
- formulaires ;
- tableaux ;
- liens ;
- mise en forme CSS.

## Dans le projet

- formulaires de connexion ;
- formulaires d’inscription ;
- formulaires d’ajout de voyage ;
- tableaux des voyages ;
- tableaux des utilisateurs ;
- navigation selon le rôle ;
- style dans `assets/css/style.css`.

---

# 2. JavaScript

## Dans le cours

- variables ;
- conditions ;
- fonctions ;
- DOM ;
- événements ;
- validation de formulaire.

## Dans le projet

Le fichier `assets/js/validation.js` est utilisé pour vérifier les champs obligatoires, les emails, les mots de passe, les dates, les fichiers uploadés et afficher des confirmations.

---

# 3. PHP formulaires

## Dans le cours

- `$_GET` ;
- `$_POST` ;
- récupération de données ;
- traitement de formulaires.

## Dans le projet

`$_POST` est utilisé pour la connexion, l’inscription, l’ajout de voyage, la modification de voyage, la validation de voyage, l’inscription à un voyage et l’upload de document.

`$_GET` est utilisé pour afficher le détail d’un voyage, récupérer l’identifiant d’un document ou récupérer l’identifiant d’un voyage.

---

# 4. PHP POO

## Dans le cours

- classes ;
- objets ;
- attributs ;
- méthodes ;
- constructeurs ;
- encapsulation.

## Dans le projet

| Classe | Rôle |
|---|---|
| `User` | Gestion des utilisateurs |
| `Voyage` | Gestion des voyages |
| `Inscription` | Gestion des inscriptions |
| `Document` | Gestion des documents |

---

# 5. PDO/MySQL

## Dans le cours

- connexion à MySQL ;
- requêtes SQL ;
- `SELECT`, `INSERT`, `UPDATE`, `DELETE` ;
- requêtes préparées ;
- `fetch`, `fetchAll`.

## Dans le projet

PDO est utilisé pour créer un utilisateur, chercher un utilisateur, créer un voyage, modifier un voyage, valider un voyage, créer une inscription, lister les inscriptions et enregistrer les documents.

---

# 6. Sessions

## Dans le cours

- `session_start()` ;
- `$_SESSION` ;
- connexion ;
- déconnexion ;
- protection des pages.

## Dans le projet

Les sessions sont utilisées pour mémoriser l’utilisateur connecté, connaître son rôle, protéger les pages, rediriger les visiteurs non connectés et afficher une navigation différente selon le rôle.

---

# 7. Upload de fichiers

## Dans le cours

- formulaire avec `enctype="multipart/form-data"` ;
- `$_FILES` ;
- `move_uploaded_file`.

## Dans le projet

L’étudiant peut envoyer PDF, JPG, JPEG et PNG. Le projet vérifie extension, taille, type MIME et droits de l’utilisateur.

---

# 8. CRUD

CRUD signifie Create, Read, Update, Delete.

| Entité | Create | Read | Update | Delete/Cancel |
|---|---|---|---|---|
| Utilisateur | Oui | Oui | Oui | Désactivation |
| Voyage | Oui | Oui | Oui | Annulation |
| Inscription | Oui | Oui | Statut | Annulation/refus |
| Document | Oui | Oui | Statut | Non central |

---

# 9. Mini-projet avec rôles

| Mini-projet classique | Projet |
|---|---|
| Client | Étudiant |
| Gestionnaire | Responsable |
| Administrateur | Admin |
| Réservation | Inscription au voyage |
| Disponibilité | Places restantes |
| Documents/facture | Documents étudiant |
