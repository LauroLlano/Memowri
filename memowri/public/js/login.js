window.onload=load;

function load()
{
    let usernameField=document.getElementById('username');
    let passwordField=document.getElementById('password');
    let passwordToggle=document.getElementById('login-togglePassword');

    let formLogin=document.getElementById('login-form');

    passwordToggle.addEventListener("click", e => {
        let type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);

        passwordToggle.classList.toggle('fa-eye-slash');
    });

    document.getElementById("login-submit").addEventListener("click", e=>{
        if(areFieldsEmpty(usernameField.value, passwordField.value))
        {
            showSimpleModal("warning", "Complete the fields before proceeding");
            e.preventDefault();
            return false;
        }

        submitForm(formLogin, usernameField.value, passwordField.value);
    });
}


function areFieldsEmpty(userField, passField)
{
    if(userField.length===0 || passField.length===0)
        return true;
    return false;
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
         if(text.status!="success"){
            showSimpleModal(text.status, text.message);
            return;
        }
        window.location="./";
    })
    .catch(err=>{
        errorProcessor(err);
    });
}
