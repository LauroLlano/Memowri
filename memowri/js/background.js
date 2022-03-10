window.onload=load;

function load()
{
    loadColor();
    let fileBtn = document.getElementById('actual-btn');
    let fileChosen = document.getElementById('file-chosen');
    let imageContainer=document.getElementById('image-front');
    let submitButton=document.getElementById('background-submit');
    let backgroundForm=document.getElementById('background-form');

    imageContainer.src="";

    fileBtn.addEventListener('change', function(){
        if(!this.files.length){
            fileChosen.textContent="No image selected";
            imageContainer.src="";
            return false;
        }

        if(!isFileImage(this.files[0])){
            showSimpleModal("warning", "Image format not allowed");
            this.value = '';
            fileChosen.textContent="No image selected";
            return false;
        }
           
        fileChosen.textContent = this.files[0].name;
        readURL(this, imageContainer);
        
    });

    submitButton.addEventListener("click", e=>{
        let backgroundColor=document.getElementById("image-background").style.background;
        let opacityLevel=document.getElementById("colorAlpha").value;
        let gradientMarker=document.getElementById("colorGradientMarker");
        let colorMarker=document.getElementById("colorPickerMarker");
        
        let gradientCursor={
            x: parseFloat(gradientMarker.style.left.substring(0, gradientMarker.style.left.length - 2)),
            y: parseFloat(gradientMarker.style.top.substring(0, gradientMarker.style.top.length - 2))
        };

        let colorCursor={
            x: parseFloat(colorMarker.style.left.substring(0, colorMarker.style.left.length-2)),
            y: parseFloat(colorMarker.style.top.substring(0, colorMarker.style.top.length-2))
        };

        if(!areFieldsValidated(backgroundColor, opacityLevel, gradientCursor, colorCursor)){
            e.preventDefault();
            return false;
        }

        //TODO: Implement sending async form data
        /* 
        let formData= new FormData();   
        
        let rgb = backgroundColor.match(/\d+/g);
        for (let i = 0; i < rgb.length; i++) {
            formData.append('backgroundColor[]', rgb[i]);
        }

        formData.append('opacityLevel', opacityLevel);

        formData.append("gradientCursor", JSON.stringify(gradientCursor));
        formData.append("colorCursor", JSON.stringify(colorCursor));

        var imageData = document.getElementById("actual-btn").files[0];  

        if(imageData)
            formData.append("backgroundImage", imageData);
        
        */

        backgroundForm.submit();
    });

    backgroundForm.addEventListener("submit", e=>{
        
    });
} 


function areFieldsValidated(backgroundColor, opacityLevel, cursorGradient, cursorColor)
{
    if(!backgroundColor){
        showSimpleModal("error", "Cannot find background color value");
        return false;
    }
        
    if(!opacityLevel){
        showSimpleModal("error", "Cannot find opacity value");
        return false;
    }

    if(!cursorGradient){
        showSimpleModal("error", "Cannot get cursor position in gradient");
        return false;
    }

    if(!cursorColor){
        showSimpleModal("error", "Cannot get cursor position in color");
        return false;
    }

    return true;
}
