USE gestion_voyages_etudes;

INSERT INTO users (
  nom,
  prenom,
  email,
  mot_de_passe,
  role,
  statut
)
VALUES
  (
    'Admin',
    'Principal',
    'admin@example.com',
    '$2y$10$C9I8KiHibm3BwPICIiq8wuSbubgXs4dOQj.DRr/DVYRsOPhAtEaQ.',
    'admin',
    'actif'
  ),
  (
    'Responsable',
    'Pedagogique',
    'responsable@example.com',
    '$2y$10$C9I8KiHibm3BwPICIiq8wuSbubgXs4dOQj.DRr/DVYRsOPhAtEaQ.',
    'responsable',
    'actif'
  ),
  (
    'Etudiant',
    'Demo',
    'etudiant@example.com',
    '$2y$10$C9I8KiHibm3BwPICIiq8wuSbubgXs4dOQj.DRr/DVYRsOPhAtEaQ.',
    'etudiant',
    'actif'
  )
ON DUPLICATE KEY UPDATE
  role = VALUES(role),
  statut = 'actif';

INSERT INTO voyages (
  titre,
  destination,
  description,
  date_depart,
  date_retour,
  budget,
  nb_places,
  statut,
  id_responsable
)
SELECT
  'Visite industrielle',
  'Sousse',
  'Visite pedagogique dans une entreprise industrielle.',
  DATE_ADD(CURDATE(), INTERVAL 20 DAY),
  DATE_ADD(CURDATE(), INTERVAL 21 DAY),
  80.00,
  25,
  'valide',
  id_user
FROM users
WHERE email = 'responsable@example.com'
  AND NOT EXISTS (
    SELECT 1
    FROM voyages
    WHERE titre = 'Visite industrielle'
      AND destination = 'Sousse'
  );

INSERT INTO voyages (
  titre,
  destination,
  description,
  date_depart,
  date_retour,
  budget,
  nb_places,
  statut,
  id_responsable
)
SELECT
  'Sortie laboratoire',
  'Tunis',
  'Decouverte d un laboratoire universitaire et rencontre avec des chercheurs.',
  DATE_ADD(CURDATE(), INTERVAL 35 DAY),
  DATE_ADD(CURDATE(), INTERVAL 35 DAY),
  40.00,
  15,
  'en_attente',
  id_user
FROM users
WHERE email = 'responsable@example.com'
  AND NOT EXISTS (
    SELECT 1
    FROM voyages
    WHERE titre = 'Sortie laboratoire'
      AND destination = 'Tunis'
  );
