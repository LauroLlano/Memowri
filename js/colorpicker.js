let isMouseDown=false;

let colorGradientX=0;
let colorGradientY=0;
let ColorGradientCtx;

let colorPickerX=0;
let colorPickerY=0;
let ColorPickerCtx;


function loadColor()
{
    let colorGradientCanvas = document.getElementById('colorGradient');
    ColorGradientCtx = colorGradientCanvas .getContext('2d');

    let colorPickerCanvas = document.getElementById('colorPicker');
    ColorPickerCtx = colorPickerCanvas .getContext('2d'); 

    let colorGradientMarker=document.getElementById("colorGradientMarker");
    let colorPickerMarker=document.getElementById("colorPickerMarker");

    let alphaChannel=document.getElementById("colorAlpha");

    let imageBackground=document.getElementById("image-background");
    let imageFront=document.getElementById("image-front");

    imageFront.style.height=imageBackground.style.height;
    imageFront.style.width=imageBackground.style.width;


    colorGradientMarker.style.top=colorGradientMarker.style.left=0;
    colorPickerMarker.style.top=colorPickerMarker.style.left=0;

    document.getElementById("image-background").style.background=`rgb(255,255,255)`;

    loadColorGradient(255,0,0);
    loadColorPicker();
    loadAlphaChannel(imageFront, alphaChannel.value);


    //TODO: Cargar el color en el picker
    //TODO: Cargar el color en el gradiente
    //TODO: Acomodar cursor en gradiente
    //TODO: Acomodar cursor en picker

    colorGradientCanvas.addEventListener('mousemove', e=> {

        if(!isMouseDown || outOfBounds(colorGradientCanvas, e))
            return false;

        updateGradientMousePosition(colorGradientCanvas, e);
        colorGradientMarker.style.top = colorGradientY+"px";
        colorGradientMarker.style.left = colorGradientX+"px";
        selectGradient(colorGradientX, colorGradientY);     
    });

    colorGradientCanvas.addEventListener('mouseup', e=>{
        isMouseDown=false;
    })

    colorGradientCanvas.addEventListener('mousedown', e=>{
        isMouseDown=true;
    })

    colorGradientCanvas.addEventListener('mouseout', e=>{
        isMouseDown=false;
    })

    colorGradientCanvas.addEventListener('click', e=>{
        if(outOfBounds(colorGradientCanvas, e))
            return false;

        updateGradientMousePosition(colorGradientCanvas, e);
        colorGradientMarker.style.top = colorGradientY+"px";
        colorGradientMarker.style.left = colorGradientX+"px";
        selectGradient(colorGradientX, colorGradientY);
    });

    colorPickerCanvas.addEventListener('click', e=>{
        if(outOfBounds(colorPickerCanvas, e))
            return false;

        updateColorPickerMousePosition(colorPickerCanvas, e);
        colorPickerMarker.style.top = colorPickerY+"px";
        selectColor(colorPickerX, colorPickerY);
        selectGradient(colorGradientX, colorGradientY);
    });

    colorPickerCanvas.addEventListener('mousemove', e=> {
         if(!isMouseDown || outOfBounds(colorPickerCanvas, e))
            return false;

        updateColorPickerMousePosition(colorPickerCanvas, e);
        colorPickerMarker.style.top = colorPickerY+"px";
        selectColor(colorPickerX, colorPickerY);
        selectGradient(colorGradientX, colorGradientY);
    });

    colorPickerCanvas.addEventListener('mouseup', e=>{
        isMouseDown=false;
    })

    colorPickerCanvas.addEventListener('mousedown', e=>{
        isMouseDown=true;
    })

    colorPickerCanvas.addEventListener('mouseout', e=>{
        isMouseDown=false;
    });


    alphaChannel.addEventListener('input', e=>{
        loadAlphaChannel(imageFront, e.target.value);
    })
}

function updateGradientMousePosition(element, e)
{
    const rect = element.getBoundingClientRect();
    colorGradientX = e.clientX - rect.left;
    colorGradientY = e.clientY - rect.top;
}

function updateColorPickerMousePosition(element, e){
    const rect = element.getBoundingClientRect();
    colorPickerX = e.clientX - rect.left;
    colorPickerY = e.clientY - rect.top;
}

function selectGradient(x, y)
{
    pixel = ColorGradientCtx.getImageData(x,y,1,1)['data'];   // Read pixel Color
    rgb = `rgb(${pixel[0]},${pixel[1]},${pixel[2]})`;
    document.getElementById("image-background").style.background = rgb;    // Set this color to body of the document
}

function selectColor(x, y){
    pixel = ColorPickerCtx.getImageData(x,y,1,1)['data'];   // Read pixel Color
    loadColorGradient(pixel[0], pixel[1], pixel[2]);
}


function loadColorGradient(r, g, b)
{
    var color = `rgba(${r},${g},${b},1)`;
    let gradientH = ColorGradientCtx .createLinearGradient(0, 0, ColorGradientCtx .canvas.width, 0);
    gradientH.addColorStop(0, '#fff');
    gradientH.addColorStop(1, color);
    ColorGradientCtx .fillStyle = gradientH;
    ColorGradientCtx .fillRect(0, 0, ColorGradientCtx .canvas.width, ColorGradientCtx .canvas.height);



    let gradientV = ColorGradientCtx .createLinearGradient(0, 0, 0, 300);
    gradientV.addColorStop(0, 'rgba(0,0,0,0)');
    gradientV.addColorStop(1, '#000');
    ColorGradientCtx .fillStyle = gradientV;
    ColorGradientCtx .fillRect(0, 0, ColorGradientCtx .canvas.width, 
    ColorGradientCtx .canvas.height); 
}


function loadColorPicker() {
    let colors  = ['red','#ff0','lime','cyan','blue','#f0f','red'];
    let colorGradient = ColorPickerCtx.createLinearGradient(0, 0, 0, 300)
    colorGradient.addColorStop(0, 'red');
    for (let i = 1; i < colors.length; i++) {
        colorGradient.addColorStop(i / (colors.length-1), colors[i]);
    }
    ColorPickerCtx.fillStyle = colorGradient;
    ColorPickerCtx.fillRect(0, 0, 300, 300);
}

function outOfBounds(element, e)
{
    const rect = element.getBoundingClientRect();
    let xPosition = e.clientX - rect.left;
    let yPosition = e.clientY - rect.top;


    if(xPosition<=0 || yPosition<=0 || xPosition>=element.width || yPosition>=element.height)
        return true;

    return false;
}


function loadAlphaChannel(image, a){
    image.style.opacity=a;
}