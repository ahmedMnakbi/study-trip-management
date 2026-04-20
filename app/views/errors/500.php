<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Erreur - <?= e(APP_NAME) ?></title>
    <link rel="stylesheet" href="<?= e(asset('assets/css/app.css')) ?>">
</head>
<body>
    <main class="page centered">
        <section class="panel">
            <h1>Erreur serveur</h1>
            <p><?= e($message ?? 'Une erreur est survenue.') ?></p>
            <p class="muted">Si vous venez d'installer le projet, importez d'abord <strong>database/schema.sql</strong>.</p>
            <a class="button" href="<?= e(url('home')) ?>">Reessayer</a>
        </section>
    </main>
</body>
</html>
