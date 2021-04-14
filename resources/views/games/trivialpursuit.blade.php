@extends('games.defaultGame')
@section('title')
    Trivial Pursuit
@endsection

@section('head-extra')
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<script type="text/javascript">
    let __u__ = "{{ auth()->user()->email }}";
    let __p__ = "{{ auth()->user()->password }}";
    let user_id = {{ auth()->user()->id }};
</script>
<script src="/js/trivialpursuit.js"></script>
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
        <button onclick="checkWinner();">TEST</button>
    </article>
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



