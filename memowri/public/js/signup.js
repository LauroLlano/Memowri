window.onload=load;

function load()
{
    let usernameField=document.getElementById('username');
    let passwordField=document.getElementById('password');
    let passwordToggle=document.getElementById('signup-togglePassword');

    let formSignup=document.getElementById("signup-form");

    usernameField.addEventListener("keypress", e => {
        if(isKeySpace(e.key) || isMaxCharacters(e.target.value, 30))
            e.preventDefault();
    });

    usernameField.addEventListener("keyup", e => {
        usernameValidations(e.target);
    });

    passwordField.addEventListener("keypress", e => {
        if(isMaxCharacters(e.target.value, 50))
            e.preventDefault();
    });

    passwordField.addEventListener("keyup", e => {
        passwordValidations(e.target)
    });

    passwordToggle.addEventListener("click", e => {
        toggleShowPassword(passwordField, e.target);
    });

    document.getElementById("signup-submit").addEventListener("click", e=>{
        if(!areFieldsValidated(usernameField, passwordField))
        {
            showSimpleModal("warning", "Complete the fields before proceeding");
            e.preventDefault();
            return false;
        }
        document.getElementById("signup-submit").disabled=true;
        submitForm(formSignup, usernameField.value, passwordField.value);
    });
}

function areFieldsValidated(nameField, passField)
{
    return usernameValidations(nameField) & passwordValidations(passField)
}

function usernameValidations(field)
{
    if(field.value.length===0){
        errorField(field, "Username cannot be empty");
        return false;
    }

    if(field.value.length<6){
        errorField(field, "Username must have at least 6 characters");
        return false;
    }

    successField(field);
    return true;
}

function passwordValidations(field)
{
    if(field.value.length===0){
        errorField(field, "Password cannot be empty");
        return false;
    }

    if(!checkPassword(field, field.value))
        return false;


    successField(field);
    return true;
}



function submitForm(form, username, password)
{
    let dataForm={
        "username": username,
        "password": password
    };

    fetch(form.action, {
        method: form.method,
        body: JSON.stringify(dataForm),
        headers:{
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'url': form.action,
            "X-CSRF-Token": document.querySelector('input[name=_token]').value
        }
    })
    .then((res) =>{
        if(!res.ok)
            throw res;
        return res.json();
    })
    .then((text)=>{
        document.getElementById("signup-submit").disabled=false;
        if(text.status!="success"){
            showSimpleModal(text.status, text.message);
            return;
        }
        showModalAccept("success", text.message, "Continue", "./");
    })
    .catch(err=>{
        document.getElementById("signup-submit").disabled=false;
        errorProcessor(err);
    });
}


