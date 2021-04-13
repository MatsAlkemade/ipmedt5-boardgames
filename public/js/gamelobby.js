const l = "email=" + __u__ + "&password=" + __p__;
const socket = io(window.location.protocol + '//' + window.location.host, { transports: ['websocket'], query: l });
let split = window.location.pathname.split('/');
let game = split[1];
let id = split[2];

const redFlags = [...document.getElementsByClassName("redFlag")];
const blueFlags = [...document.getElementsByClassName("blueFlag")];
const trashcans = [...document.getElementsByClassName("fa-trash-alt")];
const userList = document.getElementById("js--userList");
const error = document.getElementById("js--error");
const startGameBtn = document.getElementById("js--startGameBtn");

let teamRed = [];
let teamBlue = [];

startGameBtn.addEventListener('click', function() {
    socket.emit('ts_start', { game: game, id: id, teams: [ { team: 0, users: [] }, { team: 1, users: [] } ] });
});

redFlags.forEach(function (flagElement) {
    flagElement.addEventListener('click', function(e){
        let username = e.target.parentNode.getElementsByTagName('p')[0];
        if(e.target.style.opacity > .6){
            e.target.parentNode.classList.remove("redTeam");
            e.target.style.opacity = ".5";
            username.style.color = "black";
            error.style.opacity = 0;
        } else {
            if (checkTeamAmount("redTeam") == false){
                return;
            }
            error.style.opacity = 0;
            e.target.style.opacity = "1";
            e.target.parentNode.getElementsByClassName("blueFlag")[0].style.opacity = ".5";
            e.target.parentNode.classList.add("redTeam");
            e.target.parentNode.classList.remove("blueTeam");
            username.style.color = "orangered";
        }
    });    
 });

blueFlags.forEach(function (flagElement) {
    flagElement.addEventListener('click', function(e){
        let username = e.target.parentNode.getElementsByTagName('p')[0];
        if(e.target.style.opacity > .6){
            e.target.parentNode.classList.remove("blueTeam");
            e.target.style.opacity = ".5";
            username.style.color = "black";
            error.style.opacity = 0;
        } else {
            if (checkTeamAmount("blueTeam") == false){
                return;
            }
            error.style.opacity = 0;
            e.target.style.opacity = "1";
            e.target.parentNode.getElementsByClassName("redFlag")[0].style.opacity = ".5";
            e.target.parentNode.classList.add("blueTeam");
            e.target.parentNode.classList.remove("redTeam");
            username.style.color = "cornflowerblue";
        }
    });    
 });

function checkTeamAmount(team) {
    userList.getElementsByTagName("li");
    let teamList = userList.getElementsByClassName(team);
    if(teamList.length > 1){
        error.innerText = "Dit team heeft al 2 spelers!";
        error.style.opacity = 1;
        return false;
    }
    return true;
};

trashcans.forEach(function (trashcan) {
    trashcan.addEventListener('click', function(e){
        // functie voor user verwijderen
    });    
 });