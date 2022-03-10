window.onload=load;

function load()
{
    let usernameField=document.getElementById('login-username');
    let passwordField=document.getElementById('login-password');
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
        formLogin.submit();
    });

    formLogin.addEventListener("submit", e=>{
        
    });
}


function areFieldsEmpty(userField, passField)
{
    if(userField.length===0 || passField.length===0)
        return true;
    return false;
}