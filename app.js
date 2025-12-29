// Validation côté client pour login
function validateLogin() {
    console.log('Validating login...');
    try {
        var email = document.getElementById('id_email').value;
        var pw = document.getElementById('id_pass').value;
        if (email == null || email == "" || pw == null || pw == "") {
            alert("Both fields must be filled out");
            return false;
        }
        if (email.indexOf('@') == -1) {
            alert("Email must have an at-sign (@)");
            return false;
        }
        return true;
    } catch(e) {
        return false;
    }
}

// Validation côté client pour add/edit profile
function validateProfile() {
    console.log('Validating profile...');
    try {
        var fields = ['first_name','last_name','email','headline','summary'];
        for (var i=0;i<fields.length;i++) {
            var val = document.getElementById('id_'+fields[i]).value;
            if (val == null || val.trim() == "") {
                alert("Tous les champs sont obligatoires");
                return false;
            }
        }
        var emailVal = document.getElementById('id_email').value;
        if (emailVal.indexOf('@') == -1) {
            alert("L'adresse électronique doit contenir @");
            return false;
        }
        return true;
    } catch(e) {
        return false;
    }
}
