# Checklist Manuelle V2

## Preparation

- [ ] Importer `database/schema.sql`.
- [ ] Importer `database/seed.sql`.
- [ ] Verifier `config/database.php`.
- [ ] Ouvrir `index.php` dans XAMPP/WAMP ou avec `php -S`.

## Authentification

- [ ] Login admin fonctionne.
- [ ] Login responsable fonctionne.
- [ ] Login etudiant fonctionne.
- [ ] Logout fonctionne avec POST.
- [ ] Une page protegee bloque un visiteur non connecte.

## Etudiant

- [ ] Voir seulement les voyages valides.
- [ ] Voir le detail d'un voyage.
- [ ] S'inscrire a un voyage.
- [ ] Double inscription refusee.
- [ ] Inscription refusee si le voyage est complet.
- [ ] Upload PDF/JPG/PNG accepte.
- [ ] Upload PHP ou fichier trop lourd refuse.
- [ ] Telechargement de ses documents fonctionne.

## Responsable

- [ ] Ajouter un voyage.
- [ ] Modifier seulement ses voyages.
- [ ] Annuler un voyage.
- [ ] Voir les inscriptions de ses voyages.
- [ ] Valider/refuser une inscription.
- [ ] Validation bloquee si la capacite est atteinte.
- [ ] Telecharger les documents de ses voyages.

## Admin

- [ ] Voir le dashboard.
- [ ] Valider/refuser un voyage.
- [ ] Ajouter un utilisateur.
- [ ] Modifier role/statut utilisateur.
- [ ] Impossible de se desactiver soi-meme.
- [ ] Impossible de retirer son propre role admin.
- [ ] Impossible de retirer le dernier admin actif.
- [ ] Voir tous les documents.

