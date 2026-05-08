function messageErreur(messages) {
    if (messages.length > 0) {
        alert(messages.join('\n'));
        return true;
    }
    return false;
}

document.querySelectorAll('[data-form-register]').forEach(function (form) {
    form.addEventListener('submit', function (event) {
        var erreurs = [];
        var email = form.querySelector('input[type="email"]');
        var password = form.querySelector('input[type="password"]');

        if (email && email.value.indexOf('@') === -1) {
            erreurs.push('Email invalide.');
        }
        if (password && password.value.length < 6) {
            erreurs.push('Le mot de passe doit contenir au moins 6 caracteres.');
        }
        if (messageErreur(erreurs)) {
            event.preventDefault();
        }
    });
});

document.querySelectorAll('[data-min-length]').forEach(function (input) {
    var hint = document.querySelector('[data-password-hint]');
    input.addEventListener('input', function () {
        if (!hint) {
            return;
        }
        var reste = Math.max(6 - input.value.length, 0);
        hint.textContent = reste === 0 ? 'Mot de passe assez long.' : reste + ' caractere(s) restant(s).';
    });
});

document.querySelectorAll('[data-form-voyage]').forEach(function (form) {
    form.addEventListener('submit', function (event) {
        var erreurs = [];
        var depart = form.querySelector('[data-date-start]');
        var retour = form.querySelector('[data-date-end]');
        var places = form.querySelector('[data-positive-integer]');
        var budget = form.querySelector('[data-positive-number]');

        if (depart && retour && depart.value && retour.value && retour.value < depart.value) {
            erreurs.push('La date retour doit etre apres la date depart.');
        }
        if (places && Number(places.value) < 1) {
            erreurs.push('Le nombre de places doit etre positif.');
        }
        if (budget && Number(budget.value) < 0) {
            erreurs.push('Le budget ne peut pas etre negatif.');
        }
        if (messageErreur(erreurs)) {
            event.preventDefault();
        }
    });
});

document.querySelectorAll('[data-form-upload]').forEach(function (form) {
    form.addEventListener('submit', function (event) {
        var erreurs = [];
        var input = form.querySelector('[data-file]');
        var autorisees = ['pdf', 'jpg', 'jpeg', 'png'];

        if (input && input.files.length > 0) {
            var fichier = input.files[0];
            var extension = fichier.name.split('.').pop().toLowerCase();
            if (autorisees.indexOf(extension) === -1) {
                erreurs.push('Format refuse. Utilisez PDF, JPG, JPEG ou PNG.');
            }
            if (fichier.size > 5 * 1024 * 1024) {
                erreurs.push('Le fichier ne doit pas depasser 5 Mo.');
            }
        }
        if (messageErreur(erreurs)) {
            event.preventDefault();
        }
    });
});

document.querySelectorAll('[data-confirm]').forEach(function (button) {
    button.addEventListener('click', function (event) {
        if (!confirm(button.getAttribute('data-confirm'))) {
            event.preventDefault();
        }
    });
});

