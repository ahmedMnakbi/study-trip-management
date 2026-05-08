CREATE DATABASE IF NOT EXISTS gestion_voyages_etudes
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE gestion_voyages_etudes;

DROP TABLE IF EXISTS paiements;
DROP TABLE IF EXISTS documents;
DROP TABLE IF EXISTS inscriptions;
DROP TABLE IF EXISTS voyages;
DROP TABLE IF EXISTS users;

CREATE TABLE IF NOT EXISTS users (
  id_user INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(100) NOT NULL,
  prenom VARCHAR(100) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  mot_de_passe VARCHAR(255) NOT NULL,
  role ENUM('etudiant', 'responsable', 'admin') NOT NULL DEFAULT 'etudiant',
  statut ENUM('actif', 'inactif') NOT NULL DEFAULT 'actif',
  date_creation DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS voyages (
  id_voyage INT AUTO_INCREMENT PRIMARY KEY,
  titre VARCHAR(180) NOT NULL,
  destination VARCHAR(180) NOT NULL,
  description TEXT NOT NULL,
  date_depart DATE NOT NULL,
  date_retour DATE NOT NULL,
  budget DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  nb_places INT NOT NULL,
  statut ENUM('en_attente', 'valide', 'refuse', 'annule') NOT NULL DEFAULT 'en_attente',
  id_responsable INT NOT NULL,
  date_creation DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_voyages_responsable
    FOREIGN KEY (id_responsable) REFERENCES users(id_user)
    ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS inscriptions (
  id_inscription INT AUTO_INCREMENT PRIMARY KEY,
  id_user INT NOT NULL,
  id_voyage INT NOT NULL,
  date_inscription DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  statut ENUM('en_attente', 'valide', 'refuse', 'annule') NOT NULL DEFAULT 'en_attente',
  CONSTRAINT fk_inscriptions_user
    FOREIGN KEY (id_user) REFERENCES users(id_user)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_inscriptions_voyage
    FOREIGN KEY (id_voyage) REFERENCES voyages(id_voyage)
    ON DELETE CASCADE ON UPDATE CASCADE,
  UNIQUE KEY uniq_inscription_user_voyage (id_user, id_voyage)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS documents (
  id_document INT AUTO_INCREMENT PRIMARY KEY,
  id_user INT NOT NULL,
  id_voyage INT NULL,
  type_document VARCHAR(120) NOT NULL,
  nom_original VARCHAR(255) NOT NULL,
  chemin_fichier VARCHAR(255) NOT NULL,
  statut ENUM('en_attente', 'valide', 'refuse') NOT NULL DEFAULT 'en_attente',
  date_upload DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_documents_user
    FOREIGN KEY (id_user) REFERENCES users(id_user)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_documents_voyage
    FOREIGN KEY (id_voyage) REFERENCES voyages(id_voyage)
    ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
