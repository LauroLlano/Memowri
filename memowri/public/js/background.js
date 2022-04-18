window.onload=load;
var hasPressedButton
function load()
{
    loadColor();
    let fileBtn = document.getElementById('file-container');
    let fileChosen = document.getElementById('file-chosen');
    let imageContainer=document.getElementById('image-front');
    let submitButton=document.getElementById('background-submit');
    let backgroundForm=document.getElementById('background-form');

    let alphaSection=document.getElementById('alphaFilter');

    fileBtn.addEventListener('click', function(){
        fileChosen.textContent="No image selected";
        imageContainer.src="";
        alphaSection.style.visibility="hidden";
    })

    fileBtn.addEventListener('change', function(){

        if(!this.files.length){
            fileChosen.textContent="No image selected";
            imageContainer.src="";
            alphaSection.style.visibility="hidden";

            return false;
        }

        if(!isFileImage(this.files[0])){
            showSimpleModal("warning", "Image format not allowed");
            this.value = '';
            fileChosen.textContent="No image selected";
            alphaSection.style.visibility="hidden";
            return false;
        }

        alphaSection.style.visibility="visible";

        let fileText=this.files[0].name;
        if(fileText.length>50){
            fileText=fileText.slice(0, 50);
            fileText+="...";
            fileText+=this.files[0].name.match(/\.([^\.]+)$/)[1];
        }

        fileChosen.textContent = fileText;
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
        document.getElementById('file-container').disabled=true;
        document.getElementById('background-submit').disabled=true;

        let rgb = backgroundColor.match(/\d+/g);
        let rgbBackground={
            r: rgb[0],
            g: rgb[1],
            b: rgb[2]
        }

        let hexRgb=rgbToHex(rgbBackground.r, rgbBackground.g, rgbBackground.b);

        submitForm(backgroundForm, hexRgb, opacityLevel, gradientCursor, colorCursor, document.getElementById("file-container").files[0])
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

function submitForm(form, backgroundColor, opacityLevel, gradientCursor, colorCursor, imageData=null)
{
    let dataForm=new FormData();
    dataForm.append('background_color', backgroundColor);
    dataForm.append('opacity', opacityLevel);

    dataForm.append('gradient_cursor', JSON.stringify(gradientCursor));

    dataForm.append('color_cursor', JSON.stringify(colorCursor));


    let imageContainer=document.getElementById("image-front");
    dataForm.append('is_image_loaded', imageContainer.complete && imageContainer.naturalHeight !== 0 ? 1:0);
    if(imageData!=null)
        dataForm.append('image_data', imageData);


    dataForm.append('_method', document.querySelector("input[name='_method']").value)

    fetch(form.action, {
        method: 'POST',
        body: dataForm,
        headers: {
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
        document.getElementById('file-container').disabled=false;
        document.getElementById('background-submit').disabled=false;
        if(text.status!="success"){
            showSimpleModal(text.status, text.message);
            return;
        }
        showModalAccept('success', text.message, 'Continue', '/');
    })
    .catch(err=>{
        document.getElementById('file-container').disabled=false;
        document.getElementById('background-submit').disabled=false;
        errorProcessor(err);
    });

}

function componentToHex(c) {
  var hex = c.toString(16);
  return hex.length == 1 ? "0" + hex : hex;
}

function rgbToHex(r, g, b) {
  return componentToHex(parseInt(r, 10)) + componentToHex(parseInt(g, 10)) + componentToHex(parseInt(b, 10));
}
