function validateForm() {
    var name = document.getElementById('name').value;
    var prenom = document.getElementById('prenom').value;
    var email = document.getElementById('email').value;
    var telephone = document.getElementById('telephone').value;
    var message = document.getElementById('message').value;

    if (name == "" || prenom == "" || email == "" || telephone == "" || message == "") {
        alert("Tous les champs doivent être remplis");
        return false;
    }

    var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    if (!emailPattern.test(email)) {
        alert("Veuillez entrer une adresse email valide");
        return false;
    }

    var phonePattern = /^[0-9]{10}$/;
    if (!phonePattern.test(telephone)) {
        alert("Veuillez entrer un numéro de téléphone valide (10 chiffres)");
        return false;
    }

    return true;
}

function validateForm() {
    var form = document.getElementById('announceForm');
    var inputs = form.querySelectorAll('input[required], textarea[required]');
    for (var i = 0; i < inputs.length; i++) {
        if (inputs[i].value.trim() === '') {
            alert('Veuillez remplir tous les champs obligatoires.');
            return false;
        }
    }
    return true;
}