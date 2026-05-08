<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../classes/Voyage.php';
require_once __DIR__ . '/../../classes/Inscription.php';

$recherche = trim(isset($_GET['q']) ? $_GET['q'] : '');
$voyageModel = new Voyage();
$voyages = $voyageModel->listerValides($recherche);

$titre_page = 'Voyages valides';
require_once __DIR__ . '/../../includes/header.php';
?>

<section class="page-title">
    <h1>Voyages disponibles</h1>
    <p>Les etudiants voient seulement les voyages valides par l'administrateur.</p>
</section>

<form class="search-bar" method="get">
    <input type="search" name="q" value="<?php echo e($recherche); ?>" placeholder="Rechercher par titre ou destination">
    <button type="submit">Rechercher</button>
</form>

<div class="grid">
    <?php foreach ($voyages as $voyage): ?>
        <article class="card">
            <h2><?php echo e($voyage['titre']); ?></h2>
            <p><strong>Destination :</strong> <?php echo e($voyage['destination']); ?></p>
            <p><strong>Dates :</strong> <?php echo e($voyage['date_depart']); ?> au <?php echo e($voyage['date_retour']); ?></p>
            <p><strong>Places restantes :</strong> <?php echo e($voyage['places_restantes']); ?></p>
            <a class="button" href="<?php echo e(url('pages/voyages/detail_voyage.php?id=' . $voyage['id_voyage'])); ?>">Voir details</a>
        </article>
    <?php endforeach; ?>
</div>

<?php if (empty($voyages)): ?>
    <p>Aucun voyage valide pour le moment.</p>
<?php endif; ?>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

