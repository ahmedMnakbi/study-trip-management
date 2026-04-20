<section class="auth-shell">
    <div>
        <p class="eyebrow">Compte etudiant</p>
        <h1>Creer votre compte</h1>
        <p class="lede">Un compte etudiant permet de consulter les voyages valides et d'envoyer une demande d'inscription.</p>
    </div>

    <form class="panel form" method="post" action="<?= e(url('register/store')) ?>">
        <?= csrf_field() ?>

        <label for="nom">Nom</label>
        <input id="nom" type="text" name="nom" value="<?= e($old['nom'] ?? '') ?>" required>
        <?php if (isset($errors['nom'])): ?>
            <p class="field-error"><?= e($errors['nom']) ?></p>
        <?php endif; ?>

        <label for="prenom">Prenom</label>
        <input id="prenom" type="text" name="prenom" value="<?= e($old['prenom'] ?? '') ?>" required>
        <?php if (isset($errors['prenom'])): ?>
            <p class="field-error"><?= e($errors['prenom']) ?></p>
        <?php endif; ?>

        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="<?= e($old['email'] ?? '') ?>" required>
        <?php if (isset($errors['email'])): ?>
            <p class="field-error"><?= e($errors['email']) ?></p>
        <?php endif; ?>

        <label for="mot_de_passe">Mot de passe</label>
        <input id="mot_de_passe" type="password" name="mot_de_passe" minlength="6" required>
        <?php if (isset($errors['mot_de_passe'])): ?>
            <p class="field-error"><?= e($errors['mot_de_passe']) ?></p>
        <?php endif; ?>

        <button class="button" type="submit">Creer le compte</button>
        <p class="muted">Deja inscrit ? <a href="<?= e(url('login')) ?>">Se connecter</a>.</p>
    </form>
</section>
