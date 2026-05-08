# Workflows principaux du projet

Ce fichier explique les scénarios importants de l’application.

---

# 1. Workflow global

```text
Responsable crée un voyage
        ↓
Administrateur valide le voyage
        ↓
Étudiant consulte le voyage validé
        ↓
Étudiant s’inscrit au voyage
        ↓
Responsable valide ou refuse l’inscription
        ↓
Étudiant envoie ses documents
        ↓
Responsable/Admin consulte les documents
```

---

# 2. Workflow : création d’un voyage

## Acteur

Responsable

## Étapes

1. Le responsable se connecte.
2. Il ouvre la page de ses voyages.
3. Il clique sur “Ajouter un voyage”.
4. Il remplit le formulaire : titre, destination, description, dates, budget, nombre de places.
5. Le formulaire est envoyé avec `POST`.
6. PHP vérifie les données.
7. La classe `Voyage` ajoute le voyage dans la base avec le statut `en_attente`.
8. Le voyage attend la validation de l’administrateur.

## Notions utilisées

- formulaire HTML ;
- `$_POST` ;
- validation PHP ;
- PDO `INSERT` ;
- sessions ;
- rôle responsable ;
- classe `Voyage`.

---

# 3. Workflow : validation d’un voyage

## Acteur

Administrateur

## Étapes

1. L’administrateur se connecte.
2. Il ouvre la page de validation des voyages.
3. Il voit les voyages en attente.
4. Il choisit de valider, refuser ou annuler.
5. L’action est envoyée avec `POST`.
6. Le jeton CSRF est vérifié.
7. La classe `Voyage` change le statut du voyage.
8. Si le voyage devient `valide`, il devient visible pour les étudiants.

## Notions utilisées

- rôle administrateur ;
- `POST` ;
- CSRF ;
- PDO `UPDATE` ;
- statut métier ;
- contrôle d’accès.

---

# 4. Workflow : inscription d’un étudiant

## Acteur

Étudiant

## Étapes

1. L’étudiant se connecte.
2. Il consulte la liste des voyages validés.
3. Il ouvre les détails d’un voyage.
4. Il clique sur “S’inscrire”.
5. PHP vérifie : rôle étudiant, requête `POST`, CSRF, voyage existant et validé, absence de double inscription, places disponibles.
6. Si tout est correct, une inscription est créée.
7. L’inscription est au statut `en_attente`.

## Notions utilisées

- sessions ;
- rôles ;
- `POST` ;
- CSRF ;
- conditions PHP ;
- PDO `SELECT` et `INSERT` ;
- contrainte `UNIQUE(id_user, id_voyage)`.

---

# 5. Workflow : validation d’une inscription

## Acteur

Responsable

## Étapes

1. Le responsable se connecte.
2. Il ouvre les inscriptions d’un de ses voyages.
3. Il voit les étudiants inscrits.
4. Il choisit de valider ou refuser une inscription.
5. PHP vérifie : rôle responsable, propriété du voyage, requête `POST`, CSRF, places restantes.
6. Le statut de l’inscription est mis à jour.

## Statuts possibles

| Statut | Signification |
|---|---|
| `en_attente` | Inscription en attente |
| `valide` | Inscription acceptée |
| `refuse` | Inscription refusée |
| `annule` | Inscription annulée |

---

# 6. Workflow : upload d’un document

## Acteur

Étudiant

## Étapes

1. L’étudiant se connecte.
2. Il ouvre la page de ses inscriptions ou documents.
3. Il choisit un document à envoyer.
4. Le formulaire est envoyé avec `multipart/form-data`.
5. PHP utilise `$_FILES`.
6. PHP vérifie erreur d’upload, extension, taille, type MIME et inscription de l’étudiant.
7. Le fichier est renommé avec un nom sécurisé.
8. Le fichier est déplacé avec `move_uploaded_file`.
9. Les informations du fichier sont enregistrées dans la table `documents`.

## Extensions acceptées

- PDF ;
- JPG ;
- JPEG ;
- PNG.

## Notions utilisées

- `$_FILES` ;
- `move_uploaded_file` ;
- validation côté serveur ;
- PDO `INSERT` ;
- session utilisateur.

---

# 7. Workflow : téléchargement d’un document

## Acteurs

- Étudiant ;
- Responsable ;
- Administrateur.

## Étapes

1. L’utilisateur clique sur un lien de téléchargement.
2. Le lien pointe vers une page PHP : `telecharger_document.php?id=...`.
3. PHP vérifie que l’utilisateur est connecté.
4. PHP vérifie les droits : étudiant propriétaire, responsable du voyage concerné, ou administrateur.
5. PHP vérifie que le fichier existe.
6. PHP envoie le fichier avec des headers.

## Pourquoi c’est important

Le fichier n’est pas exposé directement. Le téléchargement est contrôlé par PHP.

---

# 8. Workflow : gestion des utilisateurs

## Acteur

Administrateur

## Étapes

1. L’administrateur ouvre la page des utilisateurs.
2. Il peut créer ou modifier un utilisateur.
3. Il peut changer le rôle ou le statut.
4. Le système protège contre : désactivation de son propre compte, retrait de son propre rôle admin, suppression du dernier administrateur actif.

## Notions utilisées

- rôle administrateur ;
- `POST` ;
- CSRF ;
- PDO `UPDATE` ;
- logique métier ;
- sécurité simple.
