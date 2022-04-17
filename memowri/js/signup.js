window.onload=load;

function load()
{
    let usernameField=document.getElementById('signup-username');
    let passwordField=document.getElementById('signup-password');
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
        //showSimpleModal("success", "User has been created succesfully!");
        alert("User has been created succesfully!");
        formSignup.submit();
    });

    formSignup.addEventListener("submit", e=>{
        
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



