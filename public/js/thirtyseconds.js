const l = "email=" + __u__ + "&password=" + __p__;
const socket = io(window.location.protocol + '//' + window.location.host, { transports: ['websocket'], query: l });
let split = window.location.pathname.split('/');
let game = split[1];
let id = split[2];
const tsCard = document.getElementById('js--tsCard');
const tsCardBack = document.getElementById("js--tsCardBack");
const tsCardTurnBtn = document.getElementById("js--tsCardTurnBtn");
const tsCardSubmitBtn = document.getElementById("js--tsCardSubmitBtn");
const tsCardForm = document.getElementById("js--tsCardForm");
const tsTimer = document.getElementById("js--tsTimer");
const tsTimerBar = document.getElementById("js--tsTimerBar");
let tsInitTimerBar;
const turnButton = document.getElementById("js--tsCardTurnBtn");
const tsState = document.getElementById("js--tsState");
const formGameId = document.getElementById("js--formGameId");
const q1 = document.getElementById("q1");
const q2 = document.getElementById("q2");
const q3 = document.getElementById("q3");
const q4 = document.getElementById("q4");
const q5 = document.getElementById("q5");
let timer = setTimeout(()=>{});

formGameId.setAttribute("value", id);
turnButton.setAttribute("disabled", true);

socket.on('connect', function() {
    console.log("Connected to socketio server!");

    socket.emit('join_session', { game: game, id: id });
    socket.emit('ts_state', {game: game, id: id});
});

socket.on('turn', function(data){
    if (data.turn && data.turn.length < 1) return;
    console.log(data);
    data.turn.forEach(player => {
        console.log(player, user_id);
        if (player == user_id){
            turnButton.removeAttribute("disabled");
        }
    });
});

socket.on('teamAnswer', function(data){
    console.log(data);
});

function submitTurn(e) {
    e.preventDefault();
    let questions = {
        "q1": q1.checked ? 1 : 0,
        "q2": q2.checked ? 1 : 0,
        "q3": q3.checked ? 1 : 0,
        "q4": q4.checked ? 1 : 0,
        "q5": q5.checked ? 1 : 0,
    };
    socket.emit('ts_answers', {game: game, id: id, questions: questions});
    tsCardSubmitBtn.setAttribute("disabled", "");
    tsCard.style.transform = "rotateY(0)";
    setTimeout(function() {
        tsCardBack.style.zIndex = "-1";
    }, 600);
    clearTimeout(timer);
    tsTimer.innerText = 30;
    tsTimerBar.style.width = tsInitTimerBar + 'px';
}

function setupChat() {
    const liveChat = document.getElementById('js--liveChat');
    if (!liveChat) return;
    let orderCount = 1;
    const chatIcon = document.querySelector('.js--chat-icon');
    const chatButton = document.querySelector('.js--chat-button');
    const chatForm = document.querySelector('.js--livechat-form');
    const chatList = document.querySelector('.js--livechat--list');
    console.log(chatList);
    console.log(chatIcon);
    socket.emit('chat_state', { game: game, id: id });
    socket.on('chat_msg', function(data) {
        if (!isChatOpen()) chatIcon.classList.add("icon__badge");
        console.log("CHATMSG", data);
        addChatMessage(data.username, data.message, data.order);
    });
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

setupChat();

function turnCard(){
    tsStartTimer();
    tsCard.style.transform = "rotateY(180deg)";
    setTimeout(function() {
        tsCardBack.style.zIndex = "1";
    }, 600);
    tsCardSubmitBtn.removeAttribute("disabled");
    tsCardTurnBtn.setAttribute("disabled", "");
}

function tsSubmitForm(){
    tsCardForm.submit();
}

function tsStartTimer() {
    let counter = 30;
    tsInitTimerBar = tsTimerBar.offsetWidth;
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
        timer = setTimeout(next, 1000);
    }
    timer = setTimeout(next, 1000);
}