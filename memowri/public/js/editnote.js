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
        document.getElementById("editnote-form").disabled=true;
        submitForm(formNote, categoryField.value, descriptionField.value);
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

function submitForm(form, category, noteDescription)
{
    let dataForm={
        id_category: category,
        text: noteDescription
    }

    fetch(form.action, {
        method: document.querySelector("input[name='_method']").value,
        body: JSON.stringify(dataForm),
        headers: {
            'Content-type': 'application/json',
            'Accept': 'application/json',
            'url': form.action,
            'X-CSRF-Token': document.querySelector("input[name='_token']").value
        }
    })
    .then(res=>{
        if(!res.ok)
            throw res;
        return res.json();
    })
    .then(text=>{
        document.getElementById("editnote-form").disabled=false;
        if(text.status!="success"){
            showSimpleModal(text.status, text.message);
            return;
        }

        showModalAccept('success', text.message, 'Continue', "/");
    })
    .catch(err=>{
        document.getElementById("editnote-form").disabled=false;
        errorProcessor(err);
    })
}
