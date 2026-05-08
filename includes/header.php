<?php
require_once __DIR__ . '/auth.php';
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e(isset($titre_page) ? $titre_page : 'Voyages d etudes'); ?></title>
    <link rel="stylesheet" href="<?php echo e(url('assets/css/style.css')); ?>">
</head>
<body>
<header class="site-header">
    <a class="brand" href="<?php echo e(url('index.php')); ?>">Voyages Etudes</a>
    <nav class="nav">
        <a href="<?php echo e(url('pages/voyages/liste_voyages.php')); ?>">Voyages</a>

        <?php if (role_utilisateur() === 'etudiant'): ?>
            <a href="<?php echo e(url('pages/inscriptions/mes_inscriptions.php')); ?>">Mes inscriptions</a>
            <a href="<?php echo e(url('pages/documents/mes_documents.php')); ?>">Mes documents</a>
        <?php endif; ?>

        <?php if (role_utilisateur() === 'responsable'): ?>
            <a href="<?php echo e(url('pages/voyages/mes_voyages.php')); ?>">Mes voyages</a>
        <?php endif; ?>

        <?php if (role_utilisateur() === 'admin'): ?>
            <a href="<?php echo e(url('pages/admin/dashboard.php')); ?>">Dashboard</a>
            <a href="<?php echo e(url('pages/voyages/valider_voyages.php')); ?>">Valider voyages</a>
            <a href="<?php echo e(url('pages/admin/utilisateurs.php')); ?>">Utilisateurs</a>
            <a href="<?php echo e(url('pages/documents/tous_documents.php')); ?>">Documents</a>
        <?php endif; ?>

        <?php if (utilisateur_connecte()): ?>
            <span class="nav-user"><?php echo e($_SESSION['user']['prenom'] . ' ' . $_SESSION['user']['nom']); ?></span>
            <form class="logout-form" method="post" action="<?php echo e(url('pages/auth/logout.php')); ?>">
                <?php echo champ_csrf(); ?>
                <button type="submit">Deconnexion</button>
            </form>
        <?php else: ?>
            <a href="<?php echo e(url('pages/auth/login.php')); ?>">Connexion</a>
            <a class="button small" href="<?php echo e(url('pages/auth/register.php')); ?>">Creer compte</a>
        <?php endif; ?>
    </nav>
</header>
<main class="container">
<?php afficher_flash(); ?>

