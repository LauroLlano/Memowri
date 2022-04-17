window.onload=load;

function load()
{
    let oldPassword=document.getElementById("edit-oldpassword");
    let newPassword=document.getElementById("edit-password");
    let toggleOldPassword=document.getElementById("edit-toggleOldPassword");
    let toggleNewPassword=document.getElementById("edit-togglePassword");

    let submitButton=document.getElementById("editaccount-submit");
    let editForm=document.getElementById("editaccount-form");

    oldPassword.addEventListener("keypress", e=>{
        if(isMaxCharacters(e.target.value, 50))
            e.preventDefault();
    });

    newPassword.addEventListener("keypress", e=>{
        if(isMaxCharacters(e.target.value, 50))
            e.preventDefault();
    });

    oldPassword.addEventListener("keyup", e=>{
        oldPasswordValidations(e.target);
    });

    newPassword.addEventListener("keyup", e=>{
        newPasswordValidations(e.target);
    });

    toggleOldPassword.addEventListener("click", e=>{
        toggleShowPassword(oldPassword, e.target);
    });

    toggleNewPassword.addEventListener("click", e=>{
        toggleShowPassword(newPassword, e.target);
    });

    submitButton.addEventListener("click", e=>{
        if(!areFieldsValidated(oldPassword, newPassword))
        {
            showSimpleModal("warning", "Complete the fields before proceeding");
            e.preventDefault();
            return false;
        }
        
        alert("Form has been sent");
        editForm.submit();
    });

    editForm.addEventListener("submit", e=>{

    });

}

function areFieldsValidated(oldPass, newPass){
    return oldPasswordValidations(oldPass) & newPasswordValidations(newPass);
}

function oldPasswordValidations(field)
{
    if(field.value.length===0){
        errorField(field, "Field cannot be empty");
        return false;
    }    
    
    successField(field);
    return true;
}

function newPasswordValidations(field)
{
    if(field.value.length===0){
        errorField(field, "Field cannot be empty");
        return false;
    }

     if(!checkPassword(field, field.value))
        return false;
    
    successField(field);
    return true;
}