function createDivWithClass(className) {
    let div = document.createElement("div");
    div.classList.add(className);
    return div;
}

function addError(name, error) {
    hasError = true;
    if (document.querySelector("." + name) !== null) {
        $('.alert').remove();
    }
    let divError = createDivWithClass("current-error");
    $('#miss-' + name).prepend(divError);
    $('.current-error').addClass('alert');
    $('.current-error').addClass('alert-danger');
    $('.current-error').addClass(name);
    $('.current-error').text(error);
    $('.current-error').removeClass('current-error');
}

function verify(id, regex, format) {
    if (document.getElementById(id).required || document.getElementById(id).value !== "")
    {
        event.preventDefault();
        if (document.getElementById(id).validity.valueMissing) {   
            addError(id, "Élément manquant");
        }
        else if (regex.test((document.getElementById(id).value)) === false) {
            addError(id, format);
        }
    }
}

function verifyCheckbox(nameCheckbox) {
    let checked = false;
    for (let i = 0; i < document.getElementsByName(nameCheckbox).length; i++) {
        if (document.getElementsByName(nameCheckbox).item(i).checked) {
            checked = true;
            break;
        }
    }
    if (!checked) {
        addError(nameCheckbox, "Veuillez cocher une case");
    }
}

let hasError = false;
let typeError = 0;
$('#submit').on('click', function() {
    $("html, body").animate({scrollTop: 0},"slow");
    verify('surname', /^[a-zA-ZéèîïÉÈÎÏ][a-zéèêàçîï]*([-'\s][a-zA-ZéèîïÉÈÎÏ][a-zéèêàçîï]+)*$/, "Format incorrect. Caractères autorisées : lettres, apostrophes, tirets et espaces"); /* Source : https://jsbin.com/juhako/194/edit?html,output */
    verify('firstname', /^[a-zA-ZéèîïÉÈÎÏ][a-zéèêàçîï]*([-'\s][a-zA-ZéèîïÉÈÎÏ][a-zéèêàçîï]+)*$/, "Format incorrect. Caractères autorisées : lettres, apostrophes, tirets et espaces");
    verify('user_address', /./, "Format incorrect. Caractères autorisées : lettres, apostrophes, tirets et espaces");
    verify('postal_code', /^(([0-8][0-9])|(9[0-5]))[0-9]{3}$/, "Veuillez saisir un code postal valide.");
    verify('town', /^[a-zA-ZéèîïÉÈÎÏ][a-zéèêàçîï]*([-'\s][a-zA-ZéèîïÉÈÎÏ][a-zéèêàçîï]+)*$/, "Format incorrect. Caractères autorisées : lettres, apostrophes, tirets et espaces");
    verify('phone_number', /^0?[1-9]([-. ]?\d{2}){4}$/, "Veuillez saisir un numéro de téléphone valide.");
    verify('phone_number_office', /^0?[1-9]([-. ]?\d{2}){4}$/, "Veuillez saisir un numéro de téléphone valide.");
    verify('email', /^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/, "Veuillez saisir un courriel valide");
    verify('birthday', /(0[1-9]|[12][0-9]|3[01])[/](0[1-9]|1[012])[/](19\d\d|200\d)/, "Veuillez saisir une date de naissance valide.");
    verify('choir_name', /./, "Format incorrect. Caractères autorisées : lettres, apostrophes, tirets et espaces");
    verify('choir_town', /./, "Format incorrect. Caractères autorisées : lettres, apostrophes, tirets et espaces");
    verifyCheckbox('status');
    verifyCheckbox('music_stand');
    verifyCheckbox('payment');
    hasError = false;
});