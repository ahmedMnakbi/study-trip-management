# Base de données

## 1. Vue générale

La base de données contient quatre tables principales :

```text
users
voyages
inscriptions
documents
```

La version V2 ne contient pas de module financier actif. La table `paiements` et le rôle `financier` ont été retirés pour simplifier le projet.

---

# 2. Table `users`

Cette table contient tous les utilisateurs.

| Colonne | Rôle |
|---|---|
| `id_user` | Identifiant unique |
| `nom` | Nom de l’utilisateur |
| `prenom` | Prénom de l’utilisateur |
| `email` | Email unique |
| `mot_de_passe` | Mot de passe hashé |
| `role` | Rôle de l’utilisateur |
| `statut` | Compte actif ou inactif |
| `date_creation` | Date de création |

## Rôles possibles

| Rôle | Signification |
|---|---|
| `etudiant` | Étudiant |
| `responsable` | Responsable de voyage |
| `admin` | Administrateur |

## Statuts possibles

| Statut | Signification |
|---|---|
| `actif` | L’utilisateur peut se connecter |
| `inactif` | L’utilisateur ne peut pas se connecter |

---

# 3. Table `voyages`

Cette table contient les voyages d’études.

| Colonne | Rôle |
|---|---|
| `id_voyage` | Identifiant unique |
| `titre` | Titre du voyage |
| `destination` | Destination |
| `description` | Description |
| `date_depart` | Date de départ |
| `date_retour` | Date de retour |
| `budget` | Budget du voyage |
| `nb_places` | Nombre de places |
| `statut` | État du voyage |
| `id_responsable` | Responsable qui a créé le voyage |

## Statuts possibles

| Statut | Signification |
|---|---|
| `en_attente` | En attente de validation admin |
| `valide` | Validé et visible pour les étudiants |
| `refuse` | Refusé par l’administrateur |
| `annule` | Annulé |

---

# 4. Table `inscriptions`

Cette table relie les étudiants aux voyages.

| Colonne | Rôle |
|---|---|
| `id_inscription` | Identifiant unique |
| `id_user` | Étudiant inscrit |
| `id_voyage` | Voyage choisi |
| `date_inscription` | Date d’inscription |
| `statut` | État de l’inscription |

## Contrainte importante

```sql
UNIQUE(id_user, id_voyage)
```

Cette contrainte empêche un même étudiant de s’inscrire plusieurs fois au même voyage.

## Statuts possibles

| Statut | Signification |
|---|---|
| `en_attente` | Inscription en attente |
| `valide` | Inscription acceptée |
| `refuse` | Inscription refusée |
| `annule` | Inscription annulée |

---

# 5. Table `documents`

Cette table contient les informations des documents envoyés par les étudiants.

| Colonne | Rôle |
|---|---|
| `id_document` | Identifiant unique |
| `id_user` | Étudiant propriétaire |
| `id_voyage` | Voyage concerné |
| `type_document` | Type de document |
| `nom_original` | Nom original du fichier |
| `chemin_fichier` | Chemin du fichier stocké |
| `statut` | Statut du document |
| `date_upload` | Date d’envoi |

## Statuts possibles

| Statut | Signification |
|---|---|
| `en_attente` | Document envoyé |
| `valide` | Document accepté |
| `refuse` | Document refusé |

---

# 6. Relations entre les tables

| Relation | Explication |
|---|---|
| `users.id_user → voyages.id_responsable` | Un responsable peut créer plusieurs voyages |
| `users.id_user → inscriptions.id_user` | Un étudiant peut avoir plusieurs inscriptions |
| `voyages.id_voyage → inscriptions.id_voyage` | Un voyage peut avoir plusieurs inscriptions |
| `users.id_user → documents.id_user` | Un étudiant peut envoyer plusieurs documents |
| `voyages.id_voyage → documents.id_voyage` | Un document peut être lié à un voyage |

---

# 7. Données de test

| Rôle | Email | Mot de passe |
|---|---|---|
| Administrateur | `admin@example.com` | `password` |
| Responsable | `responsable@example.com` | `password` |
| Étudiant | `etudiant@example.com` | `password` |

Les mots de passe sont stockés sous forme hashée dans la base.
