# Rapport Synthese - Plateforme de Gestion des Voyages d'Etudes

## 1. Presentation du projet

La plateforme realisee permet de centraliser la gestion des voyages d'etudes dans un etablissement universitaire. Elle couvre le cycle principal du cahier de charge : creation d'un voyage par un responsable pedagogique, validation administrative, inscription des etudiants, suivi des inscriptions et depot de documents.

## 2. Technologies utilisees

- Front-end : HTML5, CSS3, JavaScript
- Back-end : PHP 8.2
- Base de donnees : MariaDB/MySQL
- Architecture : MVC maison sans framework
- Serveur local : XAMPP

La partie JavaScript reste volontairement simple et adaptee au niveau du projet. Elle ajoute de l'interaction cote client : recherche instantanee, affichage/masquage du mot de passe, validation simple de formulaire, informations sur les fichiers uploades et confirmations avant actions sensibles.

## 3. Architecture logicielle

Le projet suit une organisation MVC :

- `public/index.php` : point d'entree et routage
- `app/controllers/` : traitement des requetes HTTP
- `app/models/` : acces aux donnees avec PDO
- `app/views/` : pages HTML dynamiques rendues par PHP
- `app/core/` : classes et helpers communs
- `database/` : schema SQL et donnees de test
- `assets/` : CSS et JavaScript
- `uploads/` : fichiers transmis par les etudiants

## 4. Acteurs pris en charge

### Etudiant

- Creation de compte
- Connexion/deconnexion
- Consultation des voyages valides
- Recherche de voyages par titre ou destination
- Consultation des details d'un voyage
- Inscription a un voyage
- Suivi de ses inscriptions
- Depot et consultation de documents

### Responsable pedagogique

- Connexion securisee
- Creation de voyages
- Modification de voyages
- Archivage de voyages
- Consultation des inscriptions par voyage
- Validation/refus des inscriptions
- Consultation des documents transmis par les etudiants

### Administrateur

- Connexion securisee
- Tableau de bord statistique
- Creation de comptes utilisateurs
- Changement de role utilisateur
- Activation/desactivation des comptes
- Validation/refus/archivage des voyages
- Consultation globale des documents

### Service financier

Le role `financier` existe dans le modele utilisateur pour preparer l'evolution du projet. Le module de paiement complet reste optionnel pour cette version.

## 5. Regles metier implementees

- Un etudiant ne peut s'inscrire qu'a un voyage valide.
- Une inscription est refusee automatiquement si le voyage est complet.
- Un etudiant ne peut pas s'inscrire deux fois au meme voyage.
- Un responsable peut creer un voyage, mais sa publication depend de l'administrateur.
- Un voyage peut etre archive.
- Un document depose est toujours associe a un utilisateur identifie.
- Les actions sensibles sont reservees aux roles autorises.

## 6. Securite

- Mots de passe hashes avec `password_hash()`
- Verification avec `password_verify()`
- Requetes SQL preparees via PDO
- Sessions PHP pour l'authentification
- Verification des roles sur les pages sensibles
- Jetons CSRF sur les formulaires sensibles
- Echappement HTML avec `htmlspecialchars()`
- Validation des fichiers televerses : extension et taille maximale

## 7. Base de donnees

Tables principales :

- `users`
- `voyages`
- `inscriptions`
- `documents`
- `paiements`

Contraintes importantes :

- Email utilisateur unique
- Contrainte unique sur `inscriptions(id_user, id_voyage)`
- Cles etrangeres entre utilisateurs, voyages, inscriptions et documents
- Index sur les colonnes souvent filtrees

## 8. Comptes de demonstration

Mot de passe commun :

```text
password
```

| Role | Email |
| --- | --- |
| Admin | admin@example.com |
| Responsable | responsable@example.com |
| Etudiant | etudiant@example.com |

## 9. Scenario de test principal

1. Le responsable se connecte.
2. Il cree un voyage.
3. L'administrateur se connecte.
4. Il valide le voyage.
5. L'etudiant se connecte.
6. Il consulte les voyages disponibles.
7. Il s'inscrit au voyage.
8. Il depose un document.
9. Le responsable consulte l'inscription et les documents.
10. Le responsable valide ou refuse l'inscription.
11. L'administrateur consulte les statistiques et les documents.

## 10. Limites et perspectives

La version actuelle correspond a un MVP complet pour le flux principal. Les evolutions possibles sont :

- Gestion complete des paiements par le service financier
- Generation de PDF pour les listes de participants
- Messagerie interne responsable-etudiants
- Pagination avancee des listes
- Export CSV des inscriptions
- Tableau de bord analytique plus detaille

## 11. Pourquoi s'arreter ici

Le projet montre deja les elements essentiels attendus :

- une base de donnees relationnelle ;
- une architecture MVC simple ;
- une interface HTML/CSS/JavaScript ;
- des interactions JavaScript utiles et simples ;
- des formulaires dynamiques en PHP ;
- une authentification avec roles ;
- des regles metier claires ;
- un upload de documents ;
- un tableau de bord simple.
