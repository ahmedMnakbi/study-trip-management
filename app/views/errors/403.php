<?php $title = $title ?? 'Acces refuse'; ?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Acces refuse - <?= e(APP_NAME) ?></title>
    <link rel="stylesheet" href="<?= e(asset('assets/css/app.css')) ?>">
</head>
<body>
    <main class="page centered">
        <section class="panel">
            <h1>Acces refuse</h1>
            <p>Votre role ne permet pas d'acceder a cette page.</p>
            <a class="button" href="<?= e(url('home')) ?>">Retour a l'accueil</a>
        </section>
    </main>
</body>
</html>
