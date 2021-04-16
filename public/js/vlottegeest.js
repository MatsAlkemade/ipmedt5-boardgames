const l = "email=" + __u__ + "&password=" + __p__;
const socket = io(window.location.protocol + '//' + window.location.host, { transports: ['websocket'], query: l });
let split = window.location.pathname.split('/');
let game = split[1];
let id = split[2];
let winner = false;
totalCards = 5;
let rondeNummer = -1;
let players = [];

const spook = document.getElementById("spook--js");
const kikker =document.getElementById("kikker--js");
const badkuip =document.getElementById("badkuip--js");
const borstel =document.getElementById("borstel--js");
const kleed =document.getElementById("kleed--js");
const bord = document.getElementById("vs--js");
let cardCount = document.getElementById('cardCount');
let flipButton = document.getElementById('turn--180');
const gameWinner = document.getElementById("gameWinner--js");
bord.style.display = "none";

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
    });
    
    spook.addEventListener('click', function(){
        spook.style.visibility = "hidden";
        socket.emit('objecten', { object: checkIfEqaul(this.dataset.value),rondeNummer: rondeNummer, game: game, id: id });
    });
    
    badkuip.addEventListener('click', function(){
        badkuip.style.visibility = "hidden";
        socket.emit('objecten', { object: checkIfEqaul(this.dataset.value),rondeNummer: rondeNummer, game: game, id: id });

    });
    
    borstel.addEventListener('click', function(){
        borstel.style.visibility = "hidden";
        socket.emit('objecten', { object: checkIfEqaul(this.dataset.value),rondeNummer: rondeNummer, game: game, id: id });
    });
    
    kikker.addEventListener('click', function(){
        kikker.style.visibility = "hidden";
        socket.emit('objecten', { object: checkIfEqaul(this.dataset.value),rondeNummer: rondeNummer, game: game, id: id });
    });
}
clickObject();

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

function getPlayerName(player_id){
    return playernames[getPlayer(player_id)-1];
}

socket.on('connect', function() {
    console.log("Connected to socketio server!");
    socket.emit('join_session', { game: game, id: id });
});

function turnCards(){
    socket.emit('turnCards', { game: game, id: id });
}

socket.on('turnCard', function() {
    cardFlip();
});

socket.on('rondeNummer', function(data) {
    console.log(data);
    if(rondeNummer != data.rondeNummer && rondeNummer != -1){
        cardFlipBack();
        console.log(data.Winner);
    }
    rondeNummer = data.rondeNummer;
    cardCount.innerText = totalCards;
    // if(cardCount)

});


socket.on('randomObject', function(data){
    console.log(data);
    function turnVisibilityOn(){
        document.getElementById('randomImages--js').src = data.randomObject;
    }
    setTimeout(turnVisibilityOn, 500);
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

function getPlayer(user_id) {
    return players.indexOf(Number(user_id)) + 1;
    
}
socket.on('scores', function(data) {
    
    var keys = Object.keys(data);
    // var min = data[keys[0]]; // ignoring case of empty list for conciseness
    var userid = keys[0];
    var score = data[keys[0]];
    var i;

    for (i = 1; i < keys.length; i++) {
        console.log(userid, keys[i], value, score);
        var value = data[keys[i]];
        if (value > score) userid = keys[i];
        if (value > score) score = value;
    }
    console.log(userid);
    console.log(score);
    if(score){
        function turnVisibilityOff(){
            bord.style.display = "none";
            gameWinner.style.display = "flex";
            gameWinner.querySelector("p").innerText = getPlayerName(userid) +  " heeft gewonnen!"
        }
        setTimeout(turnVisibilityOff, 0);
    }
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

function decrementCardAmount(){
    totalCards--;
}

function cardFlip(){
    document.querySelector('.vs__flip-card-inner').style.transform = 'rotateY(180deg)';
    flipButton.disabled = true;
    kleed.style.visibility = "visible";
    spook.style.visibility = "visible";
    badkuip.style.visibility = "visible";
    borstel.style.visibility = "visible";
    kikker.style.visibility = "visible";
}

function cardFlipBack(){
    document.querySelector('.vs__flip-card-inner').style.transform = 'rotateY(360deg)';
    console.log(totalCards);
    decrementCardAmount();
    flipButton.disabled = false;
}

window.addEventListener('load', function() {
    setupChat();
});

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
