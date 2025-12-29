function validateLogin() {
    let email = document.getElementById('id_email').value;
    let pw = document.getElementById('id_pass').value;
    if(email == "" || pw == "") {
        alert("Both fields must be filled out");
        return false;
    }
    if(email.indexOf('@') == -1){
        alert("Email must contain @");
        return false;
    }
    return true;
}

function validateProfile() {
    let fn = document.getElementById('id_first_name').value;
    let ln = document.getElementById('id_last_name').value;
    let em = document.getElementById('id_email').value;
    let he = document.getElementById('id_headline').value;
    let su = document.getElementById('id_summary').value;

    if(fn=="" || ln=="" || em=="" || he=="" || su=="") {
        alert("All fields are required");
        return false;
    }
    if(em.indexOf('@') == -1) {
        alert("Email must contain @");
        return false;
    }
    return true;
}
