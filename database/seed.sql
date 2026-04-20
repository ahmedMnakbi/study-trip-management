USE gestion_voyages_etudes;

INSERT INTO users (nom, prenom, email, mot_de_passe, role)
VALUES
  ('Admin', 'Principal', 'admin@example.com', '$2y$10$gVGo2l6.DFzWjP90z6YwEudzrtshsxsb8RB0gBZEaY3dA9dUssvAW', 'admin'),
  ('Responsable', 'Pedagogique', 'responsable@example.com', '$2y$10$gVGo2l6.DFzWjP90z6YwEudzrtshsxsb8RB0gBZEaY3dA9dUssvAW', 'responsable'),
  ('Etudiant', 'Demo', 'etudiant@example.com', '$2y$10$gVGo2l6.DFzWjP90z6YwEudzrtshsxsb8RB0gBZEaY3dA9dUssvAW', 'etudiant')
ON DUPLICATE KEY UPDATE
  mot_de_passe = VALUES(mot_de_passe),
  role = VALUES(role),
  statut = 'actif';

INSERT INTO voyages (titre, destination, description, date_depart, date_retour, budget, nb_places, statut, id_responsable)
SELECT
  'Visite industrielle',
  'Sousse',
  'Visite pedagogique dans une entreprise industrielle avec atelier de decouverte.',
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
