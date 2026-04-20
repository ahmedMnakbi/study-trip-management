<section class="auth-shell">
    <div class="auth-visual">
        <img src="<?= e(asset('assets/img/campus-hero.jpg')) ?>" alt="Etudiants preparant un projet academique">
        <p class="eyebrow">Connexion securisee</p>
        <h1>Acceder a la plateforme</h1>
        <p class="lede">Connectez-vous pour consulter les voyages, suivre les inscriptions ou gerer les validations selon votre role.</p>
    </div>

    <form class="panel form" method="post" action="<?= e(url('login/store')) ?>">
        <?= csrf_field() ?>

        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="<?= e($old['email'] ?? '') ?>" required>
        <?php if (isset($errors['email'])): ?>
            <p class="field-error"><?= e($errors['email']) ?></p>
        <?php endif; ?>

        <label for="mot_de_passe">Mot de passe</label>
        <div class="password-field">
            <input id="mot_de_passe" type="password" name="mot_de_passe" required>
            <button class="button small secondary" type="button" data-toggle-password="mot_de_passe">Afficher</button>
        </div>
        <?php if (isset($errors['mot_de_passe'])): ?>
            <p class="field-error"><?= e($errors['mot_de_passe']) ?></p>
        <?php endif; ?>

        <button class="button" type="submit">Se connecter</button>
        <p class="muted">Pas encore de compte ? <a href="<?= e(url('register')) ?>">Creer un compte etudiant</a>.</p>
    </form>
</section>
