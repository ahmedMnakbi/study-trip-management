# Guide de démonstration pour la soutenance

Ce fichier propose un ordre simple pour présenter le projet devant le professeur.

---

# 1. Introduction

Dire :

> Notre projet est une application web de gestion des voyages d’études. Elle permet à un responsable de proposer des voyages, à un administrateur de les valider, et aux étudiants de s’inscrire et d’envoyer leurs documents.

Ensuite préciser :

> La version V2 a été simplifiée pour correspondre aux notions étudiées en cours : PHP, MySQL, PDO, sessions, formulaires, POO, JavaScript et upload de fichiers.

---

# 2. Présenter la structure

Montrer rapidement les dossiers :

```text
classes/
includes/
pages/
database/
assets/
uploads/
```

Dire :

> Les classes contiennent la logique métier, les pages contiennent les formulaires et traitements, les includes contiennent les fonctions communes, et database contient les fichiers SQL.

---

# 3. Présenter la base de données

Ouvrir phpMyAdmin et montrer les tables :

```text
users
voyages
inscriptions
documents
```

Expliquer :

- `users` : utilisateurs et rôles ;
- `voyages` : voyages d’études ;
- `inscriptions` : inscriptions des étudiants ;
- `documents` : documents envoyés.

---

# 4. Démonstration avec responsable

## Connexion

Compte :

```text
responsable@example.com
password
```

## Actions

1. Aller à “Mes voyages”.
2. Ajouter un voyage.
3. Remplir le formulaire.
4. Montrer que le voyage est créé avec statut `en_attente`.
5. Modifier le voyage.

## Explication

Dire :

> Ici, on utilise un formulaire HTML envoyé avec `POST`. PHP récupère les données, puis la classe `Voyage` exécute une requête PDO pour insérer le voyage dans MySQL.

---

# 5. Démonstration avec administrateur

## Connexion

Compte :

```text
admin@example.com
password
```

## Actions

1. Ouvrir le tableau de bord.
2. Aller à la validation des voyages.
3. Valider le voyage créé par le responsable.

## Explication

Dire :

> L’administrateur change le statut du voyage de `en_attente` à `valide`. Après cette validation, le voyage devient visible pour les étudiants.

---

# 6. Démonstration avec étudiant

## Connexion

Compte :

```text
etudiant@example.com
password
```

## Actions

1. Consulter les voyages validés.
2. Ouvrir le détail d’un voyage.
3. S’inscrire au voyage.
4. Essayer de s’inscrire une deuxième fois.

## Explication

Dire :

> Le système empêche la double inscription grâce à une vérification PHP et à une contrainte unique dans la base de données.

---

# 7. Démonstration validation inscription

Revenir avec le responsable.

## Actions

1. Ouvrir les inscriptions du voyage.
2. Valider ou refuser l’inscription de l’étudiant.

## Explication

Dire :

> Avant de valider une inscription, le système vérifie encore une fois le nombre de places restantes.

---

# 8. Démonstration upload

Revenir avec l’étudiant.

## Actions

1. Aller dans les documents.
2. Envoyer un fichier PDF ou image.
3. Tester un fichier invalide si nécessaire.

## Explication

Dire :

> Le projet utilise `$_FILES` et `move_uploaded_file`. PHP vérifie l’extension, la taille et le type MIME du fichier avant de l’enregistrer.

---

# 9. Montrer la sécurité simple

| Protection | Utilisation |
|---|---|
| `password_hash` | Mots de passe hashés |
| PDO préparé | Protection contre injection SQL |
| Sessions | Connexion et rôles |
| `htmlspecialchars` | Échappement HTML |
| CSRF | Protection des actions POST |
| Upload validation | Protection des fichiers envoyés |

---

# 10. Conclusion

Dire :

> Ce projet regroupe les notions principales du module : HTML/CSS, JavaScript, PHP, formulaires, sessions, POO, PDO/MySQL, CRUD et upload de fichiers. La version V2 a été volontairement simplifiée pour être claire, compréhensible et proche des exercices étudiés en classe.
