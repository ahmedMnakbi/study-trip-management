<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../classes/User.php';

if (utilisateur_connecte()) {
    rediriger('index.php');
}

$erreurs = array();
$old = array('nom' => '', 'prenom' => '', 'email' => '');

if (est_post()) {
    verifier_csrf();
    $old['nom'] = trim(isset($_POST['nom']) ? $_POST['nom'] : '');
    $old['prenom'] = trim(isset($_POST['prenom']) ? $_POST['prenom'] : '');
    $old['email'] = trim(isset($_POST['email']) ? $_POST['email'] : '');
    $mot_de_passe = isset($_POST['mot_de_passe']) ? $_POST['mot_de_passe'] : '';

    if ($old['nom'] === '' || $old['prenom'] === '' || $old['email'] === '' || $mot_de_passe === '') {
        $erreurs[] = 'Tous les champs sont obligatoires.';
    }
    if ($old['email'] !== '' && !filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {
        $erreurs[] = 'Email invalide.';
    }
    if (strlen($mot_de_passe) < 6) {
        $erreurs[] = 'Le mot de passe doit contenir au moins 6 caracteres.';
    }

    $userModel = new User();
    if ($old['email'] !== '' && $userModel->trouverParEmail($old['email'])) {
        $erreurs[] = 'Cet email est deja utilise.';
    }

    if (empty($erreurs)) {
        $userModel->creer(array(
            'nom' => $old['nom'],
            'prenom' => $old['prenom'],
            'email' => $old['email'],
            'mot_de_passe' => $mot_de_passe,
            'role' => 'etudiant'
        ));
        message_flash('success', 'Compte cree. Vous pouvez vous connecter.');
        rediriger('pages/auth/login.php');
    }
}

$titre_page = 'Creation de compte';
require_once __DIR__ . '/../../includes/header.php';
?>

<section class="panel narrow">
    <h1>Creer un compte etudiant</h1>
    <?php foreach ($erreurs as $erreur): ?>
        <div class="alert error"><?php echo e($erreur); ?></div>
    <?php endforeach; ?>

    <form method="post" data-form-register>
        <?php echo champ_csrf(); ?>
        <label>Nom
            <input type="text" name="nom" value="<?php echo e($old['nom']); ?>" required>
        </label>
        <label>Prenom
            <input type="text" name="prenom" value="<?php echo e($old['prenom']); ?>" required>
        </label>
        <label>Email
            <input type="email" name="email" value="<?php echo e($old['email']); ?>" required>
        </label>
        <label>Mot de passe
            <input type="password" name="mot_de_passe" data-min-length="6" required>
        </label>
        <p class="hint" data-password-hint>Minimum 6 caracteres.</p>
        <button type="submit">Creer le compte</button>
    </form>
</section>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

