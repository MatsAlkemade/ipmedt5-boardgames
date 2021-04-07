const l = "email=" + __u__ + "&password=" + __p__;

const socket = io(window.location.protocol + '//' + window.location.host, { transports: ['websocket'], query: l });
let players = 2;
let gameBuilt = false;

window.addEventListener('load', function() {
	const fiar = document.querySelector('.fourinarow');
	fiar.style.display = "none";
});

socket.on('connect', function() {
	console.log("Connected to socketio server!");

	let split = window.location.pathname.split('/');

	socket.emit('join_session', { game: split[1], id: split[2] });
});

socket.on('login', function(data) {
	console.log("LOGGED IN", data);
});

socket.on('disconnect', function() {
	console.log("Disconnected from socketio server!");
});

socket.on('users', function(data) {
	console.log("update users", data);

	// document.querySelector('.js--users').innerText = JSON.stringify(data);
});

socket.on('game_start', function(data) {
	const fiar = document.querySelector('.fourinarow');
	fiar.style.display = "block";
	fiarBuilder();
});

socket.on('fiar_place', function(data) {
	console.log("PLACE", data);
});

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
	const lic = getLastInColumn(column);
	socket.emit('fiar_place', lic);
	lic.classList.add("piece");
	if (player == -1) {
		// Player is this user
		player = 1;
	}
	lic.classList.add("p" + player);
	lic.style.setProperty("--piece-row", 0);
	if (getLastInColumn(column) == null) return document.querySelector('.fourinarow__buttons > button:nth-child('+(column+1)+')').disabled = 'disabled';
	checkWin();
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

function checkWin() {
	for (let i = 0; i < players; i++) {
		const pp = document.querySelectorAll('.fourinarow__pieces > .p' + (i+1));
		// console.log(pp);
		if (pp == null || pp.length == 0) continue;

		for (let i = 0; i < pp.length; i++) {

			// console.log(pp[i]);
		}
	}

	return false;
}