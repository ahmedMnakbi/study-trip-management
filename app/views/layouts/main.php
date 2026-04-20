<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e(($title ?? 'Accueil') . ' - ' . APP_NAME) ?></title>
    <link rel="stylesheet" href="<?= e(asset('assets/css/app.css')) ?>">
</head>
<body>
    <header class="site-header">
        <a class="brand" href="<?= e(url('home')) ?>"><?= e(APP_NAME) ?></a>
        <button class="menu-toggle" type="button" data-menu-toggle>Menu</button>
        <nav class="main-nav" data-menu>
            <a href="<?= e(url('voyages')) ?>" class="<?= current_route() === 'voyages' ? 'active' : '' ?>">Voyages</a>

            <?php if (Auth::role() === 'etudiant'): ?>
                <a href="<?= e(url('mes-inscriptions')) ?>" class="<?= current_route() === 'mes-inscriptions' ? 'active' : '' ?>">Mes inscriptions</a>
                <a href="<?= e(url('documents')) ?>" class="<?= current_route() === 'documents' ? 'active' : '' ?>">Mes documents</a>
            <?php endif; ?>

            <?php if (Auth::role() === 'responsable'): ?>
                <a href="<?= e(url('responsable/voyages')) ?>" class="<?= str_starts_with(current_route(), 'responsable') ? 'active' : '' ?>">Espace responsable</a>
            <?php endif; ?>

            <?php if (Auth::role() === 'admin'): ?>
                <a href="<?= e(url('admin/dashboard')) ?>" class="<?= current_route() === 'admin/dashboard' ? 'active' : '' ?>">Dashboard</a>
                <a href="<?= e(url('admin/voyages')) ?>" class="<?= current_route() === 'admin/voyages' ? 'active' : '' ?>">Validation voyages</a>
                <a href="<?= e(url('admin/documents')) ?>" class="<?= current_route() === 'admin/documents' ? 'active' : '' ?>">Documents</a>
                <a href="<?= e(url('admin/users')) ?>" class="<?= current_route() === 'admin/users' ? 'active' : '' ?>">Utilisateurs</a>
            <?php endif; ?>

            <?php if (Auth::check()): ?>
                <span class="nav-user"><?= e(Auth::user()['prenom'] . ' ' . Auth::user()['nom']) ?></span>
                <a href="<?= e(url('logout')) ?>">Deconnexion</a>
            <?php else: ?>
                <a href="<?= e(url('login')) ?>">Connexion</a>
                <a class="button small" href="<?= e(url('register')) ?>">Creer un compte</a>
            <?php endif; ?>
        </nav>
    </header>

    <main class="page">
        <?php foreach (get_flash_messages() as $flash): ?>
            <div class="alert <?= e($flash['type']) ?>">
                <?= e($flash['message']) ?>
            </div>
        <?php endforeach; ?>

        <?php require $viewFile; ?>
    </main>

    <footer class="site-footer">
        <span>Plateforme academique de gestion des voyages d'etudes</span>
    </footer>

    <script src="<?= e(asset('assets/js/app.js')) ?>"></script>
</body>
</html>
