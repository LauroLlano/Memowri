window.onload=load;

function load()
{
    let categoryField=document.getElementById("editnote-category");
    let descriptionField=document.getElementById("editnote-description");

    let submitButton=document.getElementById("editnote-submit");
    let formNote=document.getElementById("editnote-form");

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

        alert("Note has been updated succesfully!");
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