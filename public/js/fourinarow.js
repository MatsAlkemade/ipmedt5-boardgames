const l = "email=" + __u__ + "&password=" + __p__;

const socket = io(window.location.protocol + '//' + window.location.host, { transports: ['websocket'], query: l });
let gameBuilt = false;
let myTurn = false;
let winner = false;
let winnerId = -1;
let winningPieces = undefined;
let pageLoaded = false;

let split = window.location.pathname.split('/');
let game = split[1];
let id = split[2];

window.addEventListener('load', function() {
	pageLoaded = true;
	const fiar = document.querySelector('.fourinarow');
	fiar.style.display = "none";

	if (winner !== false) {
		winnerText();
	}

	setupChat();
});

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

socket.on('connect', function() {
	console.log("Connected to socketio server!");

	let split = window.location.pathname.split('/');

	socket.emit('join_session', { game: game, id: id });
	socket.emit('fiar_state', { game: game, id: id });
});

socket.on('login', function(data) {
	console.log("LOGGED IN", data);
});

socket.on('game', function(data) {
	if (data.game == false) {
		socket.emit('game', { game: game, id: id });
	} else {
		console.log("Redirect to other game??", data);
	}
});

socket.on('hardware', function(data) {
	console.log("HARDWARE", data);
});

socket.on('disconnect', function() {
	console.log("Disconnected from socketio server!");
});

socket.on('users', function(data) {
	console.log("update users", data);

	// document.querySelector('.js--users').innerText = JSON.stringify(data);
});

socket.on('game_start', function(data) {
	gameStart(data);
});


function gameStart(data) {
	console.log("START THE GAME", data);
	if (data.start == true) {
		const fiar = document.querySelector('.fourinarow');
		fiar.style.display = "block";
		fiarBuilder();
	}
}

socket.on('turn', function(data) {
	console.log("TURN", data, user_id);
	myTurn = false;
	if (data.turn == user_id) myTurn = true;
	const turnText = document.querySelector('.js--fiar-turn');
	if (winner !== false) {
		winnerText();
		return;
	}
	if (!myTurn) {
		turnText.classList.add('js--fiar-other');
		turnText.classList.remove('js--fiar-me');
		turnText.innerText = "(Other players turn)";
	} else {
		turnText.classList.remove('js--fiar-other');
		turnText.classList.add('js--fiar-me');
		turnText.innerText = "(Your turn)";
	}
});

socket.on('fiar_place', function(data) {
	console.log("RECEIVE", data);
	if (!data.column && data.column != 0) return;
	place(data.column, data.user == user_id ? -1 : 2);
});

socket.on('fiar_state', function(data) {
	console.log("fiar_state", data);
	if (typeof data == "object" && data.length > 0) {
		data.forEach(function (value) {
			console.log(value);
			switch (value.action) {
				case 'game_start':
					gameStart({ start: true });
					resetBoard();
					break;
				case 'fiar_place':
					console.log("FIAR_PLACE", value);
					place(value.column, value.player != user_id ? 2 : 1);
					break;
			}
		});
	}
});

socket.on('fiar_winner', function(data) {
	console.log("GOT A WINNER!", data);
	myTurn = false;
	winner = data.username;
	winnerId = data.winner;
	winningPieces = data.winningPieces;
	
	if (winner !== false) {
		winnerText();
		return;
	}
});

let timeout = true;
function winnerText() {
	if (!pageLoaded) return;
	const turnText = document.querySelector('.js--fiar-turn');
	turnText.innerText = winner + " won the game!";
	if (winnerId == user_id) {
		turnText.classList.remove('js--fiar-other');
		turnText.classList.add('js--fiar-me');
	} else {
		turnText.classList.add('js--fiar-other');
		turnText.classList.remove('js--fiar-me');
	}

	if (winningPieces !== undefined) {
		console.log("WINNINGPIECES");
		if (winningPieces.vertical) {
			console.log("WINNINGPIECES VERTICAL", winningPieces.vertical);
			for (let i = winningPieces.vertical.end[1]; i < winningPieces.vertical.begin[1]+1; i++) {
				const piece = getPiecePlace(winningPieces.vertical.begin[0], i);
				console.log("WIN", i, piece);
				if (!piece && timeout == true) {
					timeout = false;
					return setTimeout(winnerText, 25);
				}
				piece.classList.add("js--piece-win");
			}
		}
		if (winningPieces.horizontal) {
			console.log("WINNINGPIECES HORIZONTAL");
			for (let i = winningPieces.horizontal.begin[0]; i < winningPieces.horizontal.end[0]+1; i++) {
				const piece = getPiecePlace(i, winningPieces.horizontal.begin[1]);
				if (!piece && timeout == true) {
					timeout = false;
					return setTimeout(winnerText, 25);
				}
				console.log(piece, i, winningPieces.horizontal.begin[1]);
				piece.classList.add("js--piece-win");
				console.log("WIN", i);
			}
		}
		if (winningPieces.diagonals) {
			// TODO
		}
	}
}

function resetBoard() {
	console.log("RESETBOARD", gameBuilt);
	if (!gameBuilt) return;
	const fiar = document.querySelector('.fourinarow__pieces');
	const buttons = document.querySelectorAll('.fourinarow__button');
	const pieces = document.querySelectorAll('.fourinarow__piece');

	buttons.forEach(function(button) {
		button.removeAttribute('disabled');
	});

	pieces.forEach(function(piece) {
		piece.classList.remove('piece');
		piece.classList.remove('p1');
		piece.classList.remove('p2');
	});

}

function getPiecePlace(column, row) {
	const fiar = document.querySelector('.fourinarow__pieces');
	return fiar.querySelector('div:nth-child(' + (column + (8 * row) + 1) + ')');
}

function fiarBuilder() {
	if (gameBuilt == true) return;
	gameBuilt = true;
	const fiar = document.querySelector('.fourinarow__pieces');
	let r = -1;
	for (let i = 0; i < 8*8; i++) {
		r += (i % 8 == 0) ? 1 : 0;
		const d = document.createElement('div');
		d.classList.add('fourinarow__piece')
		d.setAttribute("data-row", r);
		d.setAttribute("data-column", i%8);
		d.style.setProperty("--piece-row", r);
		d.style.setProperty("--piece-column", i%8);
		fiar.appendChild(d);
	}

	setButtons();
}

function setButtons() {
	const buttons = document.querySelector('.fourinarow__buttons').children;

	for (let i = 0; i < buttons.length; i++) {
		buttons[i].addEventListener('click', place.bind(buttons[i], i, -1));
	}
}

function place(column, player=0) {
	if (winner !== false && player == -1) return;
	if (!myTurn && player == -1) return;
	const lic = getLastInColumn(column);
	if (!lic) return;
	if (player == -1) {
		console.log("EMIT", { column: column, game: game, id: id });
		socket.emit('fiar_place', { column: column, game: game, id: id });
	}
	lic.classList.add("piece");
	if (player == -1) {
		// Player is this user
		player = 1;
	}
	lic.classList.add("p" + player);
	lic.style.setProperty("--piece-row", 0);
	if (getLastInColumn(column) == null) return document.querySelector('.fourinarow__buttons > button:nth-child('+(column+1)+')').disabled = 'disabled';
}

function getLastInColumn(column) {
	const fiar = document.querySelector('.fourinarow__pieces');
	for (let i = column; i < fiar.children.length; i+=8) {
		const f = fiar.children[i];
		// console.log(f.classList.contains("piece"), f);
		if (f.classList.contains("piece")) {
			// console.log(column, ((i-column)/8)-1, i);
			return document.querySelector("[data-column='"+column+"'][data-row='"+String(((i-column)/8)-1)+"']");
		}
	}
	return document.querySelector("[data-column='"+column+"'][data-row='7']");
}
