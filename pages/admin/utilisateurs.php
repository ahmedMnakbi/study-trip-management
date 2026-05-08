<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../classes/User.php';

require_role('admin');

$userModel = new User();
$erreurs = array();

if (est_post()) {
    verifier_csrf();
    $action = isset($_POST['action']) ? $_POST['action'] : '';

    if ($action === 'creer') {
        $nom = trim(isset($_POST['nom']) ? $_POST['nom'] : '');
        $prenom = trim(isset($_POST['prenom']) ? $_POST['prenom'] : '');
        $email = trim(isset($_POST['email']) ? $_POST['email'] : '');
        $mot_de_passe = isset($_POST['mot_de_passe']) ? $_POST['mot_de_passe'] : '';
        $role = isset($_POST['role']) ? $_POST['role'] : 'etudiant';

        if ($nom === '' || $prenom === '' || $email === '' || $mot_de_passe === '') {
            $erreurs[] = 'Tous les champs utilisateur sont obligatoires.';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erreurs[] = 'Email invalide.';
        }
        if (!in_array($role, array('etudiant', 'responsable', 'admin'))) {
            $erreurs[] = 'Role invalide.';
        }
        if (strlen($mot_de_passe) < 6) {
            $erreurs[] = 'Mot de passe trop court.';
        }
        if ($userModel->trouverParEmail($email)) {
            $erreurs[] = 'Email deja utilise.';
        }

        if (empty($erreurs)) {
            $userModel->creer(array(
                'nom' => $nom,
                'prenom' => $prenom,
                'email' => $email,
                'mot_de_passe' => $mot_de_passe,
                'role' => $role
            ));
            message_flash('success', 'Utilisateur cree.');
            rediriger('pages/admin/utilisateurs.php');
        }
    }

    if ($action === 'modifier') {
        $id_user = isset($_POST['id_user']) ? (int) $_POST['id_user'] : 0;
        $role = isset($_POST['role']) ? $_POST['role'] : '';
        $statut = isset($_POST['statut']) ? $_POST['statut'] : '';
        $user = $userModel->trouverParId($id_user);

        if (!$user || !in_array($role, array('etudiant', 'responsable', 'admin')) || !in_array($statut, array('actif', 'inactif'))) {
            $erreurs[] = 'Donnees invalides.';
        } elseif ($id_user === id_utilisateur() && $statut === 'inactif') {
            $erreurs[] = 'Vous ne pouvez pas desactiver votre propre compte.';
        } elseif ($id_user === id_utilisateur() && $role !== 'admin') {
            $erreurs[] = 'Vous ne pouvez pas retirer votre propre role admin.';
        } elseif ($user['role'] === 'admin' && $user['statut'] === 'actif' && $userModel->compterAdminsActifs() <= 1 && ($role !== 'admin' || $statut !== 'actif')) {
            $erreurs[] = 'Impossible de retirer le dernier administrateur actif.';
        } else {
            $userModel->modifierRoleStatut($id_user, $role, $statut);
            message_flash('success', 'Utilisateur modifie.');
            rediriger('pages/admin/utilisateurs.php');
        }
    }
}

$users = $userModel->listerTous();
$titre_page = 'Utilisateurs';
require_once __DIR__ . '/../../includes/header.php';
?>

<section class="page-title">
    <h1>Gestion des utilisateurs</h1>
</section>

<?php foreach ($erreurs as $erreur): ?><div class="alert error"><?php echo e($erreur); ?></div><?php endforeach; ?>

<section class="panel">
    <h2>Ajouter un utilisateur</h2>
    <form method="post" data-form-register>
        <?php echo champ_csrf(); ?>
        <input type="hidden" name="action" value="creer">
        <div class="form-row">
            <label>Nom <input type="text" name="nom" required></label>
            <label>Prenom <input type="text" name="prenom" required></label>
        </div>
        <div class="form-row">
            <label>Email <input type="email" name="email" required></label>
            <label>Mot de passe <input type="password" name="mot_de_passe" required></label>
        </div>
        <label>Role
            <select name="role">
                <option value="etudiant">Etudiant</option>
                <option value="responsable">Responsable</option>
                <option value="admin">Admin</option>
            </select>
        </label>
        <button type="submit">Ajouter</button>
    </form>
</section>

<table>
    <thead>
        <tr>
            <th>Nom</th>
            <th>Email</th>
            <th>Role</th>
            <th>Statut</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo e($user['prenom'] . ' ' . $user['nom']); ?></td>
                <td><?php echo e($user['email']); ?></td>
                <td><?php echo e($user['role']); ?></td>
                <td><?php echo e(libelle_statut($user['statut'])); ?></td>
                <td>
                    <form method="post">
                        <?php echo champ_csrf(); ?>
                        <input type="hidden" name="action" value="modifier">
                        <input type="hidden" name="id_user" value="<?php echo e($user['id_user']); ?>">
                        <select name="role">
                            <option value="etudiant" <?php if ($user['role'] === 'etudiant') echo 'selected'; ?>>Etudiant</option>
                            <option value="responsable" <?php if ($user['role'] === 'responsable') echo 'selected'; ?>>Responsable</option>
                            <option value="admin" <?php if ($user['role'] === 'admin') echo 'selected'; ?>>Admin</option>
                        </select>
                        <select name="statut">
                            <option value="actif" <?php if ($user['statut'] === 'actif') echo 'selected'; ?>>Actif</option>
                            <option value="inactif" <?php if ($user['statut'] === 'inactif') echo 'selected'; ?>>Inactif</option>
                        </select>
                        <button type="submit">Modifier</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

