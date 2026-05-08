<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../classes/Voyage.php';

require_role('responsable');

$erreurs = array();
$voyage = array(
    'titre' => '',
    'destination' => '',
    'description' => '',
    'date_depart' => '',
    'date_retour' => '',
    'budget' => '',
    'nb_places' => ''
);

if (est_post()) {
    verifier_csrf();
    foreach ($voyage as $champ => $valeur) {
        $voyage[$champ] = trim(isset($_POST[$champ]) ? $_POST[$champ] : '');
    }

    if ($voyage['titre'] === '' || $voyage['destination'] === '' || $voyage['description'] === '' || $voyage['date_depart'] === '' || $voyage['date_retour'] === '' || $voyage['nb_places'] === '') {
        $erreurs[] = 'Les champs principaux sont obligatoires.';
    }
    if ($voyage['date_depart'] !== '' && $voyage['date_retour'] !== '' && $voyage['date_retour'] < $voyage['date_depart']) {
        $erreurs[] = 'La date retour doit etre apres la date depart.';
    }
    if (!is_numeric($voyage['budget']) || (float) $voyage['budget'] < 0) {
        $erreurs[] = 'Budget invalide.';
    }
    if (!ctype_digit($voyage['nb_places']) || (int) $voyage['nb_places'] < 1) {
        $erreurs[] = 'Nombre de places invalide.';
    }

    if (empty($erreurs)) {
        $voyage['id_responsable'] = id_utilisateur();
        (new Voyage())->creer($voyage);
        message_flash('success', 'Voyage ajoute. Il attend la validation de l administrateur.');
        rediriger('pages/voyages/mes_voyages.php');
    }
}

$titre_page = 'Ajouter voyage';
require_once __DIR__ . '/../../includes/header.php';
?>

<section class="panel">
    <h1>Ajouter un voyage</h1>
    <?php foreach ($erreurs as $erreur): ?><div class="alert error"><?php echo e($erreur); ?></div><?php endforeach; ?>

    <form method="post" data-form-voyage>
        <?php echo champ_csrf(); ?>
        <label>Titre <input type="text" name="titre" value="<?php echo e($voyage['titre']); ?>" required></label>
        <label>Destination <input type="text" name="destination" value="<?php echo e($voyage['destination']); ?>" required></label>
        <label>Description <textarea name="description" required><?php echo e($voyage['description']); ?></textarea></label>
        <div class="form-row">
            <label>Date depart <input type="date" name="date_depart" value="<?php echo e($voyage['date_depart']); ?>" data-date-start required></label>
            <label>Date retour <input type="date" name="date_retour" value="<?php echo e($voyage['date_retour']); ?>" data-date-end required></label>
        </div>
        <div class="form-row">
            <label>Budget <input type="number" step="0.01" min="0" name="budget" value="<?php echo e($voyage['budget']); ?>" data-positive-number></label>
            <label>Nombre de places <input type="number" min="1" name="nb_places" value="<?php echo e($voyage['nb_places']); ?>" data-positive-integer required></label>
        </div>
        <button type="submit">Enregistrer</button>
    </form>
</section>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

