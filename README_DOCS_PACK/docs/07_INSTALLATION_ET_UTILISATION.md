# Installation et utilisation

## 1. Prérequis

Pour lancer le projet, il faut :

- PHP ;
- MySQL ou MariaDB ;
- Apache, XAMPP ou WAMP ;
- phpMyAdmin, optionnel mais pratique ;
- un navigateur web.

---

# 2. Installation avec XAMPP

## Étape 1 : Copier le projet

Copier le dossier du projet dans :

```text
C:\xampp\htdocs\
```

Exemple :

```text
C:\xampp\htdocs\study-trip-management
```

## Étape 2 : Démarrer XAMPP

Ouvrir XAMPP Control Panel puis démarrer Apache et MySQL.

## Étape 3 : Ouvrir phpMyAdmin

Dans le navigateur :

```text
http://localhost/phpmyadmin
```

## Étape 4 : Importer la base de données

Dans phpMyAdmin :

1. créer une base si nécessaire ;
2. importer `database/schema.sql` ;
3. importer `database/seed.sql`.

## Étape 5 : Vérifier la configuration

Ouvrir :

```text
config/database.php
```

Vérifier le nom de la base, l’utilisateur MySQL et le mot de passe MySQL.

Avec XAMPP, souvent :

```text
utilisateur : root
mot de passe : vide
```

## Étape 6 : Lancer l’application

Dans le navigateur :

```text
http://localhost/study-trip-management/index.php
```

---

# 3. Installation avec le serveur PHP intégré

Depuis le dossier du projet :

```bash
php -S 127.0.0.1:8000 -t .
```

Puis ouvrir :

```text
http://127.0.0.1:8000/index.php
```

---

# 4. Comptes de test

| Rôle | Email | Mot de passe |
|---|---|---|
| Administrateur | `admin@example.com` | `password` |
| Responsable | `responsable@example.com` | `password` |
| Étudiant | `etudiant@example.com` | `password` |

---

# 5. Scénario rapide de test

## Responsable

1. se connecter avec `responsable@example.com` ;
2. ajouter un voyage ;
3. modifier le voyage ;
4. vérifier que le statut est `en_attente`.

## Administrateur

1. se connecter avec `admin@example.com` ;
2. ouvrir la page de validation des voyages ;
3. valider le voyage.

## Étudiant

1. se connecter avec `etudiant@example.com` ;
2. consulter les voyages validés ;
3. ouvrir le détail du voyage ;
4. s’inscrire ;
5. essayer de s’inscrire une deuxième fois ;
6. vérifier que le doublon est bloqué.

## Responsable

1. retourner avec le compte responsable ;
2. consulter les inscriptions du voyage ;
3. valider ou refuser l’inscription.

## Étudiant

1. envoyer un document ;
2. tester un fichier invalide ;
3. vérifier que l’upload invalide est refusé.

---

# 6. Problèmes fréquents

## Erreur de connexion à la base

Vérifier : Apache est démarré, MySQL est démarré, le nom de la base est correct, l’utilisateur et le mot de passe sont corrects.

## Page introuvable

Vérifier que le projet est bien dans :

```text
C:\xampp\htdocs\study-trip-management
```

## CSS ou JS ne se charge pas

Vérifier la fonction `url()` ou la valeur de base URL dans les fichiers du projet.
