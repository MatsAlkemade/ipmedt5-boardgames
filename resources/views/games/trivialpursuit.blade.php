@extends('games.defaultGame')
@section('title')
    Trivial Pursuit
@endsection

@section('head-extra')
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<script src="//unpkg.com/string-similarity/umd/string-similarity.min.js"></script>
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
    let questions = <?= $questions ?>;

    function spellingCheck() {
        answer = document.getElementById('js--answer');

        if(correct_answer.match(/^-?\d+$/)){
            if(Object.is(answer.value, correct_answer)){
                console.log("int goed");
                answer.style.backgroundColor = "green";
            }
            else{
                console.log("int fout");
                answer.style.backgroundColor = "red";
            }
        }
        else{
            answer.value = answer.value.toLowerCase();
            correct_answer = correct_answer.toLowerCase();
            let spellingcheck = stringSimilarity.compareTwoStrings(correct_answer, answer.value);
            if(spellingcheck >= 0.8){
                console.log('String goed')
                answer.style.backgroundColor = "green";
            }
            else{
                console.log('String fout')
                answer.style.backgroundColor = "red";
            }
        }
        setTimeout(function() {
            socket.emit('tp_question', { game: game, id: id });
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
    <p></p>
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



