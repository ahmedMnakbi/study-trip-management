<section class="travel-hero">
    <div class="travel-hero-copy">
        <p class="eyebrow">Voyages d'etudes</p>
        <h1>Explorez les sorties pedagogiques ouvertes</h1>
        <p class="lede">Consultez les voyages valides, verifiez les places disponibles et envoyez votre demande d'inscription.</p>
        <form class="search-form hero-search" method="get" action="<?= e($_SERVER['SCRIPT_NAME']) ?>">
            <input type="hidden" name="route" value="voyages">
            <label class="sr-only" for="q">Recherche</label>
            <input id="q" data-live-search type="search" name="q" value="<?= e($search ?? '') ?>" placeholder="Rechercher une destination ou un titre">
            <button class="button secondary" type="submit">Rechercher</button>
        </form>
        <p class="js-hint" data-search-count></p>
    </div>
    <img src="<?= e(asset('assets/img/campus-hero.jpg')) ?>" alt="Etudiants sur un campus universitaire">
</section>

<?php if ($voyages === []): ?>
    <section class="empty-state">
        <h2>Aucun voyage disponible</h2>
        <p>Les voyages valides apparaitront ici apres validation par l'administrateur.</p>
    </section>
<?php else: ?>
    <section class="cards-grid" data-card-list>
        <?php foreach ($voyages as $voyage): ?>
            <article
                class="travel-card destination-card"
                data-search-card
                data-search-text="<?= e(strtolower($voyage['titre'] . ' ' . $voyage['destination'] . ' ' . $voyage['description'])) ?>"
            >
                <img src="<?= e(asset('assets/img/travel-card.jpg')) ?>" alt="Paysage de voyage d'etudes">
                <div>
                    <span class="badge <?= e($voyage['statut']) ?>"><?= e(status_label($voyage['statut'])) ?></span>
                    <h2><?= e($voyage['titre']) ?></h2>
                    <p class="destination"><?= e($voyage['destination']) ?></p>
                    <p><?= e(excerpt($voyage['description'])) ?></p>
                </div>

                <dl class="meta-grid">
                    <div>
                        <dt>Depart</dt>
                        <dd><?= e($voyage['date_depart']) ?></dd>
                    </div>
                    <div>
                        <dt>Places</dt>
                        <dd><?= e((string) $voyage['places_restantes']) ?>/<?= e((string) $voyage['nb_places']) ?></dd>
                    </div>
                    <div>
                        <dt>Budget</dt>
                        <dd><?= e(number_format((float) $voyage['budget'], 2)) ?> TND</dd>
                    </div>
                </dl>

                <a class="button" href="<?= e(url('voyage/show', ['id' => $voyage['id_voyage']])) ?>">Voir details</a>
            </article>
        <?php endforeach; ?>
    </section>
    <section class="empty-state hidden" data-no-results>
        <h2>Aucun resultat</h2>
        <p>Essayez une autre destination ou un autre titre.</p>
    </section>
<?php endif; ?>
