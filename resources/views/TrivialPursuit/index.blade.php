@extends('games.defaultGame')
@section('title')
&#128126; &#127918; Ultimate Boardgames | {{$trivialpursuit->name}}
@endsection

@section('gamecontent')

<header class="trivialpursuit__header">
    <h1 class="trivialpursuit__title">{{$trivialpursuit->name}}</h1>
    <h3 class="trivialpursuit__desc">{{$trivialpursuit->description}}</h3>
    <h2 class="trivialpursuit__home"><i class="far fa-arrow-left"></i> UBG</h2>
</header>
<article class="trivialpursuit">
    <section class="trivialpursuit__section">
        <h4 class="trivialpursuit__section__title">Spelregels</h4>
        <p class="trivialpursuit__section__text">Bij {{$trivialpursuit->name}} moet jij als eerst je taart vullen. Je kan de taart vullen door op de speciale vakje te komen en dan de vraag goed te beantwoorden. Als je de vraag goed hebt krijg je een punt.</p>
        <p class="trivialpursuit__section__text">De categorieën:</p>
        <ul class="trivialpursuit__section__categorie-text">
            <li>Wetenschap & Natuur</li>
            <li>Sport</li>
            <li>Kunst & Literatuur</li>
            <li>Geschiedenis</li>
            <li>Amusument</li>
            <li>Aardrijkskunde</li>
        </ul>
    </section>
    <section class="trivialpursuit__section trivialpursuit__section--flex">
        <h4 class="trivialpursuit__section__title">Categorieën</h4>
        <ul class="trivialpursuit__categories u-ul-style">
            <li class="trivialpursuit__categorie"><button data-categorie="WetenschapNatuur" class="u-button-style trivialpursuit__btn">Wetenschap & Natuur</button></li>
            <li class="trivialpursuit__categorie"><button data-categorie="Sport" class="u-button-style trivialpursuit__btn">Sport</button></li>
            <li class="trivialpursuit__categorie"><button data-categorie="KunstLiteratuur" class="u-button-style trivialpursuit__btn">Kunst & Literatuur</button></li>
            <li class="trivialpursuit__categorie"><button data-categorie="Geschiedenis" class="u-button-style trivialpursuit__btn">Geschiedenis</button></li>
            <li class="trivialpursuit__categorie"><button data-categorie="Amusument" class="u-button-style trivialpursuit__btn">Amusument</button></li>
            <li class="trivialpursuit__categorie"><button data-categorie="Aardrijkskunde" class="u-button-style trivialpursuit__btn">Aardrijkskunde</button></li>
        </ul>
    </section>
</article>
@endsection