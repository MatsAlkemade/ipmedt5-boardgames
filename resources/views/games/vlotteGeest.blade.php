@extends('games.defaultGame')
@section('title')
    Vlotte Geest
@endsection
@section('gamecontent')
    <article class="vlotte-geest">

        <main>
            <section class="grid-template">

                <!-- eerste sectie -->
                <section class="top__wrapper">
                    <section class="top__left">
                    <p class="cardCount">Aantal kaarten:</p>
                    <button class="button">kaart draaien</button>
                    </section>

                    <section class="top__right card">
                    <figure>
                        <img src="/img/games/Card.png" alt="...">
                    </figure>
                    </section>
                </section>

                <!-- tweede sectie -->
                <section class="objects">
                    <ul class="objects__list">
                        <li class="objects__item image__one"><img src='/img/games/bad.png' alt="..." /></li>
                        <li class="objects__item image__two"><img src='/img/games/Borstel.png' alt="..." /></li>
                        <li class="objects__item image__three"><img src='/img/games/doekie.png' alt="..." /></li>
                        <li class="objects__item image__four"><img src='/img/games/frogie.png' alt="..." /></li>
                        <li class="objects__item image__five"><img src='/img/games/Spook.png' alt="..." /></li>
                    </ul>
                </section>

            </section>
            
        </main>
    </article>
@endsection




