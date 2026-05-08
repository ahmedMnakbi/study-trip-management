# Présentation du projet — Gestion des voyages d’études

## 1. Idée générale

Ce projet est une application web de **gestion des voyages d’études** réalisée avec les notions étudiées en cours de développement web.

L’application permet de gérer :

- les utilisateurs ;
- les voyages d’études ;
- les inscriptions des étudiants ;
- les documents envoyés par les étudiants ;
- la validation des voyages par l’administrateur ;
- la validation des inscriptions par le responsable.

Le projet utilise une architecture volontairement simple et adaptée au cours :

- pages PHP classiques ;
- fichiers `include` ;
- classes PHP simples ;
- base de données MySQL ;
- accès à la base avec PDO ;
- sessions PHP ;
- formulaires avec `$_POST` et `$_GET` ;
- upload avec `$_FILES` ;
- validation JavaScript côté client.

Le projet ne repose pas sur un framework comme Laravel ou Symfony. L’objectif est de montrer clairement les notions étudiées en classe.

---

## 2. Objectif du projet

L’objectif principal est de faciliter l’organisation des voyages d’études dans un établissement.

Le système permet :

1. à un **responsable** de proposer un voyage ;
2. à un **administrateur** de valider ou refuser ce voyage ;
3. à un **étudiant** de consulter les voyages validés ;
4. à l’étudiant de s’inscrire à un voyage ;
5. au responsable de valider ou refuser les inscriptions ;
6. à l’étudiant d’envoyer des documents nécessaires ;
7. à l’administrateur de gérer les utilisateurs et consulter les statistiques.

---

## 3. Les rôles de l’application

### Étudiant

L’étudiant peut :

- créer un compte ;
- se connecter ;
- consulter les voyages validés ;
- voir les détails d’un voyage ;
- s’inscrire à un voyage ;
- consulter ses inscriptions ;
- envoyer des documents ;
- télécharger ses propres documents.

### Responsable

Le responsable peut :

- se connecter ;
- ajouter un voyage ;
- modifier ses propres voyages ;
- annuler ses propres voyages ;
- consulter les inscriptions liées à ses voyages ;
- valider ou refuser les inscriptions ;
- consulter les documents liés à ses voyages.

### Administrateur

L’administrateur peut :

- se connecter ;
- consulter le tableau de bord ;
- valider ou refuser les voyages ;
- gérer les utilisateurs ;
- consulter les documents ;
- consulter des statistiques globales.

---

## 4. Technologies utilisées

| Technologie | Utilisation |
|---|---|
| HTML | Structure des pages |
| CSS | Mise en forme de l’interface |
| JavaScript | Validation des formulaires |
| PHP | Traitement des pages et formulaires |
| MySQL | Stockage des données |
| PDO | Connexion et requêtes SQL préparées |
| Sessions PHP | Authentification et rôles |
| `$_POST` | Envoi des formulaires |
| `$_GET` | Récupération d’identifiants dans l’URL |
| `$_FILES` | Upload des documents |
| POO PHP | Classes `User`, `Voyage`, `Inscription`, `Document` |

---

## 5. Pourquoi cette version est adaptée au cours

La version V2 du projet a été simplifiée pour correspondre aux notions étudiées.

Au lieu d’une architecture MVC complexe, le projet utilise :

- des pages PHP simples ;
- des classes compréhensibles ;
- des fonctions réutilisables ;
- des formulaires classiques ;
- des requêtes PDO ;
- des sessions.

Cette organisation permet de mieux expliquer le code pendant la présentation.

---

## 6. Résumé court pour la soutenance

> Ce projet est une plateforme de gestion des voyages d’études. Il utilise PHP, MySQL, PDO, les sessions, la POO, JavaScript et l’upload de fichiers. Il contient trois rôles : étudiant, responsable et administrateur. L’étudiant peut consulter les voyages et s’inscrire, le responsable peut gérer ses voyages et les inscriptions, et l’administrateur valide les voyages et gère les utilisateurs.
