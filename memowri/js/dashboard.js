window.onload=load;

var categorySelected;
var noteSelected;
function load()
{
    const notes = document.querySelectorAll('.note');
    const categories = document.querySelectorAll('.category');
    const deleteCategoryButtons=document.querySelectorAll('.deleteCategory');
    const deleteNoteButtons=document.querySelectorAll('.deleteNote');

    notes.forEach(note => {
        note.addEventListener('dragstart', ()=> {
            note.classList.add("dragging");
            let noteAlertHtml='<div class="noteAlert"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-drag-drop" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19 11v-2a2 2 0 0 0 -2 -2h-8a2 2 0 0 0 -2 2v8a2 2 0 0 0 2 2h2" /><path d="M13 13l9 3l-4 2l-2 4l-3 -9" /><line x1="3" y1="3" x2="3" y2="3.01" /><line x1="7" y1="3" x2="7" y2="3.01" /><line x1="11" y1="3" x2="11" y2="3.01" /><line x1="15" y1="3" x2="15" y2="3.01" /><line x1="3" y1="7" x2="3" y2="7.01" /><line x1="3" y1="11" x2="3" y2="11.01" /><line x1="3" y1="15" x2="3" y2="15.01" /></svg>Drag an item to change its category</div>';
            categories.forEach(category=>{
                category.insertAdjacentHTML('beforeend', noteAlertHtml);
            });
        });

        note.addEventListener('dragend', ()=> {
            note.classList.remove("dragging");
            const noteAlerts=document.getElementsByClassName("noteAlert");
            while(noteAlerts.length>0)
                noteAlerts[0].remove();
        });

    });

    deleteCategoryButtons.forEach(button=>{
        button.addEventListener("click", ()=>{
            categorySelected=button.parentNode.parentNode.parentNode;
            showMultipleButtonModal("warning", "Do you want to remove this category? (All notes in the category will be deleted!)", "Yes", "No");
            document.getElementById("modal-accept").addEventListener("click", ()=>{
                //let rowCount=document.querySelectorAll('.categoryRow').length;
                //let categoryCount=document.querySelectorAll('.category').length;

                //TODO: SUBMIT DELETE
                hideModal();
                categorySelected.remove();
                showSimpleModal("success", "The category has been removed successfully!");
                categorySelected=null;
                noteSelected=null;
            });
        });
    });

    deleteNoteButtons.forEach(button=>{
        button.addEventListener("click", ()=>{
            noteSelected=button.parentNode.parentNode.parentNode;
            showMultipleButtonModal("warning", "Do you want to remove this note?", "Yes", "No");
            document.getElementById("modal-accept").addEventListener("click", ()=>{
                
                //TODO: SUBMIT DELETE
                hideModal();
                noteSelected.remove();
                showSimpleModal("success", "The note has been removed successfully!");
                noteSelected=null;
            });
        });
    });

    categories.forEach(category=>{

        category.addEventListener("dragover", e=> {
            e.preventDefault();

            const afterElement=getDragAfterElement(category, e.clientY);
            const draggable=document.querySelector(".dragging");
            if(afterElement==null){
                let noteAlert=category.querySelector(".noteAlert");
                if(noteAlert==null)
                    category.appendChild(draggable);
                else
                    category.insertBefore(draggable, noteAlert);
            } 
            else{
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