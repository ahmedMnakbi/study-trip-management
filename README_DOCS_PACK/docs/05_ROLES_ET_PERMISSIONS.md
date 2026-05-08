# Rôles et permissions

## 1. Vue générale

L’application possède trois rôles :

```text
etudiant
responsable
admin
```

Chaque rôle a accès à des pages différentes.

---

# 2. Rôle étudiant

## Objectif

L’étudiant utilise l’application pour consulter les voyages, s’inscrire et envoyer des documents.

| Action | Autorisée |
|---|---|
| Créer un compte étudiant | Oui |
| Se connecter | Oui |
| Voir les voyages validés | Oui |
| Voir les détails d’un voyage | Oui |
| S’inscrire à un voyage | Oui |
| S’inscrire deux fois au même voyage | Non |
| Voir ses inscriptions | Oui |
| Envoyer un document | Oui |
| Télécharger ses propres documents | Oui |
| Gérer les utilisateurs | Non |
| Valider les voyages | Non |
| Valider les inscriptions | Non |

---

# 3. Rôle responsable

## Objectif

Le responsable organise les voyages et gère les inscriptions liées à ses propres voyages.

| Action | Autorisée |
|---|---|
| Se connecter | Oui |
| Ajouter un voyage | Oui |
| Modifier ses propres voyages | Oui |
| Annuler ses propres voyages | Oui |
| Modifier les voyages d’un autre responsable | Non |
| Voir les inscriptions de ses voyages | Oui |
| Valider/refuser une inscription | Oui |
| Voir les documents liés à ses voyages | Oui |
| Gérer tous les utilisateurs | Non |
| Valider les voyages | Non |

---

# 4. Rôle administrateur

## Objectif

L’administrateur contrôle le système.

| Action | Autorisée |
|---|---|
| Se connecter | Oui |
| Voir le tableau de bord | Oui |
| Valider/refuser les voyages | Oui |
| Gérer les utilisateurs | Oui |
| Voir les documents | Oui |
| Créer un voyage comme responsable | Non, sauf si son rôle est responsable |
| S’inscrire comme étudiant | Non |

---

# 5. Protection des pages

Les pages sont protégées avec deux fonctions principales :

```php
require_connexion();
require_role(['admin']);
```

## `require_connexion()`

Cette fonction vérifie que l’utilisateur est connecté.

Si l’utilisateur n’est pas connecté, il est redirigé vers la page de connexion.

## `require_role()`

Cette fonction vérifie que l’utilisateur possède le bon rôle.

Exemple :

```php
require_role(['responsable']);
```

Cela signifie que seuls les responsables peuvent accéder à la page.

---

# 6. Exemples de pages protégées

| Page | Rôle requis |
|---|---|
| `pages/admin/dashboard.php` | admin |
| `pages/admin/utilisateurs.php` | admin |
| `pages/voyages/ajouter_voyage.php` | responsable |
| `pages/voyages/modifier_voyage.php` | responsable |
| `pages/inscriptions/mes_inscriptions.php` | etudiant |
| `pages/documents/upload_document.php` | etudiant |
| `pages/documents/tous_documents.php` | admin |

---

# 7. Sécurité liée aux rôles

Le contrôle du rôle est fait côté serveur en PHP.

Même si un utilisateur modifie l’URL manuellement, PHP vérifie son rôle avant d’afficher la page ou d’exécuter l’action.
