<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../classes/User.php';
require_once __DIR__ . '/../../classes/Voyage.php';
require_once __DIR__ . '/../../classes/Inscription.php';

require_role('admin');

$userModel = new User();
$voyageModel = new Voyage();
$inscriptionModel = new Inscription();

$titre_page = 'Dashboard admin';
require_once __DIR__ . '/../../includes/header.php';
?>

<section class="page-title">
    <h1>Tableau de bord</h1>
</section>

<div class="stats">
    <div class="stat"><span><?php echo e($voyageModel->compterTous()); ?></span><p>Voyages</p></div>
    <div class="stat"><span><?php echo e($userModel->compterTous()); ?></span><p>Utilisateurs</p></div>
    <div class="stat"><span><?php echo e($inscriptionModel->compterTous()); ?></span><p>Inscriptions</p></div>
    <div class="stat"><span><?php echo e($voyageModel->compterEnAttente() + $inscriptionModel->compterEnAttente()); ?></span><p>Validations en attente</p></div>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

