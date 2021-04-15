const l = "email=" + __u__ + "&password=" + __p__;
const socket = io(window.location.protocol + '//' + window.location.host, { transports: ['websocket'], query: l });
let split = window.location.pathname.split('/');
let game = split[1];
let id = split[2];

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

window.addEventListener('load', setupChat);


let item;

function updatePie() {
    const piece = document.getElementsByClassName("trivialpursuit__items");
    piece[item].style.opacity = "1";
}

let winner;

function checkWinner() {
    let piece = document.getElementsByClassName("trivialpursuit__items");

    for (let index = 0; index < piece.length; index++) {

        if(winner == 6){
            console.log("gewonnen");
            break;
        }

        else if(piece[index].style.opacity == 1){
            winner = winner + 1;
        }

        else if(piece[index] == 6 || piece[index] == 12 || piece[index] == 18){
            winner == 0;
        }

        else{
            winner = 0;
        }
        
    }
}

function tp_setup() {
    let playersSection = document.getElementsByClassName("trivialpursuit__pie");
    for (let index = 0; index < players.length; index++) {
        playersSection[index].style.display = "block"
        playersSection[index].getElementsByTagName("H2")[0].innerHTML = playernames[index];
    }
}

function gameStart(data) {
	console.log("START THE GAME", data);
	if (data.start == true) {
		const tp = document.querySelector('.trivialpursuit__pie_container');
		tp.style.display = "grid";

	}
}

socket.emit('tp_getUsers', { game: game, id: id });
socket.emit('tp_playerNames', { game: game, id: id });
socket.emit('tp_question', { game: game, id: id });
socket.emit('tp_state', { game: game, id: id });



let players;
let playernames;
let questionId;

socket.on('tp_getUsers', function(data) {
    console.log("tp_getUsers", data);
    players = data;    
});

socket.on('tp_playerNames', function(data){
    console.log("help");
    console.log("playerNames", data);
    playernames = data;
    tp_setup();
});

socket.on('tp_question', function(data) {
    console.log("tp_question", data);
    questionId = data;
    createQuestion();
});

socket.on('connect', function(){
    socket.emit('join_session', { game: game, id: id});
});

socket.on('game_start', function(data) {
	gameStart(data);
});

socket.on('tp_state', function(data) {
	console.log("STATE", data);
    if (data.started == true){
        gameStart({ start: true });
    }
	playerPositions = data.playerPositions;

	for (const userid in playerPositions) {
		goto(getPlayer(userid), playerPositions[userid]);
	}
});