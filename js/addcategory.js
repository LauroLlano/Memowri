window.onload=load;

function load()
{
    let categoryName=document.getElementById("category-name");
    
    let submitButton=document.getElementById("addcategory-submit");
    let formCategory=document.getElementById("addcategory-form");

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
        alert("Submit has been made successfully");
        formCategory.submit();
    });

    formCategory.addEventListener("submit", e=>{
        
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

    //TODO: Will need further validations if same name of category already exists
    successField(field);
    return true;
}