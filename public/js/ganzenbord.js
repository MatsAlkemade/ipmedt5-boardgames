var imagesArray = [
    '/img/gb_vakjes/gb_start.png',
    '/img/gb_vakjes/gb_1.png',
    '/img/gb_vakjes/gb_2.png',
    '/img/gb_vakjes/gb_3.png',
    '/img/gb_vakjes/gb_4.png',
    '/img/gb_vakjes/gb_5.png',
    '/img/gb_vakjes/gb_6.png',
    '/img/gb_vakjes/gb_7.png',
    '/img/gb_vakjes/gb_8.png',
    '/img/gb_vakjes/gb_9.png',
    '/img/gb_vakjes/gb_10.png',
    '/img/gb_vakjes/gb_11.png',
    '/img/gb_vakjes/gb_12.png',
    '/img/gb_vakjes/gb_13.png',
    '/img/gb_vakjes/gb_14.png',
    '/img/gb_vakjes/gb_15.png',
    '/img/gb_vakjes/gb_16.png',
    '/img/gb_vakjes/gb_17.png',
    '/img/gb_vakjes/gb_18.png',
    '/img/gb_vakjes/gb_19.png',
    '/img/gb_vakjes/gb_20.png',
    '/img/gb_vakjes/gb_21.png',
    '/img/gb_vakjes/gb_22.png',
    '/img/gb_vakjes/gb_23.png',
    '/img/gb_vakjes/gb_24.png',
    '/img/gb_vakjes/gb_25.png',
    '/img/gb_vakjes/gb_26.png',
    '/img/gb_vakjes/gb_27.png',
    '/img/gb_vakjes/gb_28.png',
    '/img/gb_vakjes/gb_29.png',
    '/img/gb_vakjes/gb_30.png',
    '/img/gb_vakjes/gb_31.png',
    '/img/gb_vakjes/gb_32.png',
    '/img/gb_vakjes/gb_33.png',
    '/img/gb_vakjes/gb_34.png',
    '/img/gb_vakjes/gb_35.png',
    '/img/gb_vakjes/gb_36.png',
    '/img/gb_vakjes/gb_37.png',
    '/img/gb_vakjes/gb_38.png',
    '/img/gb_vakjes/gb_39.png',
    '/img/gb_vakjes/gb_40.png',
    '/img/gb_vakjes/gb_41.png',
    '/img/gb_vakjes/gb_42.png',
    '/img/gb_vakjes/gb_43.png',
    '/img/gb_vakjes/gb_44.png',
    '/img/gb_vakjes/gb_45.png',
    '/img/gb_vakjes/gb_46.png',
    '/img/gb_vakjes/gb_47.png',
    '/img/gb_vakjes/gb_48.png',
    '/img/gb_vakjes/gb_49.png',
    '/img/gb_vakjes/gb_50.png',
    '/img/gb_vakjes/gb_51.png',
    '/img/gb_vakjes/gb_52.png',
    '/img/gb_vakjes/gb_53.png',
    '/img/gb_vakjes/gb_54.png',
    '/img/gb_vakjes/gb_55.png',
    '/img/gb_vakjes/gb_56.png',
    '/img/gb_vakjes/gb_57.png',
    '/img/gb_vakjes/gb_58.png',
    '/img/gb_vakjes/gb_59.png',
    '/img/gb_vakjes/gb_60.png',
    '/img/gb_vakjes/gb_61.png',
    '/img/gb_vakjes/gb_62.png',
    '/img/gb_vakjes/gb_63.png',
];

var gegooid = 33 ; //input van de esp32
var counter = 0; //start positie
var counter = counter + gegooid; //start positie +gegooid

function displayImage_gb(){
    document.canvas.src = imagesArray[counter]; // show image van de huidige positie

    if(counter == 6){
        document.canvas.src = imagesArray[counter]; // show image van de huidige positie
        setTimeout(naar_12_func, 5000);

        
    }
    if(counter == 42){
        document.canvas.src = imagesArray[counter]; // show image van de huidige positie
        setTimeout(naar_39_func, 5000);

        
    } 
    if(counter == 58){
        document.canvas.src = imagesArray[counter]; // show image van de huidige positie
        setTimeout(naar_start_func, 5000);

        
    } 
}

function naar_12_func(){
    counter = 12;
    document.canvas.src = imagesArray[counter]; // show image van de huidige positie
}
function naar_39_func(){
    counter = 39;
    document.canvas.src = imagesArray[counter]; // show image van de huidige positie
}
function naar_start_func(){
    counter = 0;
    document.canvas.src = imagesArray[counter]; // show image van de huidige positie
}

document.getElementById("speler_1").addEventListener("click", displayImage_gb());

