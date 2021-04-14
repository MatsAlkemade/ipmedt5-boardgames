const l = "email=" + __u__ + "&password=" + __p__;
const socket = io(window.location.protocol + '//' + window.location.host, { transports: ['websocket'], query: l });
let split = window.location.pathname.split('/');
let game = split[1];
let id = split[2];

let waitTurn = false;

let winner = false;

let players = [];
let playerPositions = {};
let playernames =[];

let counter = 0;

socket.on('getUsers', function(data) {
    console.log("GETUSERS", data);
    players = data;
    socket.emit('ganzenbord_state', { game: game, id: id });
    
});

socket.on('ganzenbord_playernames', function(data){
    playernames = data;
    updatePlayers()
    console.log("GETPLAYERNAMES", playernames);
    socket.emit('ganzenbord_state', { game: game, id: id });
    
    

});




socket.on('game_start', function(data,) {
	gameStart(data);
    
    
});
socket.on('connect', function() {
    socket.emit('join_session', { game: game, id: id });
});

socket.on('turn', function(data) {
	console.log("TURN", data, user_id);
	myTurn = false;
	if (data.turn == user_id) myTurn = true;
	const turnText = document.querySelector('.js--gb-turn');

    if(winner == false){
        if (!myTurn) {
            turnText.classList.add('js--gb-other');
            turnText.classList.remove('js--gb-me');
            turnText.innerText = "Het is de beurt van een andere speler!";
        } else {
            turnText.classList.remove('js--gb-other');
            turnText.classList.add('js--gb-me');
            turnText.innerText = "Het is jouw beurt!";
        }
    }
	
});

socket.on('dobbel', function(data) {
	console.log("IK HEB EEN RANDOM NUMMER", data);
	// counter += Number(data.getal)
    console.log(data.getal);



    if (data.position >= 63){
        data.position = 63;
        console.log('gewonnen');
        winner = true;
        winnerName = getPlayerName(data.playerId);
        const turnText = document.querySelector('.js--gb-turn');
	    turnText.innerText = winnerName + " heeft gewonnen!";
        
    }
    // else if ((data.position == 5) || 9 || 14 || 18 || 23 || 26 || 27 || 32 || 36 || 41 || 45 || 54 || 59 ){
    //     console.log(data.position);
    //     huidige_speler = getPlayerName(data.playerId);
    //     const geefgedobbeld = document.querySelector('.js--gb-dobbel');
    //     geefgedobbeld.innerText = huidige_speler + " heeft " + data.getal + " gegooid en is op een Gans belandt! Daarom mag hij " +data.getal +  "stappen verder";
    // }

    
    else if (data.position == 58){
        data.position = 0;
        console.log('dood');
    }
    else if (data.position == 6){
        data.position = 12;
        console.log('brug');
    }
    else if (data.position == 42){
        data.position = 39;
        console.log('door');
    }
    else{
        huidige_speler = getPlayerName(data.playerId);
        const geefgedobbeld = document.querySelector('.js--gb-dobbel');
        geefgedobbeld.innerText = huidige_speler + " heeft " + data.getal + " gegooid!";

    }


    goto(getPlayer(data.playerId), data.position);

});

socket.on('ganzenbord_state', function(data) {
	console.log("STATE", data);
    if (data.started == true){
        gameStart({ start: true });
    
    }
	playerPositions = data.playerPositions;



	for (const userid in playerPositions) {
		goto(getPlayer(userid), playerPositions[userid]);
	}
    

});


socket.emit('getUsers', { game: game, id: id });
socket.emit('ganzenbord_playernames', { game: game, id: id });





const specialeVakjes = {
	"6": 12,
	"42": 39,
	"58": 0
};

const beurtOverslaanVakjes = [
	31,
	52
];


function getPlayer(user_id) {

    return players.indexOf(Number(user_id)) + 1;

    
}
function getPlayerName(player_id){
    return playernames[getPlayer(player_id)-1];

}

function winnerName(player_id){
    return playernames

}

function gameStart(data) {
    
	console.log("START THE GAME", data);
	if (data.start == true) {
		const gb = document.querySelector('.ganzenbord');
		gb.style.display = "block";
    }

    
	
}

function updatePlayers(){
    if(playernames.length == 1){
        var name_1 = document.getElementById('speler_1');
        name_1.innerText = playernames[0];
    }
    if(playernames.length == 2){
        var name_1 = document.getElementById('speler_1');
        name_1.innerText = playernames[0];
        var name_2 = document.getElementById('speler_2');
        name_2.innerText = playernames[1];
    }
    if(playernames.length == 3){
        var name_1 = document.getElementById('speler_1');
        name_1.innerText = playernames[0];
        var name_2 = document.getElementById('speler_2');
        name_2.innerText = playernames[1];
        var name_3 = document.getElementById('speler_3');
        name_3.innerText = playernames[2];
    }
    if(playernames.length == 4){
        var name_1 = document.getElementById('speler_1');
        name_1.innerText = playernames[0];
        var name_2 = document.getElementById('speler_2');
        name_2.innerText = playernames[1];
        var name_3 = document.getElementById('speler_3');
        name_3.innerText = playernames[2];
        var name_4 = document.getElementById('speler_4');
        name_4.innerText = playernames[3];
    }
    else{
        return;
    }
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
    pageLoaded = true;
	const fiar = document.querySelector('.ganzenbord');
	fiar.style.display = "none";


    setupChat();

    document.getElementById('gb_button').addEventListener('click', function(){
        console.log('hi');
        socket.emit('dobbel', { game: game, id: id });
        // dobbel();
	});
    

});


function goto(player, place) {
	console.log("GOTO", player, place);
    if(place >= 63){
        place =63;
    }
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