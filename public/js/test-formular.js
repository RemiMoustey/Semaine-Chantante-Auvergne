function createDivWithClass(className) {
    let div = document.createElement("div");
    div.classList.add(className);
    return div;
}

function addError(name, error) {
    if (document.querySelector("." + name) !== null) {
        $('.alert').remove();
    }
    let divError = createDivWithClass("current-error");
    $('#miss-' + name).prepend(divError);
    $('.current-error').addClass('alert');
    $('.current-error').addClass('alert-danger');
    $('.current-error').addClass(name + "-alert");
    $('.current-error').text(error);
    $('.current-error').removeClass('current-error');
}

function verifyText(id, regex, message) {
    if ($('.' + id + '-alert').length !== 0) {
        $('.' + id + '-alert').remove();
    }
    if (document.getElementById(id).required || document.getElementById(id).value !== "")
    {
        if (document.getElementById(id).validity.valueMissing) {   
            addError(id, "Élément manquant");
        }
        else if (regex.test((document.getElementById(id).value)) === false) {
            addError(id, message);
        }
    }
}

function verifyCheckbox(nameCheckbox, message) {
    for (let i = 0; i < document.getElementsByName(nameCheckbox).length; i++) {
        if (document.getElementsByName(nameCheckbox).item(i).checked) {
            checked = true;
            break;
        }
    }
    addError(nameCheckbox, message);
}

function verify(type, name, regex, message) {
    if (type === "text" || type === 'number' || type === 'tel' || type==='email'  || type==='date') {
        $('#' + name).on('keyup', function(e) {
            e.preventDefault();
            verifyText(name, regex, message); /* Source : https://jsbin.com/juhako/194/edit?html,output */
        });
    }
    else if (type === 'radio') {
        $('#' + name).on("change", function(e) {
            e.preventDefault();
            verifyCheckbox(name, message);
        });
    }
}

let currentError = 'Format incorrect. Caractères autorisées : lettres, espaces, apostrophes et tirets.';

verify('text', 'surname', /^[a-zA-ZéèîïÉÈÎÏ][a-zéèêàçîï]*([-'\s]|[a-zA-ZéèîïÉÈÎÏ]|[a-zéèêàçîï])*$/, currentError);
verify('text', 'firstname', /^[a-zA-ZéèîïÉÈÎÏ][a-zéèêàçîï]*([-'\s]|[a-zA-ZéèîïÉÈÎÏ]|[a-zéèêàçîï])*$/, currentError);
verify('password', 'password', /./, currentError);
verify('text', 'user_address', /./, currentError);
verify('number', 'postal_code', /^(([0-8][0-9])|(9[0-5]))[0-9]{3}$/, "Veuillez saisir un code postal valide.");
verify('text', 'town', /^[a-zA-ZéèîïÉÈÎÏ][a-zéèêàçîï]*([-'\s]|[a-zA-ZéèîïÉÈÎÏ]|[a-zéèêàçîï])*$/, currentError);
verify('tel', 'phone_number', /^0?[1-9]([-. ]?\d{2}){4}$/, "Veuillez saisir un numéro de téléphone valide.");
verify('tel', 'phone_number_office', /^0?[1-9]([-. ]?\d{2}){4}$/, "Veuillez saisir un numéro de téléphone valide.");
verify('email', 'email', /^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/, "Veuillez saisir un email valide");
verify('date', 'birthday', /^(19\d\d|20[0|1]\d)-([0|1])\d-([0-3])\d/, "Veuillez saisir une date de naissance valide.");
verify('text', 'choir_name', /./, currentError);
verify('text', 'choir_town', /./, currentError);
verifyCheckbox('radio', 'status', /./, 'Veuillez cocher une option');
verifyCheckbox('radio', 'music_stand', /./, 'Veuillez cocher une option');
verifyCheckbox('radio', 'payment', /./, 'Veuillez cocher une option');

function testInputs() {
    let pass = true;
    
    $('input[required]').each(function(){
        if ($(this).val()=== "" || $('.alert').length !== 0) {
            pass = false;
            return false;
        }
    });
    if (pass && $('input:checked').length === 3 || pass && document.location.href.indexOf('readuser') !== -1) {
        $('.submit').removeAttr('disabled');
    }
    else {
        $('.submit').attr('disabled', '');
    } 
}
  
$(document).ready(function () {
    testInputs();
    $('input').on("keyup", function () {
        testInputs();
    });
    $(document).on("focus", function () {
        testInputs();
    });
    $(document).on("click", function () {
        testInputs();
    });
});