# Checklist de tests manuels

Ce fichier sert à tester le projet avant la présentation.

---

# 1. Tests d’installation

- [ ] Apache démarre.
- [ ] MySQL démarre.
- [ ] `schema.sql` s’importe sans erreur.
- [ ] `seed.sql` s’importe sans erreur.
- [ ] Les tables existent : `users`, `voyages`, `inscriptions`, `documents`.
- [ ] La table `paiements` n’existe pas.
- [ ] Le rôle `financier` n’existe pas.
- [ ] L’application s’ouvre avec `index.php`.

---

# 2. Tests de connexion

## Administrateur

- [ ] Connexion avec `admin@example.com`.
- [ ] Mot de passe `password`.
- [ ] Redirection vers le tableau de bord.
- [ ] Navigation admin affichée.

## Responsable

- [ ] Connexion avec `responsable@example.com`.
- [ ] Mot de passe `password`.
- [ ] Navigation responsable affichée.

## Étudiant

- [ ] Connexion avec `etudiant@example.com`.
- [ ] Mot de passe `password`.
- [ ] Navigation étudiant affichée.

## Déconnexion

- [ ] La déconnexion fonctionne.
- [ ] La déconnexion utilise un formulaire POST.
- [ ] La déconnexion ne fonctionne pas directement par GET.

---

# 3. Tests étudiant

- [ ] L’étudiant voit les voyages validés.
- [ ] L’étudiant peut ouvrir le détail d’un voyage.
- [ ] L’étudiant peut s’inscrire à un voyage.
- [ ] Une double inscription est bloquée.
- [ ] L’étudiant voit ses inscriptions.
- [ ] L’étudiant peut envoyer un document valide.
- [ ] Un fichier invalide est refusé.
- [ ] L’étudiant peut télécharger ses propres documents.
- [ ] L’étudiant ne peut pas télécharger les documents d’un autre étudiant.

---

# 4. Tests responsable

- [ ] Le responsable peut créer un voyage.
- [ ] Le voyage créé est en statut `en_attente`.
- [ ] Le responsable peut modifier ses propres voyages.
- [ ] Le responsable ne peut pas modifier les voyages d’un autre responsable.
- [ ] Le responsable peut annuler un de ses voyages.
- [ ] Le responsable peut voir les inscriptions de ses voyages.
- [ ] Le responsable peut valider une inscription.
- [ ] Le responsable peut refuser une inscription.
- [ ] Le responsable ne peut pas gérer les inscriptions d’un voyage qui ne lui appartient pas.

---

# 5. Tests administrateur

- [ ] L’administrateur voit le tableau de bord.
- [ ] L’administrateur peut valider un voyage.
- [ ] L’administrateur peut refuser un voyage.
- [ ] L’administrateur peut gérer les utilisateurs.
- [ ] L’administrateur ne peut pas désactiver son propre compte.
- [ ] L’administrateur ne peut pas retirer son propre rôle admin.
- [ ] Le dernier administrateur actif ne peut pas être désactivé.
- [ ] Le dernier administrateur actif ne peut pas être rétrogradé.

---

# 6. Tests capacité

Créer un voyage avec une seule place.

- [ ] Le premier étudiant peut s’inscrire.
- [ ] Le deuxième étudiant est bloqué si le voyage est complet.
- [ ] La validation d’une inscription vérifie aussi les places restantes.
- [ ] Les places restantes affichées correspondent à la logique d’inscription.

---

# 7. Tests upload

- [ ] Upload PDF accepté.
- [ ] Upload JPG accepté.
- [ ] Upload PNG accepté.
- [ ] Extension invalide refusée.
- [ ] Type MIME invalide refusé.
- [ ] Fichier supérieur à 5 MB refusé.
- [ ] Le fichier est renommé automatiquement.
- [ ] Le chemin brut du fichier n’est pas exposé directement.
- [ ] Le téléchargement passe par `telecharger_document.php?id=...`.

---

# 8. Tests sécurité

- [ ] Un visiteur non connecté est redirigé vers login.
- [ ] Un mauvais rôle reçoit une erreur ou est bloqué.
- [ ] Les actions importantes utilisent `POST`.
- [ ] Les actions importantes vérifient CSRF.
- [ ] Les sorties HTML utilisent `e()` ou `htmlspecialchars`.
- [ ] Les mots de passe sont hashés.
- [ ] Les requêtes SQL utilisent PDO préparé.
- [ ] Le dossier upload contient `.htaccess`.
- [ ] Le dossier upload contient `.gitkeep`.

---

# 9. Test final de démonstration

- [ ] Responsable crée un voyage.
- [ ] Admin valide le voyage.
- [ ] Étudiant voit le voyage.
- [ ] Étudiant s’inscrit.
- [ ] Double inscription bloquée.
- [ ] Responsable valide l’inscription.
- [ ] Étudiant upload un document.
- [ ] Admin ou responsable consulte le document.
