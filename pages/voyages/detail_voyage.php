<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../classes/Voyage.php';
require_once __DIR__ . '/../../classes/Inscription.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$voyageModel = new Voyage();
$voyage = $voyageModel->trouverParId($id);

if (!$voyage || $voyage['statut'] !== 'valide') {
    message_flash('error', 'Voyage introuvable.');
    rediriger('pages/voyages/liste_voyages.php');
}

$deja_inscrit = false;
if (role_utilisateur() === 'etudiant') {
    $inscriptionModel = new Inscription();
    $deja_inscrit = $inscriptionModel->existe(id_utilisateur(), $id);
}

$titre_page = 'Detail voyage';
require_once __DIR__ . '/../../includes/header.php';
?>

<section class="panel">
    <h1><?php echo e($voyage['titre']); ?></h1>
    <p><strong>Destination :</strong> <?php echo e($voyage['destination']); ?></p>
    <p><strong>Responsable :</strong> <?php echo e($voyage['responsable_prenom'] . ' ' . $voyage['responsable_nom']); ?></p>
    <p><strong>Dates :</strong> <?php echo e($voyage['date_depart']); ?> au <?php echo e($voyage['date_retour']); ?></p>
    <p><strong>Budget :</strong> <?php echo e($voyage['budget']); ?> TND</p>
    <p><strong>Places restantes :</strong> <?php echo e($voyage['places_restantes']); ?></p>
    <p><?php echo nl2br(e($voyage['description'])); ?></p>

    <?php if (role_utilisateur() === 'etudiant'): ?>
        <?php if ($deja_inscrit): ?>
            <p class="alert info">Vous etes deja inscrit a ce voyage.</p>
        <?php else: ?>
            <form method="post" action="<?php echo e(url('pages/inscriptions/inscrire.php')); ?>">
                <?php echo champ_csrf(); ?>
                <input type="hidden" name="id_voyage" value="<?php echo e($voyage['id_voyage']); ?>">
                <button type="submit">S'inscrire</button>
            </form>
        <?php endif; ?>
    <?php elseif (!utilisateur_connecte()): ?>
        <a class="button" href="<?php echo e(url('pages/auth/login.php')); ?>">Se connecter pour s'inscrire</a>
    <?php endif; ?>
</section>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

