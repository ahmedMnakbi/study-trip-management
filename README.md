# Plateforme de Gestion des Voyages d'Etudes

Application web academique en HTML, CSS, JavaScript, PHP 8+ et MySQL 8+, construite avec une architecture MVC maison sans framework.

Le projet est volontairement garde simple pour un niveau premiere annee : il couvre le flux principal demande dans le cahier de charge sans ajouter de modules trop avances.

## Fonctionnalites implementees

- Creation de compte etudiant
- Connexion/deconnexion avec mots de passe hashes
- Gestion des roles `etudiant`, `responsable`, `admin`, `financier`
- Consultation des voyages valides
- Recherche simple par titre ou destination
- Creation/modification de voyages par un responsable pedagogique
- Validation/refus/archivage des voyages par l'administrateur
- Inscription d'un etudiant a un voyage valide
- Blocage des doublons via contrainte unique
- Refus automatique si le voyage est complet
- Validation/refus des inscriptions par le responsable
- Depot de documents par les etudiants
- Consultation des documents par le responsable et l'administrateur
- Gestion admin des utilisateurs
- Statistiques simples dans le tableau de bord admin
- Protection CSRF sur les formulaires sensibles
- Requetes SQL preparees avec PDO

## Installation avec XAMPP ou WAMP

XAMPP est installe sur cette machine dans :

```text
C:\xampp
```

Pour lancer rapidement le projet depuis ce dossier sans le copier dans `htdocs` :

```powershell
Start-Process -FilePath 'C:\xampp\mysql\bin\mysqld.exe' -ArgumentList '--defaults-file=C:\xampp\mysql\bin\my.ini' -WorkingDirectory 'C:\xampp\mysql\bin' -WindowStyle Hidden
& 'C:\xampp\php\php.exe' -S 127.0.0.1:8000 -t .
```

Puis ouvrir :

```text
http://127.0.0.1:8000/public/index.php
```

Alternative avec Apache :

1. Copier ce dossier dans le repertoire web local :
   - XAMPP : `C:\xampp\htdocs\js_php project`
   - WAMP : `C:\wamp64\www\js_php project`

2. Demarrer Apache et MySQL.

3. Importer la base de donnees :
   - Ouvrir phpMyAdmin
   - Importer `database/schema.sql`
   - Importer ensuite `database/seed.sql`

4. Verifier la configuration MySQL dans `app/config/config.php` :

   ```php
   define('DB_HOST', '127.0.0.1');
   define('DB_NAME', 'gestion_voyages_etudes');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   ```

5. Ouvrir l'application :

   ```text
   http://localhost/js_php project/public/index.php
   ```

## Comptes de test

Tous les comptes de test utilisent le mot de passe :

```text
password
```

| Role | Email |
| --- | --- |
| Admin | admin@example.com |
| Responsable | responsable@example.com |
| Etudiant | etudiant@example.com |

## Parcours de test recommande

1. Se connecter avec `responsable@example.com`.
2. Creer un nouveau voyage.
3. Se connecter avec `admin@example.com`.
4. Valider le voyage dans la gestion des voyages.
5. Se connecter avec `etudiant@example.com`.
6. Consulter les voyages disponibles et envoyer une inscription.
7. Revenir avec le compte responsable et valider ou refuser l'inscription.

## Structure

```text
public/              Point d'entree de l'application
app/config/          Configuration et connexion MySQL
app/core/            Helpers, authentification, classe Controller, classe Model
app/controllers/     Controleurs MVC
app/models/          Acces aux donnees
app/views/           Pages PHP/HTML
assets/css/          Styles
assets/js/           JavaScript
database/            Schema et donnees de test
uploads/             Futurs documents televerses
```

## Notes

Le module documents est integre dans cette version. Le suivi financier reste prepare dans le schema, mais il n'est pas encore expose dans l'interface afin de garder le MVP concentre sur le flux principal du cahier de charge.

Un rapport de synthese est disponible dans `RAPPORT_PROJET.md`.
Un scenario de demonstration est disponible dans `DEMO_SCENARIO.md`.
Une checklist de fin de projet est disponible dans `CHECKLIST_FINAL.md`.

## Limite volontaire du projet

Cette version doit s'arreter ici pour rester claire et defendable :

- pas de paiement en ligne ;
- pas de messagerie interne ;
- pas d'application mobile ;
- pas de framework PHP ;
- pas de tableau de bord complexe.

Ces points peuvent etre cites comme perspectives d'evolution pendant la presentation.
