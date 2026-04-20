# Scenario de Demonstration

Ce scenario sert a presenter le projet simplement, sans entrer dans des details trop avances.

## Preparation

1. Lancer MySQL/MariaDB avec XAMPP.
2. Lancer le serveur PHP :

   ```powershell
   & 'C:\xampp\php\php.exe' -S 127.0.0.1:8000 -t .
   ```

3. Ouvrir :

   ```text
   http://127.0.0.1:8000/public/index.php
   ```

## Comptes

Mot de passe pour tous les comptes :

```text
password
```

| Role | Email |
| --- | --- |
| Administrateur | admin@example.com |
| Responsable pedagogique | responsable@example.com |
| Etudiant | etudiant@example.com |

## Demo en 8 minutes

### 1. Presenter le probleme

Expliquer que les voyages d'etudes sont souvent geres avec Excel, emails ou papier. Le but du projet est de centraliser la creation, la validation, les inscriptions et les documents.

### 2. Montrer l'espace responsable

1. Se connecter avec `responsable@example.com`.
2. Ouvrir **Espace responsable**.
3. Creer un voyage simple :
   - Titre : `Visite laboratoire`
   - Destination : `Tunis`
   - Dates futures
   - Places : `20`
   - Budget : `50`
4. Expliquer que le voyage reste en attente de validation.

### 3. Montrer l'espace administrateur

1. Se deconnecter.
2. Se connecter avec `admin@example.com`.
3. Ouvrir **Validation voyages**.
4. Valider le voyage cree.
5. Ouvrir le **Dashboard** pour montrer les statistiques simples.

### 4. Montrer l'espace etudiant

1. Se deconnecter.
2. Se connecter avec `etudiant@example.com`.
3. Ouvrir **Voyages**.
4. Afficher les details du voyage valide.
5. Cliquer sur **S'inscrire**.
6. Ouvrir **Mes inscriptions**.
7. Deposer un document PDF ou image.

### 5. Revenir au responsable

1. Se connecter avec `responsable@example.com`.
2. Ouvrir le voyage.
3. Consulter les inscriptions.
4. Verifier le document depose.
5. Valider ou refuser l'inscription.

### 6. Conclure

Dire que la version actuelle est volontairement simple : elle couvre le coeur du cahier de charge sans ajouter des modules trop avances comme paiement en ligne, messagerie ou application mobile.

## Points techniques a expliquer

- Le projet utilise PHP sans framework.
- Les pages HTML sont dans `app/views`.
- Les donnees sont stockees dans MySQL/MariaDB.
- Les mots de passe sont hashes.
- Les requetes SQL utilisent PDO et des requetes preparees.
- Les roles controlent l'acces aux pages.
- Les formulaires sensibles utilisent un jeton CSRF.

## Questions possibles

### Pourquoi utiliser des fichiers `.php` au lieu de `.html` ?

Parce que les pages doivent afficher des donnees dynamiques depuis la base : voyages, inscriptions, utilisateurs et documents.

### Pourquoi un administrateur doit valider un voyage ?

Pour respecter la regle metier du cahier de charge : un responsable propose un voyage, mais la publication depend de l'administration.

### Pourquoi ne pas ajouter le paiement en ligne ?

Le paiement en ligne est indique comme hors perimetre de la premiere version. Il est garde comme perspective d'evolution.
