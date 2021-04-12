const navButton = document.getElementById('js--navButton');
const navDropdown = document.getElementById('js--navDropdown');

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

const popupBtns = document.getElementById('js--popupBtns');
const popups = document.getElementById('js--popups');
const liveChat = document.getElementById('js--liveChat');
const rules = document.getElementById('js--rules');
const position = document.getElementById('js--position');

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
            popups.style.display = "none";
        }, 1000);
    }else{
        popup.style.animationName = "popup";
        popup.style.display = "block";
        popups.style.display = "block";
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

const tsCard = document.getElementById('js--tsCard');
const tsCardBack = document.getElementById("js--tsCardBack");
const tsCardTurnBtn = document.getElementById("js--tsCardTurnBtn");
const tsCardSubmitBtn = document.getElementById("js--tsCardSubmitBtn");
const tsCardForm = document.getElementById("js--tsCardForm");
const tsTimer = document.getElementById("js--tsTimer");
const tsTimerBar = document.getElementById("js--tsTimerBar");

function turnCard(){
    tsStartTimer();
    tsCard.style.transform = "rotateY(180deg)";
    tsCardSubmitBtn.removeAttribute("disabled");
    tsCardTurnBtn.setAttribute("disabled", "");
    setTimeout(function() {
        tsCardBack.style.zIndex = "1";
    }, 600);
}

function tsSubmitForm(){
    tsCardForm.submit();
}

function tsStartTimer() {
    let counter = 30;
    let barWidth = tsTimerBar.offsetWidth;
    let barStep = tsTimerBar.offsetWidth / counter;
    function next() {
        if (counter <= 1) {
            tsTimerBar.style.width = 0;
            tsTimer.innerText = 0;
            return;
        }
        counter--;
        barWidth = barWidth - barStep;
        tsTimerBar.style.width = barWidth + "px";
        tsTimer.innerText = counter;
        setTimeout(next, 1000);
    }
    setTimeout(next, 1000);
}