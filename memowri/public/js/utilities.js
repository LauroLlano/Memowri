var activeModal;

function hideFieldMessage(field){
    field.parentNode.nextElementSibling.innerHTML="";
}

function showFieldMessage(field, message)
{
    let messageContainer=field.parentNode.nextElementSibling;

    let wrapper = document.createElement('div');
    let htmlText="";
    htmlText = '<div class="alert alert-danger d-flex align-items-center" role="alert">';
        htmlText+='<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-alert-triangle" width="28" height="28" viewBox="0 0 24 24" stroke-width="1.5" stroke="#842029" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 9v2m0 4v.01" /><path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75" /></svg>';
        htmlText+='<div>';
            htmlText+=message;
        htmlText+='</div>'
    htmlText+='</div>';

    wrapper.innerHTML=htmlText;

    messageContainer.append(wrapper)
}


function isMaxCharacters(field, maxChars)
{
    return (field.length>=maxChars);
}

function showSimpleModal(type, message)
{
    activeModal = new bootstrap.Modal(document.querySelector(".modal"), {
        backdrop: "static",
        keyboard:false
    });
    let modalFooter=document.getElementById("modal-footer");
    modalFooter.innerHTML=`<button type="button" class="btn btn-primary" id="modal-close" data-bs-dismiss="modal">Close</button>`;

    let modalTitle=document.getElementById("modal-title");
    let modalMessage=document.getElementById("modal-message");
    let modalButton=document.getElementById("modal-close");

    let modalHeader=modalTitle.parentNode;

    modalHeader.className=`modal-header ${type}`;



    switch(type){
        case "success":
            modalTitle.innerHTML="Success";
            modalButton.className='btn btn-success';
            break;
        case "primary":
            modalTitle.innerHTML="Information";
            modalButton.className='btn btn-primary';
            break;
        case "warning":
            modalTitle.innerHTML="Alert";
            modalButton.className='btn btn-warning';
            break;
        case "error":
        default:
            modalTitle.innerHTML="Error";
            modalButton.className='btn btn-danger';
    }

    modalMessage.innerHTML=message;

    activeModal.show();
}

function hideModal(){
    activeModal.hide();
}

function hideMultipleButtonModal(){
    document.getElementById("modal-accept").disabled=true;
    document.getElementById("modal-cancel").disabled=true;
    document.getElementById("modal-cross").disabled=true;
}

function activateModalCross(){
    document.getElementById("modal-cross").disabled=false;
}

function showMultipleButtonModal(type, message, acceptButtonText, cancelButtonText)
{

    activeModal = new bootstrap.Modal(document.querySelector(".modal"), {
        backdrop: "static",
        keyboard:false
    });

    let modalTitle=document.getElementById("modal-title");
    let modalMessage=document.getElementById("modal-message");
    let modalFooter=document.getElementById("modal-footer");
    let modalHeader=modalTitle.parentNode;

    modalHeader.className=`modal-header ${type}`;

    modalFooter.innerHTML=`<button type="button" class="btn btn-danger" id="modal-accept">${acceptButtonText}</button>`;
    modalFooter.innerHTML+=`<button type="button" class="btn btn-secondary" id="modal-cancel" data-bs-dismiss="modal">${cancelButtonText}</button>`;

    switch(type){
        case "success":
            modalTitle.innerHTML="Success";
            break;
        case "primary":
            modalTitle.innerHTML="Information";
            break;
        case "warning":
            modalTitle.innerHTML="Alert";
            break;
        case "error":
        default:
            modalTitle.innerHTML="Error";
    }

    modalMessage.innerHTML=message;

    activeModal.show();
}

function showModalAccept(type, message, acceptButtonText, link)
{

    activeModal = new bootstrap.Modal(document.querySelector(".modal"), {
        backdrop: "static",
        keyboard:false
    });

    let modalTitle=document.getElementById("modal-title");
    let modalMessage=document.getElementById("modal-message");
    let modalFooter=document.getElementById("modal-footer");
    let modalHeader=modalTitle.parentNode;

    modalHeader.className=`modal-header ${type}`;

    modalFooter.innerHTML=`<button type="button" class="btn btn-danger " id="modal-accept">${acceptButtonText}</button>`;

    switch(type){
        case "success":
            modalTitle.innerHTML="Success";
            break;
        case "primary":
            modalTitle.innerHTML="Information";
            break;
        case "warning":
            modalTitle.innerHTML="Alert";
            break;
        case "error":
        default:
            modalTitle.innerHTML="Error";
    }

    modalMessage.innerHTML=message;


    document.querySelector(".modal .btn-close").addEventListener("click", e=>{
        window.location=link;
    });

    document.getElementById("modal-accept").addEventListener("click", e=>{
        hideModal();
        window.location=link;
    });

    activeModal.show();
}

function errorField(field, message)
{
    hideFieldMessage(field);
    field.style.borderColor="#DC3545";
    showFieldMessage(field, message)
}

function successField(field)
{
    field.style.borderColor="#198754";
    hideFieldMessage(field);
}

function checkPassword(field, pass)
{
    let minSize=6;

    if(pass.length <minSize){
        errorField(field, "Password must be at least 6 characters");
        return false;
    }

    if(!pass.match(/[0-9]/))
    {
        errorField(field, "Password must have a number");
        return false;
    }

    if(!pass.match(/[A-Z]/))
    {
        errorField(field, "Password must have an uppercase letter");
        return false;
    }

    var checkSpecial=/[ `!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;
    if(!checkSpecial.test(pass))
    {
        errorField(field, "Password must have a special character");
        return false;
    }

    return true;
}

function toggleShowPassword(field, iconButton)
{
    const type = field.getAttribute('type') === 'password' ? 'text' : 'password';
    field.setAttribute('type', type);

    iconButton.classList.toggle('fa-eye-slash');
}

function isKeySpace(value)
{
    return value===" "
}

function readURL(input, imageID)
{
    if (input.files && input.files[0])
    {
        var reader = new FileReader();
        reader.onload = function (e)
        {
            var img = new Image();

            img.onload = function() {
                imageID.src=img.src;
            };
            img.src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function isFileImage(file)
{
    const validImageTypes = ['image/bmp', 'image/jpeg', 'image/png', 'image/jpeg'];
    if (!validImageTypes.includes(file['type']))
        return false;

    return true;
}

function errorProcessor(err){

    if(!err.status) //Server shutdown
    {
        showSimpleModal("error", err);
        return;
    }

    if(err.status==500) //Exception in server
    {
        err.json().then(exc=>{
            showSimpleModal("error", exc.message);
        });
        return;
    }

    //Validator response
    err.json().then(errorArray=>{
        let stringMessage="";
        Object.values(errorArray.errors).forEach(value => {
            stringMessage+="<p><b>"+value+"</b></p>";
        });
        if(stringMessage==="")
            stringMessage="An unknown error has ocurred. Try again later";
        showSimpleModal("error", stringMessage);
    });
}
