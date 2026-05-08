# Rapport Synthese V2

## Presentation

La V2 est une application web academique pour gerer les voyages d'etudes. Elle couvre le circuit principal : creation d'un voyage par un responsable, validation par l'administrateur, inscription des etudiants et depot de documents.

## Technologies

- HTML et CSS pour les pages et les tableaux.
- JavaScript simple pour la validation cote client.
- PHP avec pages classiques, includes et formulaires.
- PDO/MySQL pour les operations CRUD.
- Sessions PHP pour l'authentification et les roles.

## Organisation

- `config/database.php` : connexion PDO.
- `classes/` : classes `User`, `Voyage`, `Inscription`, `Document`.
- `includes/` : fonctions communes, session, header et footer.
- `pages/` : pages PHP classees par domaine.
- `assets/` : CSS et JavaScript.
- `database/` : schema et donnees de test.
- `uploads/documents/` : documents envoyes par les etudiants.

## Roles

- Etudiant : consulter les voyages valides, s'inscrire, suivre ses inscriptions, envoyer des documents.
- Responsable : ajouter/modifier/annuler ses voyages, valider/refuser les inscriptions.
- Admin : gerer les utilisateurs, valider/refuser les voyages, consulter les statistiques et documents.

## Securite

- Mots de passe hashes.
- Requetes preparees PDO.
- Sessions et verification des roles.
- Echappement avec `htmlspecialchars`.
- Actions sensibles en POST avec jeton CSRF simple.
- Upload limite et controle.

