window.onload=load;

function load()
{
    let categoryField=document.getElementById("addnote-category");
    let descriptionField=document.getElementById("addnote-description");

    let submitButton=document.getElementById("addnote-submit");
    let formNote=document.getElementById("addnote-form");

    descriptionField.addEventListener("keypress", e=>{
        if(isMaxCharacters(e.target.value, 255))
            e.preventDefault();
    });

    descriptionField.addEventListener("keyup", e=>{
        descriptionValidations(e.target);
    });

    submitButton.addEventListener("click", e=>{
        if(!areFieldsValidated(categoryField, descriptionField))
        {
            showSimpleModal("warning", "Complete the fields before proceeding");
            e.preventDefault();
            return false;
        }
        //showSimpleModal("success", "User has been created succesfully!");
        alert("Note has been created succesfully!");
        formNote.submit();
    });

    formNote.addEventListener("submit", e=>{

    });
}

function areFieldsValidated(fieldCat, fieldDesc)
{
    return descriptionValidations(fieldDesc) & (fieldCat.value!="");
}

function descriptionValidations(field)
{
    if(field.value.length===0){
        errorField(field, "Note cannot be empty");
        field.classList.remove("textSuccess");
        field.classList.add("textError");
        return false;
    }

    successField(field);
    field.classList.remove("textError");
    field.classList.add("textSuccess");
    return true;
}