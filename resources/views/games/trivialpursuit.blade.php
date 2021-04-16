@extends('games.defaultGame')
@section('title')
    Trivial Pursuit
@endsection

@section('head-extra')
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<script src="//unpkg.com/string-similarity/umd/string-similarity.min.js">//dit zorgt ervoor dat de spellingCheck() werkt en volgens de Dice coefficient</script>
<script type="text/javascript">
    let __u__ = "{{ auth()->user()->email }}";
    let __p__ = "{{ auth()->user()->password }}";
    let user_id = {{ auth()->user()->id }};
</script>
<script src="/js/trivialpursuit.js"></script>
<script>
    function load(){
        let answer;
        let question;
        let correct_answer;
        let plaats = 0;
        let questions = <?= $questions ?>; //leest de php varibalen uit en zet het om naar een .json bestand

        function spellingCheck() {
            answer = document.getElementById('js--answer'); //pakt het ingevulde antwoord
            let plek = plaats;

            if(correct_answer.match(/^-?\d+$/)){ //kijkt of de vraag een int is
                if(Object.is(answer.value, correct_answer)){
                    ++plek;
                    answer.style.backgroundColor = "green";
                }
                else{
                    --plek;
                    answer.style.backgroundColor = "red";
                }
            }
            else{
                answer.value = answer.value.toLowerCase(); //zet de user input naar kleine letters want stringSimilarity is hoofdletter gevoelig
                correct_answer = correct_answer.toLowerCase(); // zelfde als hierboven maar dan voort het antwoord
                let spellingcheck = stringSimilarity.compareTwoStrings(correct_answer, answer.value); //voert de controlle uit en krijgt een getal tussen de 0 en 1 terug
                if(spellingcheck >= 0.8){ //als de overeenkomst 80% is het goed anders fout
                    ++plek;
                    answer.style.backgroundColor = "green";
                }
                else{
                    --plek;
                    answer.style.backgroundColor = "red";
                }
            }
            if(plek == -1){
                plek = 0;
            }
            socket.emit('tp_question', { game: game, id: id }); //pakt een andere vraag
            socket.emit('tp_lopen', {plek: plek, game: game, id: id }); //update de plek op het bord
            socket.emit('tp_getPlaats', {game: game, id: id}); //pakt de nieuwe plek op het bord

        }
        
        question = document.getElementById('js--question');
        correct_answer = document.getElementById('js--correct-answer').value;
        document.getElementsByClassName('trivialpursuit__send')[0].addEventListener('click', spellingCheck);

        socket.on('tp_getPlaats', function(data) {
            plaats = data[{{$loggedId}}].plek;
            console.log("__GET_PLAATS__", data);
        });

        socket.on('tp_getWinner', function(data) {
            document.getElementById('js--gewonnen').innerText = data[0] + " heeft gewonnen!";
        });

        function createQuestion(){
            answer = document.getElementById('js--answer');
            answer.value = "";
            answer.style.backgroundColor = "white";
            question.innerText = questions[questionId].question;
            correct_answer = questions[questionId].answer;
        }

        socket.on('tp_question', function(data) {
            questionId = data;
            createQuestion();
        });
    }
    window.addEventListener('load', load);
    window.addEventListener('load', beginGame);
</script>
@endsection

@section('gamecontent')
    <h2 class="tp_winner" id="js--gewonnen">Het spel is nog niet begonnen</h2>
    <section class="trivialpursuit__article">
        <h2 id="js--question" class="trivialpursuit__question"></h2>
        <input id="js--answer" class="trivialpursuit__answer" type="text" placeholder="Antwoord">
        <input id="js--correct-answer" type="hidden" value="">
        <button class="trivialpursuit__send u-button-style">Antwoord verzenden</button>
    </section>

    <button class="tp__start_btn u-button-style u-button-style-absolute" id='js--tp__start'>Begin game</button>
@endsection

@section('livechat')

@endsection

@section('rules')
<p>Het doel van het spel is om als eerst de taart te vullen. Je kan taart stukjes verdienen door op de speciale vakjes te landen (de gele rand) en de vraag goed te beantwoorden.</p>
<p><br></p>
<p>Na dat je gegooid hebt landt je op vakje en komt er een vraag op het scherm van die caetgorie, als je de vraag goed hebt mag je nog een keer gooien heb je de vraag fout dan is de volgende speler aan de beurt</p>
<p><br></p>
<p>Als een speler op een donker blauw vakje komt hoeft hij geen vraag te beantwoorden, maar mag hij nog een keer gooien.</p>
@endsection



