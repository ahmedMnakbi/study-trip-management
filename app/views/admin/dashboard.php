<section class="page-heading">
    <div>
        <p class="eyebrow">Administration</p>
        <h1>Tableau de bord</h1>
        <p class="lede">Vue generale des voyages, utilisateurs et inscriptions.</p>
    </div>
</section>

<section class="stats-grid">
    <article class="stat-card">
        <span>Total voyages</span>
        <strong><?= e((string) ($voyageStats['total'] ?? 0)) ?></strong>
    </article>
    <article class="stat-card">
        <span>En attente</span>
        <strong><?= e((string) ($voyageStats['en_attente'] ?? 0)) ?></strong>
    </article>
    <article class="stat-card">
        <span>Valides</span>
        <strong><?= e((string) ($voyageStats['valide'] ?? 0)) ?></strong>
    </article>
    <article class="stat-card">
        <span>Archives</span>
        <strong><?= e((string) ($voyageStats['archive'] ?? 0)) ?></strong>
    </article>
</section>

<section class="split-grid">
    <article class="panel">
        <h2>Utilisateurs par role</h2>
        <?php if ($userStats === []): ?>
            <p class="muted">Aucun utilisateur.</p>
        <?php else: ?>
            <ul class="simple-list">
                <?php foreach ($userStats as $row): ?>
                    <li><span><?= e($row['role']) ?></span><strong><?= e((string) $row['total']) ?></strong></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </article>

    <article class="panel">
        <h2>Inscriptions par voyage</h2>
        <?php if ($inscriptionStats === []): ?>
            <p class="muted">Aucune inscription.</p>
        <?php else: ?>
            <ul class="simple-list">
                <?php foreach ($inscriptionStats as $row): ?>
                    <li><span><?= e($row['titre']) ?> - <?= e($row['destination']) ?></span><strong><?= e((string) $row['total']) ?></strong></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </article>
</section>
