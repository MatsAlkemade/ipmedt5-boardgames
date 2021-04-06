const socket = io(window.location.protocol + '//' + window.location.host, { transports: ['websocket'] });

socket.on('connect', function() {
	console.log("Connected to socketio server!");

	let split = window.location.pathname.split('/');

	socket.emit('join_session', { game: split[1], id: split[2] });
});

socket.on('disconnect', function() {
	console.log("Disconnected from socketio server!");
});

socket.on('users', function(data) {
	console.log("update users", data);

	document.querySelector('.js--users').innerText = JSON.stringify(data);
});