# Sécurité et validation

## 1. Objectif

Même si ce projet est académique, plusieurs protections simples sont utilisées pour éviter les erreurs et les abus.

---

# 2. Mots de passe hashés

Les mots de passe ne sont pas stockés en clair.

Lors de la création d’un utilisateur, PHP utilise :

```php
password_hash()
```

Lors de la connexion, PHP utilise :

```php
password_verify()
```

Cela permet de vérifier le mot de passe sans le stocker directement.

---

# 3. Requêtes préparées PDO

Le projet utilise PDO avec des requêtes préparées.

Exemple logique :

```php
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
```

Cela protège contre les injections SQL.

---

# 4. Sessions

Après la connexion, les informations de l’utilisateur sont stockées dans :

```php
$_SESSION['user']
```

Exemples d’informations stockées : identifiant, nom, prénom, email, rôle.

---

# 5. Protection des pages

Les pages sensibles utilisent :

```php
require_connexion();
require_role(['admin']);
```

Cela permet d’empêcher les visiteurs non connectés et les utilisateurs avec un mauvais rôle.

---

# 6. Échappement HTML

Pour afficher des données venant de la base, le projet utilise une fonction :

```php
e($valeur)
```

Cette fonction utilise `htmlspecialchars`.

Elle évite l’affichage dangereux de code HTML ou JavaScript injecté.

---

# 7. Protection CSRF

Les actions importantes utilisent un jeton CSRF.

Exemples d’actions protégées :

- déconnexion ;
- ajout de voyage ;
- modification de voyage ;
- validation de voyage ;
- inscription ;
- validation d’inscription ;
- upload de document ;
- modification d’utilisateur.

## Principe

1. PHP génère un jeton.
2. Le formulaire contient ce jeton dans un champ caché.
3. Lors de l’envoi, PHP vérifie que le jeton est correct.

Cela évite qu’un autre site envoie un formulaire à la place de l’utilisateur.

---

# 8. Upload sécurisé

Lorsqu’un étudiant envoie un document, PHP vérifie :

- que le fichier existe ;
- qu’il n’y a pas d’erreur d’upload ;
- que l’extension est acceptée ;
- que la taille est limitée ;
- que le type MIME est accepté ;
- que l’étudiant est inscrit au voyage.

## Extensions acceptées

```text
pdf
jpg
jpeg
png
```

## Taille maximale

```text
5 MB
```

## Types MIME acceptés

```text
application/pdf
image/jpeg
image/png
```

Le fichier est renommé automatiquement pour éviter les conflits et les noms dangereux.

---

# 9. Téléchargement sécurisé

Les fichiers ne sont pas téléchargés directement avec un lien vers `uploads/documents`.

Le téléchargement passe par une page PHP :

```text
pages/documents/telecharger_document.php?id=...
```

Cette page vérifie :

- que l’utilisateur est connecté ;
- qu’il a le droit de télécharger le document ;
- que le fichier existe ;
- que le chemin reste dans le dossier `uploads/documents`.

---

# 10. Protection du dossier uploads

Le dossier `uploads/documents` contient un fichier `.htaccess`.

Il sert à empêcher l’affichage du contenu du dossier et l’exécution de fichiers PHP dans le dossier d’upload.

---

# 11. Validation JavaScript et PHP

Le projet utilise JavaScript pour aider l’utilisateur avant l’envoi du formulaire.

Mais la validation importante est aussi faite en PHP.

Pourquoi ? Parce que JavaScript peut être désactivé ou contourné. Le serveur doit toujours vérifier les données.
