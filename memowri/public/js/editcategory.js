window.onload=load;

function load()
{
    let categoryName=document.getElementById("category-name");

    let submitButton=document.getElementById("editcategory-submit");
    let formCategory=document.getElementById("editcategory-form");

    categoryName.addEventListener("keypress", e=>{
        if(isMaxCharacters(e.target.value, 30))
            e.preventDefault();
    });

    categoryName.addEventListener("keyup", e=>{
        nameValidations(e.target);
    });

    submitButton.addEventListener("click", e=>{
        if(!isNameValidated(categoryName)){
            showSimpleModal("warning", "Complete the fields before proceeding");
            e.preventDefault();
            return false;
        }
        document.getElementById("editcategory-submit").disabled=true;
        submitForm(formCategory, categoryName.value);
    });

}

function isNameValidated(nameField)
{
   return nameValidations(nameField)
}


function nameValidations(field)
{
    if(field.value.length===0){
        errorField(field, "Category name cannot be empty");
        return false;
    }
    successField(field);
    return true;
}

function submitForm(form, categoryName)
{
    let dataForm={
        name: categoryName
    };

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
        document.getElementById("editcategory-submit").disabled=false;
        if(text.status!="success"){
            showSimpleModal(text.status, text.message);
            return;
        }
        showModalAccept("success", text.message, "Continue", "/");
    })
    .catch(err=>{
        document.getElementById("editcategory-submit").disabled=false;
        errorProcessor(err);
    });
}
