<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../classes/Voyage.php';

require_role('responsable');

$voyageModel = new Voyage();
$id = isset($_GET['id']) ? (int) $_GET['id'] : (isset($_POST['id_voyage']) ? (int) $_POST['id_voyage'] : 0);
$voyage = $voyageModel->trouverPourResponsable($id, id_utilisateur());

if (!$voyage) {
    message_flash('error', 'Voyage introuvable.');
    rediriger('pages/voyages/mes_voyages.php');
}

$erreurs = array();

if (est_post()) {
    verifier_csrf();
    $action = isset($_POST['action']) ? $_POST['action'] : 'modifier';

    if ($action === 'annuler') {
        $voyageModel->annuler($id, id_utilisateur());
        message_flash('success', 'Voyage annule.');
        rediriger('pages/voyages/mes_voyages.php');
    }

    $donnees = array(
        'titre' => trim(isset($_POST['titre']) ? $_POST['titre'] : ''),
        'destination' => trim(isset($_POST['destination']) ? $_POST['destination'] : ''),
        'description' => trim(isset($_POST['description']) ? $_POST['description'] : ''),
        'date_depart' => trim(isset($_POST['date_depart']) ? $_POST['date_depart'] : ''),
        'date_retour' => trim(isset($_POST['date_retour']) ? $_POST['date_retour'] : ''),
        'budget' => trim(isset($_POST['budget']) ? $_POST['budget'] : ''),
        'nb_places' => trim(isset($_POST['nb_places']) ? $_POST['nb_places'] : '')
    );

    if ($donnees['titre'] === '' || $donnees['destination'] === '' || $donnees['description'] === '' || $donnees['date_depart'] === '' || $donnees['date_retour'] === '') {
        $erreurs[] = 'Tous les champs principaux sont obligatoires.';
    }
    if ($donnees['date_retour'] < $donnees['date_depart']) {
        $erreurs[] = 'La date retour doit etre apres la date depart.';
    }
    if (!is_numeric($donnees['budget']) || (float) $donnees['budget'] < 0) {
        $erreurs[] = 'Budget invalide.';
    }
    if (!ctype_digit($donnees['nb_places']) || (int) $donnees['nb_places'] < 1) {
        $erreurs[] = 'Nombre de places invalide.';
    }

    if (empty($erreurs)) {
        $voyageModel->modifier($id, id_utilisateur(), $donnees);
        message_flash('success', 'Voyage modifie.');
        rediriger('pages/voyages/mes_voyages.php');
    }

    $voyage = array_merge($voyage, $donnees);
}

$titre_page = 'Modifier voyage';
require_once __DIR__ . '/../../includes/header.php';
?>

<section class="panel">
    <h1>Modifier le voyage</h1>
    <?php foreach ($erreurs as $erreur): ?><div class="alert error"><?php echo e($erreur); ?></div><?php endforeach; ?>

    <form method="post" data-form-voyage>
        <?php echo champ_csrf(); ?>
        <input type="hidden" name="id_voyage" value="<?php echo e($voyage['id_voyage']); ?>">
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
        <button type="submit" name="action" value="modifier">Modifier</button>
        <button class="danger" type="submit" name="action" value="annuler" data-confirm="Annuler ce voyage ?">Annuler le voyage</button>
    </form>
</section>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

