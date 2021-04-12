const l = "email=" + __u__ + "&password=" + __p__;
const socket = io(window.location.protocol + '//' + window.location.host, { transports: ['websocket'], query: l });
let split = window.location.pathname.split('/');
let game = split[1];
let id = split[2];

let waitTurn = false;

let testPlayers = [
    1,
    4,
    5,
    3
];

const specialeVakjes = {
	"6": 12,
	"42": 39,
	"58": 0
};

const beurtOverslaanVakjes = [
	31,
	52
];

//     if(counter == 6){
    //         document.canvas.src = imagesArray[counter]; // show image van de huidige positie
    //         setTimeout(naar_12_func, 5000);
    
            
    //     }
    //     if(counter == 42){
    //         document.canvas.src = imagesArray[counter]; // show image van de huidige positie
    //         setTimeout(naar_39_func, 5000);
    
            
    //     } 
    //     if(counter == 58){
    //         document.canvas.src = imagesArray[counter]; // show image van de huidige positie
    //         setTimeout(naar_start_func, 5000);
    
            
    //     } 

function getPlayer(user_id) {
    return testPlayers.indexOf(user_id) + 1;
}


function setupChat() {
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

window.addEventListener('load', function() {    
    setupChat();

    document.getElementById('gb_button').addEventListener('click', function(){
        console.log('hi');
        dobbel();
	});
    
    let counter = 0;
    let gegooid =0;
    function dobbel(){
		if (waitTurn) return;
        gegooid = Math.floor(Math.random() * 13); 
        console.log(gegooid);
        counter = counter + gegooid; //start positie +gegooid 
        console.log(counter);
            
        if(counter >= 63){
            counter = 63;
        }
        goto(getPlayer(user_id), counter);
        return;
    }
});


function goto(player, place) {
	console.log("GOTO", player, place);
    if (specialeVakjes[place] !== undefined) {
    	console.log(specialeVakjes[place]);
    	setTimeout(() => {
    		goto(player, specialeVakjes[place]);
    	}, 3000);
    }

    if (beurtOverslaanVakjes.indexOf(place) !== -1) {
    	waitTurn = true;
    }
    const ppv = document.querySelector('.js--player' + player);
    console.log(ppv);

    const img = ppv.querySelector('img');


    img.src = imagesArray[place];
}