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
    let answer;
    let question;
    let correct_answer;
    let questions = <?= $questions ?>; //leest de php varibalen uit en zet het om naar een .json bestand

    function spellingCheck() {
        answer = document.getElementById('js--answer'); //pakt het ingevulde antwoord

        if(correct_answer.match(/^-?\d+$/)){ //kijkt of de vraag een int is
            if(Object.is(answer.value, correct_answer)){
                console.log("int goed");
                socket.emit('tp_vraag', {antwoord: 1, game: game, id: id });
                answer.style.backgroundColor = "green";
            }
            else{
                console.log("int fout");
                socket.emit('tp_vraag', {antwoord: 2, game: game, id: id });
                answer.style.backgroundColor = "red";
            }
        }
        else{
            answer.value = answer.value.toLowerCase(); //zet de user input naar kleine letters want stringSimilarity is hoofdletter gevoelig
            correct_answer = correct_answer.toLowerCase(); // zelfde als hierboven maar dan voort het antwoord
            let spellingcheck = stringSimilarity.compareTwoStrings(correct_answer, answer.value); //voert de controlle uit en krijgt een getal tussen de 0 en 1 terug
            if(spellingcheck >= 0.8){ //als de overeenkomst 80% is het goed anders fout
                console.log('String goed')
                socket.emit('tp_vraag', {antwoord: 1, game: game, id: id });
                answer.style.backgroundColor = "green";
            }
            else{
                console.log('String fout')
                socket.emit('tp_vraag', {antwoord: 2, game: game, id: id });
                answer.style.backgroundColor = "red";
            }
        }
        setTimeout(function() {
            socket.emit('tp_question', { game: game, id: id }); //pakt een andere vraag
        }, 1000);
    }
    
    window.addEventListener('load', function() {
        question = document.getElementById('js--question');
        correct_answer = document.getElementById('js--correct-answer').value;
        document.getElementsByClassName('trivialpursuit__send')[0].addEventListener('click', spellingCheck);
        socket.emit('tp_question', { game: game, id: id });
    });

    function createQuestion(){
        answer = document.getElementById('js--answer');
        answer.value = "";
        answer.style.backgroundColor = "white";
        question.innerText = questions[questionId].question;
        correct_answer = questions[questionId].answer;
    }

</script>
@endsection

@section('gamecontent')
    <article class="trivialpursuit__pie_container">
        <section class="trivialpursuit__pie">
            <h2>Player 1</h2>
            <div class="trivialpursuit__items" data-type-categorie="WetenschapNatuur">Wetenschap & Natuur</div>
            <div class="trivialpursuit__items" data-type-categorie="Sport">Sport</div>
            <div class="trivialpursuit__items" data-type-categorie="KunstLiteratuur">Kunst & Literatuur</div>
            <div class="trivialpursuit__items" data-type-categorie="Geschiedenis">Geschiedenis</div>
            <div class="trivialpursuit__items" data-type-categorie="Amusument">Amusument</div>
            <div class="trivialpursuit__items" data-type-categorie="Aardrijkskunde">Aardrijkskunde</div>
        </section>

        <section class="trivialpursuit__pie">
            <h2>Player 2</h2>
            <div class="trivialpursuit__items" data-type-categorie="WetenschapNatuur">Wetenschap & Natuur</div>
            <div class="trivialpursuit__items" data-type-categorie="Sport">Sport</div>
            <div class="trivialpursuit__items" data-type-categorie="KunstLiteratuur">Kunst & Literatuur</div>
            <div class="trivialpursuit__items" data-type-categorie="Geschiedenis">Geschiedenis</div>
            <div class="trivialpursuit__items" data-type-categorie="Amusument">Amusument</div>
            <div class="trivialpursuit__items" data-type-categorie="Aardrijkskunde">Aardrijkskunde</div>
        </section>

        <section class="trivialpursuit__pie">
            <h2>Player 3</h2>
            <div class="trivialpursuit__items" data-type-categorie="WetenschapNatuur">Wetenschap & Natuur</div>
            <div class="trivialpursuit__items" data-type-categorie="Sport">Sport</div>
            <div class="trivialpursuit__items" data-type-categorie="KunstLiteratuur">Kunst & Literatuur</div>
            <div class="trivialpursuit__items" data-type-categorie="Geschiedenis">Geschiedenis</div>
            <div class="trivialpursuit__items" data-type-categorie="Amusument">Amusument</div>
            <div class="trivialpursuit__items" data-type-categorie="Aardrijkskunde">Aardrijkskunde</div>
        </section>

        <section class="trivialpursuit__pie">
            <h2>Player 4</h2>
            <div class="trivialpursuit__items" data-type-categorie="WetenschapNatuur">Wetenschap & Natuur</div>
            <div class="trivialpursuit__items" data-type-categorie="Sport">Sport</div>
            <div class="trivialpursuit__items" data-type-categorie="KunstLiteratuur">Kunst & Literatuur</div>
            <div class="trivialpursuit__items" data-type-categorie="Geschiedenis">Geschiedenis</div>
            <div class="trivialpursuit__items" data-type-categorie="Amusument">Amusument</div>
            <div class="trivialpursuit__items" data-type-categorie="Aardrijkskunde">Aardrijkskunde</div>
        </section>
    </article>

    <section class="trivialpursuit__article">
        <h2 id="js--question" class="trivialpursuit__question"></h2>
        <input id="js--answer" class="trivialpursuit__answer" type="text" placeholder="Antwoord">
        <input id="js--correct-answer" type="hidden" value="">
        <button class="trivialpursuit__send u-button-style">Antwoord verzenden</button>
    </section>
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



