<section class="page-heading">
    <div>
        <p class="eyebrow">Voyage d'etudes</p>
        <h1><?= e($title) ?></h1>
        <p class="lede">Apres creation, le voyage reste en attente jusqu'a la validation de l'administrateur.</p>
    </div>
</section>

<form class="panel form wide-form" method="post" action="<?= e($action) ?>" data-validate-voyage>
    <?= csrf_field() ?>

    <div class="form-grid">
        <div>
            <label for="titre">Titre</label>
            <input id="titre" type="text" name="titre" value="<?= e($voyage['titre'] ?? '') ?>" required>
            <?php if (isset($errors['titre'])): ?>
                <p class="field-error"><?= e($errors['titre']) ?></p>
            <?php endif; ?>
        </div>

        <div>
            <label for="destination">Destination</label>
            <input id="destination" type="text" name="destination" value="<?= e($voyage['destination'] ?? '') ?>" required>
            <?php if (isset($errors['destination'])): ?>
                <p class="field-error"><?= e($errors['destination']) ?></p>
            <?php endif; ?>
        </div>

        <div>
            <label for="date_depart">Date depart</label>
            <input id="date_depart" type="date" name="date_depart" value="<?= e($voyage['date_depart'] ?? '') ?>" required data-date-start>
            <?php if (isset($errors['date_depart'])): ?>
                <p class="field-error"><?= e($errors['date_depart']) ?></p>
            <?php endif; ?>
        </div>

        <div>
            <label for="date_retour">Date retour</label>
            <input id="date_retour" type="date" name="date_retour" value="<?= e($voyage['date_retour'] ?? '') ?>" required data-date-end>
            <?php if (isset($errors['date_retour'])): ?>
                <p class="field-error"><?= e($errors['date_retour']) ?></p>
            <?php endif; ?>
        </div>

        <div>
            <label for="budget">Budget</label>
            <input id="budget" type="number" name="budget" min="0" step="0.01" value="<?= e((string) ($voyage['budget'] ?? '0')) ?>" data-positive-number>
            <?php if (isset($errors['budget'])): ?>
                <p class="field-error"><?= e($errors['budget']) ?></p>
            <?php endif; ?>
        </div>

        <div>
            <label for="nb_places">Nombre de places</label>
            <input id="nb_places" type="number" name="nb_places" min="1" value="<?= e((string) ($voyage['nb_places'] ?? '')) ?>" required data-positive-integer>
            <?php if (isset($errors['nb_places'])): ?>
                <p class="field-error"><?= e($errors['nb_places']) ?></p>
            <?php endif; ?>
        </div>
    </div>

    <label for="description">Description</label>
    <textarea id="description" name="description" rows="7" required data-character-count="300"><?= e($voyage['description'] ?? '') ?></textarea>
    <p class="js-hint" data-character-output></p>
    <?php if (isset($errors['description'])): ?>
        <p class="field-error"><?= e($errors['description']) ?></p>
    <?php endif; ?>

    <div class="form-actions">
        <button class="button" type="submit">Enregistrer</button>
        <a class="button secondary" href="<?= e(url('responsable/voyages')) ?>">Annuler</a>
    </div>
</form>
