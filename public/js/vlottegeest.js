const l = "email=" + __u__ + "&password=" + __p__;
const socket = io(window.location.protocol + '//' + window.location.host, { transports: ['websocket'], query: l });
let split = window.location.pathname.split('/');
let game = split[1];
let id = split[2];
let winner = false;
totalCards = 60;
let rondeNummer = -1;

const spook = document.getElementById("spook--js");
const kikker =document.getElementById("kikker--js");
const badkuip =document.getElementById("badkuip--js");
const borstel =document.getElementById("borstel--js");
const kleed =document.getElementById("kleed--js");
const bord = document.getElementById("vs--js");
let chec; 
bord.style.display = "none";

// let objecten = ['Spook', 'Bad', 'Kleed', 'Kikker', 'Borstel'];
// // grabbedObject = [];
function gameStart(data) {
	console.log("START THE GAME", data);
    if (data.start == true) {
        bord.style.display = "block";
    }
}

function clickObject(){
    kleed.addEventListener('click', function(){
        kleed.style.visibility = "hidden";
        socket.emit('objecten', {object: checkIfEqaul(this.dataset.value),rondeNummer: rondeNummer, game: game, id: id });
        // checkIfEqaul(this.dataset.value);
    });
    
    spook.addEventListener('click', function(){
        spook.style.visibility = "hidden";
        socket.emit('objecten', { object: checkIfEqaul(this.dataset.value),rondeNummer: rondeNummer, game: game, id: id });
        // checkIfEqaul(this.dataset.value);
   
    });
    
    badkuip.addEventListener('click', function(){
        badkuip.style.visibility = "hidden";
        socket.emit('objecten', { object: checkIfEqaul(this.dataset.value),rondeNummer: rondeNummer, game: game, id: id });
        // checkIfEqaul(this.dataset.value);
    });
    
    borstel.addEventListener('click', function(){
        borstel.style.visibility = "hidden";
        socket.emit('objecten', { object: checkIfEqaul(this.dataset.value),rondeNummer: rondeNummer, game: game, id: id });
        // checkIfEqaul(this.dataset.value);
    });
    
    kikker.addEventListener('click', function(){
        kikker.style.visibility = "hidden";
        socket.emit('objecten', { object: checkIfEqaul(this.dataset.value),rondeNummer: rondeNummer, game: game, id: id });
        // checkIfEqaul(this.dataset.value);
    });
}
clickObject();

socket.on('connect', function() {
    console.log("Connected to socketio server!");
    socket.emit('join_session', { game: game, id: id });
});

socket.on('rondeNummer', function(data) {
    console.log(data);
    if(rondeNummer != data.rondeNummer && rondeNummer != -1){
        cardFlipBack();
        console.log(data.Winner);
    }
    rondeNummer = data.rondeNummer;

});

socket.on('randomObject', function(data) {
    console.log(data);
    // if(rondeNummer != data.rondeNummer && rondeNummer != -1){
    //     cardFlipBack();
    //     console.log(data.Winner);
    // }
    // rondeNummer = data.rondeNummer

});

socket.on('vg_getUsers', function(data) {
    console.log("GETUSERS", data);
    players = data;
    socket.emit('vlottegeest_state', { game: game, id: id });
});

socket.on('vg_playerNames', function(data){
    console.log(data);
    playernames = data;
});

socket.on('game_start', function(data) {
    gameStart(data);
    
});

socket.on('vg_state', function(data) {
    console.log("STATE", data);
    if (data.started == true){
        gameStart({ start: true });
    }
    playerPositions = data.playerPositions;

    for (const userid in playerPositions) {
        goto(getPlayer(userid), playerPositions[userid]);
    }
});

socket.emit('vg_state', { game: game, id: id });
socket.emit('vg_getUsers', { game: game, id: id });
socket.emit('vg_playerNames', { game: game, id: id });


cardCount = document.getElementById('cardCount');
flipButton = document.getElementById('turn--180');
flipButtonBack = document.getElementById('turn--360');

function decrementCardAmount(){
    totalCards--;
    cardCount.innerHTML = totalCards;
}

function cardFlip(){
    document.querySelector('.vs__flip-card-inner').style.transform = 'rotateY(180deg)';
    getRandomImage();
    flipButton.disabled = true;
    flipButtonBack.disabled = false;
}

function cardFlipBack(){
    document.querySelector('.vs__flip-card-inner').style.transform = 'rotateY(360deg)';
    decrementCardAmount();
    flipButton.disabled = false;
    flipButtonBack.disabled = true;
}

function getRandomImage(){

    var imageArray = new Array();  

    imageArray[0]= "Spook.png";  
    imageArray[1]= "bad.png";  
    imageArray[2]= "Borstel.png";  
    imageArray[3]= "doekie.png";  
    imageArray[4]= "frogie.png";

    let randomIndex = Math.floor(Math.random() * imageArray.length);

    selected_image =  imageArray[randomIndex];
    document.getElementById('randomImages--js').src = '/img/games/vlottegeest/' + selected_image;
}

window.addEventListener('load', function() {
    setupChat();
});

function checkIfEqaul(value){
    
    let src = document.getElementById('randomImages--js').src; 
    src = src.split("/");
    src = src[src.length -1];

    if(src == value){
        console.log("true");
        return true;
    }
    else{
        console.log("false");
        return false;
    }
}


function setupChat() {
    socket.on('chat_msg', function(data) {
        if (!isChatOpen()) chatIcon.classList.add("icon__badge");
        console.log("CHATMSG", data);
        addChatMessage(data.username, data.message, data.order);
    });
 
    if (!liveChat) return;
    let orderCount = 1;
    const chatIcon = document.querySelector('.js--chat-icon');
    const chatButton = document.querySelector('.js--chat-button');
    const chatForm = document.querySelector('.js--livechat-form');
    const chatList = document.querySelector('.js--livechat--list');
    console.log(chatList);
    console.log(chatIcon);
    socket.emit('chat_state', { game: game, id: id });

    socket.on('chat_state', function(data) {
        console.log("CHAT_STATE", data);
    });
    chatButton.addEventListener('click', function() {
        chatIcon.classList.remove("icon__badge");
    });
    chatForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const input = e.target.querySelector('input');
        addChatMessage("You", input.value);
        socket.emit('chat_msg', { game: game, id: id, message: input.value });
        
        input.value = "";
    });

    function isChatOpen() {
        return liveChat.style.display == "block";
    }

    function addChatMessage(username, message, order=undefined) {
        const chatMessage = createChatMessage(username, message);
        if (order !== undefined) {
            chatMessage.style.order = order;
            orderCount = order;
        } else {
            chatMessage.style.order = ++orderCount;
        }
        chatList.appendChild(chatMessage);
        if (isChatOpen()) {
            chatList.scrollTo(0, chatList.scrollHeight);
        }
    }
    
    function createChatMessage(_username, _message) {
        const msg = document.createElement('li');
        const username = document.createElement('p');
        const message = document.createElement('p');
        msg.classList.add('livechat__item');
        if (_username.toLowerCase() == "console") {
            msg.classList.add('livechat__item--console');
        } else if (_username.toLowerCase() == "you") {
            msg.classList.add('livechat__item--me');
        }
        username.classList.add('livechat__item__username');
        message.classList.add('livechat__item__message');
        username.innerText = _username;
        message.innerText = _message;
        msg.appendChild(username);
        msg.appendChild(message);

        return msg;
    }
}
