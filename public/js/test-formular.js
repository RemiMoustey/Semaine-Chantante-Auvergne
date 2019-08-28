function verify(id, regex, format)
{
    if (document.getElementById(id).required || document.getElementById(id).value !== "")
    {
        if (document.getElementById(id).validity.valueMissing) {
            event.preventDefault();
            $('#miss-' + id).text('Élément manquant.');
        }
        else if (regex.test((document.getElementById(id).value)) === false) {
            event.preventDefault();
            $('#miss-' + id).text(format);
        }
    }
}

$('#submit').on('click', function() {
    verify('surname', /^[a-zA-ZéèîïÉÈÎÏ][a-zéèêàçîï]*([-'\s][a-zA-ZéèîïÉÈÎÏ][a-zéèêàçîï]+)*$/, "Format incorrect. Caractères autorisées : lettres, apostrophes, tirets et espaces"); /* Source : https://jsbin.com/juhako/194/edit?html,output */
    verify('firstname', /^[a-zA-ZéèîïÉÈÎÏ][a-zéèêàçîï]*([-'\s][a-zA-ZéèîïÉÈÎÏ][a-zéèêàçîï]+)*$/, "Format incorrect. Caractères autorisées : lettres, apostrophes, tirets et espaces");
    verify('postal_code', /^(([0-8][0-9])|(9[0-5]))[0-9]{3}$/, "Veuillez saisir un code postal valide.");
    verify('town', /^[a-zA-ZéèîïÉÈÎÏ][a-zéèêàçîï]*([-'\s][a-zA-ZéèîïÉÈÎÏ][a-zéèêàçîï]+)*$/, "Format incorrect. Caractères autorisées : lettres, apostrophes, tirets et espaces");
    verify('phone_number', /^0?[1-9]([-. ]?\d{2}){4}$/, "Veuillez saisir un numéro de téléphone valide.");
    verify('phone_number_office', /^0?[1-9]([-. ]?\d{2}){4}$/, "Veuillez saisir un numéro de téléphone valide.");
    verify('email', /^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/, "Veuillez saisir un courriel valide");
    verify('birthday', /^([1-31]|0?\d{1})\/([1-31]|0?\d{1})\/(19|20\d{2})$/, "Veuillez saisir une date de naissance valide"); //A refaire
});