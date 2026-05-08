<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../classes/User.php';

if (utilisateur_connecte()) {
    rediriger('index.php');
}

$erreur = '';
$email = '';

if (est_post()) {
    verifier_csrf();
    $email = trim(isset($_POST['email']) ? $_POST['email'] : '');
    $mot_de_passe = isset($_POST['mot_de_passe']) ? $_POST['mot_de_passe'] : '';

    $userModel = new User();
    $user = $userModel->trouverParEmail($email);

    if (!$user || !password_verify($mot_de_passe, $user['mot_de_passe'])) {
        $erreur = 'Email ou mot de passe incorrect.';
    } elseif ($user['statut'] !== 'actif') {
        $erreur = 'Ce compte est inactif.';
    } else {
        connecter_utilisateur($user);
        message_flash('success', 'Bienvenue ' . $user['prenom'] . ' !');
        rediriger('index.php');
    }
}

$titre_page = 'Connexion';
require_once __DIR__ . '/../../includes/header.php';
?>

<section class="panel narrow">
    <h1>Connexion</h1>
    <?php if ($erreur !== ''): ?>
        <div class="alert error"><?php echo e($erreur); ?></div>
    <?php endif; ?>

    <form method="post" data-form-login>
        <?php echo champ_csrf(); ?>
        <label>Email
            <input type="email" name="email" value="<?php echo e($email); ?>" required>
        </label>
        <label>Mot de passe
            <input type="password" name="mot_de_passe" required>
        </label>
        <button type="submit">Se connecter</button>
    </form>
</section>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

