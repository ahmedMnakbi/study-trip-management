# Scenario de Demonstration V2

## Preparation

1. Demarrer Apache et MySQL.
2. Importer `database/schema.sql`, puis `database/seed.sql`.
3. Ouvrir `index.php`.

## Comptes

Mot de passe : `password`

| Role | Email |
| --- | --- |
| Admin | admin@example.com |
| Responsable | responsable@example.com |
| Etudiant | etudiant@example.com |

## Demo rapide

1. Se connecter comme responsable et ajouter un voyage.
2. Se connecter comme admin et valider ce voyage.
3. Se connecter comme etudiant, consulter le voyage et envoyer une inscription.
4. Envoyer un document depuis l'espace etudiant.
5. Revenir comme responsable et valider/refuser l'inscription.
6. Revenir comme admin et montrer le dashboard.

## Phrase de defense

Ce projet utilise les notions vues en classe : formulaires PHP avec `$_POST` et `$_GET`, sessions, PDO avec requetes preparees, classes PHP simples, JavaScript pour la validation et upload avec `$_FILES`.

