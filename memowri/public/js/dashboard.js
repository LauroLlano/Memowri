window.onload=load;

var categorySelected;
var noteSelected;

var formNotes={};
var originalPlaceNote=null;

var canDrag=true;
function load()
{
    const notes = document.querySelectorAll('.note');
    const categories = document.querySelectorAll('.category');
    const deleteCategoryButtons=document.querySelectorAll('.deleteCategory');
    const deleteNoteButtons=document.querySelectorAll('.deleteNote');

    notes.forEach(note => {

        note.addEventListener('dragstart', ()=> {
            if(!canDrag)
                return;
            note.classList.add("dragging");
            canDrag=true;
            window.setTimeout(function (){ loadCategoriesAlerts(categories, note) }, 0);
        });

        note.addEventListener('dragend', ()=> {
            let form=note.querySelector(".notepatch");
            canDrag=false;
            updateOrder(form, formNotes, note);
        });

    });

    deleteCategoryButtons.forEach(button=>{
        button.addEventListener("click", ()=>{
            categorySelected=button.parentNode.parentNode.parentNode.parentNode;
            showMultipleButtonModal("warning", "Do you want to remove this category? (All notes in the category will be deleted!)", "Yes", "No");
            document.getElementById("modal-accept").addEventListener("click", ()=>{
                let formCategory=button.parentNode;
                deleteCategory(formCategory);
            });
        });
    });

    deleteNoteButtons.forEach(button=>{
        button.addEventListener("click", ()=>{
            noteSelected=button.parentNode.parentNode.parentNode.parentNode;
            showMultipleButtonModal("warning", "Do you want to remove this note?", "Yes", "No");
            document.getElementById("modal-accept").addEventListener("click", ()=>{

                let formNote=button.parentNode;
                deleteNote(formNote);
            });
        });
    });

    categories.forEach(category=>{

        category.addEventListener("dragover", e=> {

            e.preventDefault();

            if(!canDrag)
                return;

            const draggable=document.querySelector(".dragging");
            if(draggable==null)
                return;
            const afterElement=getDragAfterElement(category, e.clientY);


            if(afterElement==null){
                let noteAlert=category.querySelector(".noteAlert");

                formNotes={
                        position: "after",
                        id_category: category.getAttribute("value"),
                        id_after: '0'
                    };
                if(noteAlert==null)
                    category.appendChild(draggable);
                else
                    category.insertBefore(draggable, noteAlert);
            }
            else{
                formNotes={
                        position: "before",
                        id_category: category.getAttribute("value"),
                        id_after: afterElement.getAttribute('value')
                    };
                category.insertBefore(draggable, afterElement);
            }
        });
    });
}

function getDragAfterElement(container, y)
{
    const draggableElements=[...container.querySelectorAll('.note:not(.dragging)')];

    return draggableElements.reduce((closest, child)=>{
        let box=child.getBoundingClientRect();
        let offset=y-box.top -box.height / 2;
        if(offset<0 && offset>closest.offset)
        {
            return{offset:offset, element:child}
        }
        else{
            return closest;
        }
    },{offset:Number.NEGATIVE_INFINITY}).element;
}

function deleteNote(form)
{
    fetch(form.action, {
        method: form.querySelector("input[name='_method']").value,
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'url': form.action,
            'X-CSRF-Token': form.querySelector("input[name='_token']").value
        }
    })
    .then(res=>{
        if(!res.ok)
            throw res;
        return res.json();
    })
    .then(text=>{
        hideModal();

        if(text.status!="success"){
            showSimpleModal(text.status, text.message);
            return;
        }

        noteSelected.remove();
        showSimpleModal("success", text.message);
        noteSelected=null;
    })
    .catch(err=>{
        err.text().then(errorArray=>{
            hideModal();
            const arr=JSON.parse(errorArray);
            let stringMessage="";

            Object.values(arr.errors).forEach(value=>{
                stringMessage+="<p><b>"+value+"</b></p>";
            });

            if(stringMessage==="")
                stringMessage="An unknown error has ocurred. Try again later";

            showSimpleModal("error", stringMessage);
            noteSelected=null;
        });
    });
}

function deleteCategory(form)
{
    fetch(form.action, {
        method: form.querySelector("input[name='_method']").value,
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'url': form.action,
            'X-CSRF-Token': form.querySelector("input[name='_token']").value
        }
    })
    .then(res=>{
        if(!res.ok)
            throw res;
        return res.json();
    })
    .then(text=>{
        hideModal();

        if(text.status!="success"){
            showSimpleModal(text.status, text.message);
            return;
        }

        categorySelected.remove();
        showSimpleModal("success", text.message);
        categorySelected=null;
        noteSelected=null;
    })
    .catch(err=>{
        err.text().then(errorArray=>{
            hideModal();
            const arr=JSON.parse(errorArray);
            let stringMessage="";

            Object.values(arr.errors).forEach(value=>{
                stringMessage+="<p><b>"+value+"</b></p>";
            });

            if(stringMessage==="")
                stringMessage="An unknown error has ocurred. Try again later";

            showSimpleModal("error", stringMessage);
            noteSelected=null;
        });
    });
}


function updateOrder(form, formData, note){
    fetch(form.action, {
        method: form.querySelector("input[name='_method']").value,
        body: JSON.stringify(formData),
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'url': form.action,
            'X-CSRF-Token': form.querySelector("input[name='_token']").value
        }
    })
    .then(res=>{
        if(!res.ok)
            throw res;
        return res.json();
    })
    .then(text=>{

        note.classList.remove("dragging");

        const noteAlerts=document.getElementsByClassName("noteAlert");
        while(noteAlerts.length>0)
            noteAlerts[0].remove();

        canDrag=true;
        if(text.status!="success"){
            originalPlaceNote.parentNode.insertBefore(note, originalPlaceNote);
            showSimpleModal(text.status, text.message);
            return;
        }

    })
    .catch(err=>{

        note.classList.remove("dragging");
        const noteAlerts=document.getElementsByClassName("noteAlert");
        while(noteAlerts.length>0)
            noteAlerts[0].remove();

        originalPlaceNote.parentNode.insertBefore(note, originalPlaceNote);

        errorProcessor(err);
    });
}

function loadCategoriesAlerts(categories, note){
    let noteAlertHtml='<div class="noteAlert"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-drag-drop" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19 11v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2" /><path d="M13 13l9 3l-4 2l-2 4l-3 -9" /><line x1="3" y1="3" x2="3" y2="3.01" /><line x1="7" y1="3" x2="7" y2="3.01" /><line x1="11" y1="3" x2="11" y2="3.01" /><line x1="15" y1="3" x2="15" y2="3.01" /><line x1="3" y1="7" x2="3" y2="7.01" /><line x1="3" y1="11" x2="3" y2="11.01" /><line x1="3" y1="15" x2="3" y2="15.01" /></svg>Drag an item to change its category</div>';
    categories.forEach(category=>{
        category.insertAdjacentHTML('beforeend', noteAlertHtml);
    });
    originalPlaceNote=note.nextSibling;
}
