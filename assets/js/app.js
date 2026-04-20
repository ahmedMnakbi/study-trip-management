const toggle = document.querySelector('[data-menu-toggle]');
const menu = document.querySelector('[data-menu]');

if (toggle && menu) {
    toggle.addEventListener('click', () => {
        menu.classList.toggle('open');
    });
}

const liveSearch = document.querySelector('[data-live-search]');
const cards = Array.from(document.querySelectorAll('[data-search-card]'));
const noResults = document.querySelector('[data-no-results]');
const searchCount = document.querySelector('[data-search-count]');

function updateLiveSearch() {
    if (!liveSearch || cards.length === 0) {
        return;
    }

    const query = liveSearch.value.trim().toLowerCase();
    let visibleCount = 0;

    cards.forEach((card) => {
        const text = card.dataset.searchText || '';
        const isVisible = text.includes(query);
        card.classList.toggle('hidden', !isVisible);

        if (isVisible) {
            visibleCount += 1;
        }
    });

    if (noResults) {
        noResults.classList.toggle('hidden', visibleCount > 0);
    }

    if (searchCount) {
        searchCount.textContent = query === ''
            ? `${visibleCount} voyage(s) disponible(s).`
            : `${visibleCount} resultat(s) trouve(s).`;
    }
}

if (liveSearch) {
    liveSearch.addEventListener('input', updateLiveSearch);
    updateLiveSearch();
}

document.querySelectorAll('[data-toggle-password]').forEach((button) => {
    button.addEventListener('click', () => {
        const target = document.getElementById(button.dataset.togglePassword);

        if (!target) {
            return;
        }

        const shouldShow = target.type === 'password';
        target.type = shouldShow ? 'text' : 'password';
        button.textContent = shouldShow ? 'Masquer' : 'Afficher';
    });
});

document.querySelectorAll('[data-min-length]').forEach((input) => {
    const hint = document.querySelector('[data-password-hint]');
    const minLength = Number(input.dataset.minLength || 0);

    input.addEventListener('input', () => {
        if (!hint) {
            return;
        }

        const remaining = Math.max(minLength - input.value.length, 0);
        hint.textContent = remaining === 0
            ? 'Mot de passe assez long.'
            : `${remaining} caractere(s) restant(s).`;
        hint.classList.toggle('ok', remaining === 0);
    });
});

document.querySelectorAll('[data-character-count]').forEach((textarea) => {
    const form = textarea.closest('form');
    const output = form ? form.querySelector('[data-character-output]') : null;
    const target = Number(textarea.dataset.characterCount || 0);

    function updateCount() {
        if (!output || target === 0) {
            return;
        }

        const count = textarea.value.trim().length;
        output.textContent = `${count}/${target} caracteres recommandes.`;
        output.classList.toggle('ok', count >= Math.min(target, 80));
    }

    textarea.addEventListener('input', updateCount);
    updateCount();
});

document.querySelectorAll('[data-file-check]').forEach((input) => {
    const form = input.closest('form');
    const hint = form ? form.querySelector('[data-file-hint]') : null;
    const allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png'];
    const maxSize = 5 * 1024 * 1024;

    input.addEventListener('change', () => {
        if (!hint || !input.files || input.files.length === 0) {
            return;
        }

        const file = input.files[0];
        const extension = file.name.split('.').pop().toLowerCase();
        const sizeMo = (file.size / (1024 * 1024)).toFixed(2);

        if (!allowedExtensions.includes(extension)) {
            hint.textContent = 'Format invalide. Utilisez PDF, JPG, JPEG ou PNG.';
            hint.classList.remove('ok');
            return;
        }

        if (file.size > maxSize) {
            hint.textContent = `Fichier trop grand : ${sizeMo} Mo. Maximum : 5 Mo.`;
            hint.classList.remove('ok');
            return;
        }

        hint.textContent = `${file.name} selectionne (${sizeMo} Mo).`;
        hint.classList.add('ok');
    });
});

document.querySelectorAll('[data-validate-voyage]').forEach((form) => {
    form.addEventListener('submit', (event) => {
        const start = form.querySelector('[data-date-start]');
        const end = form.querySelector('[data-date-end]');
        const places = form.querySelector('[data-positive-integer]');
        const budget = form.querySelector('[data-positive-number]');
        const errors = [];

        if (start && end && start.value && end.value && end.value < start.value) {
            errors.push('La date retour doit etre apres la date depart.');
        }

        if (places && Number(places.value) < 1) {
            errors.push('Le nombre de places doit etre positif.');
        }

        if (budget && Number(budget.value) < 0) {
            errors.push('Le budget ne peut pas etre negatif.');
        }

        if (errors.length > 0) {
            event.preventDefault();
            alert(errors.join('\n'));
        }
    });
});

document.querySelectorAll('form[data-confirm]').forEach((form) => {
    form.addEventListener('submit', (event) => {
        const message = form.dataset.confirm || 'Confirmer cette action ?';

        if (!confirm(message)) {
            event.preventDefault();
        }
    });
});
