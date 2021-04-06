@extends('default')

@section('title')
    &#128126; &#127918; {{$question->game}} {{$question->category}} | UBG
@endsection
@section('content')
<header class="trivialpursuit__header">
    <h1 class="trivialpursuit__title">{{$question->category}}</h1>
</header>
<main class="trivialpursuit">
    <article class="trivialpursuit__article">
        <h2 class="trivialpursuit__question">{{$question->question}}</h2>
        <input id="js--answer" class="trivialpursuit__answer" type="text" placeholder="Antwoord">
        <input id="js--correct-answer" type="hidden" value="{{$question->answer}}">
        <button class="trivialpursuit__send u-button-style" onclick="spellingCheck()">Antwoord verzenden</button>
    </article>
</main>


<script src="//unpkg.com/string-similarity/umd/string-similarity.min.js"></script>
<script src="/js/trivialpursuit-spellingcheck.js"></script>

@endsection