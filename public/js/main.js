const navButton = document.getElementById('js--navButton');
const navDropdown = document.getElementById('js--navDropdown');
const popupBtns = document.getElementById('js--popupBtns');
const liveChat = document.getElementById('js--liveChat');
const rules = document.getElementById('js--rules');
const position = document.getElementById('js--position');

if(navButton){
    navButton.addEventListener('click', function(){
    if(navDropdown.style.display === 'none'){
        navDropdown.style.display = 'block';
    }else {
        navDropdown.style.display = 'none';
    }
    });
}

if(navDropdown){
    document.addEventListener('click', function(e){
        if(e.target.classList.contains('js--nc')){
            return;
        } else {
            navDropdown.style.display = 'none';
        }
    });
}

function showPopup(popup){
    popupBtns.style.pointerEvents = 'none';
    setTimeout(function() {
        popupBtns.style.pointerEvents = 'auto';
    }, 1000);
    
    if(popup.offsetHeight > 0){
        popup.style.animationName = "popdown";
        popup.style.height = "0";
        setTimeout(function() {
            popup.style.display = "none";
        }, 1000);
    }else{
        popup.style.animationName = "popup";
        popup.style.display = "block";
        popup.style.height = "100%";
    }

    if(popup.id != 'js--liveChat'){
        liveChat.style.animationName = "popdown";
        liveChat.style.height = "0";
        setTimeout(function() {
            liveChat.style.display = "none";
        }, 1000);
    }
    
    if(popup.id != 'js--rules'){
        rules.style.animationName = "popdown";
        rules.style.height = "0";
        setTimeout(function() {
            rules.style.display = "none";
        }, 1000);
    }
    
    if(popup.id != 'js--position'){
        position.style.animationName = "popdown";
        position.style.height = "0";
        setTimeout(function() {
            position.style.display = "none";
        }, 1000);
    }
}