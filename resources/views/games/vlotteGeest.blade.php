@extends('games.defaultGame')
@section('title')
    Vlotte Geest
@endsection

@section('head-extra')
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <script type="text/javascript">
        let __u__ = "{{ auth()->user()->email }}";
        let __p__ = "{{ auth()->user()->password }}";
        let user_id = {{ auth()->user()->id }};
    </script>
    <link rel="stylesheet" href="/css/vlottegeest.css">
    <script src="/js/vlottegeest.js" defer></script>
@endsection

@section('gamecontent')
    <article class="vs">

        <main>
            <article class="vs__card">

                <section class="vs__card--front">
                    <figure class="vs__image--front">
                        <img src="" alt="">
                    </figure>
                </section>

                <section class="vs__card--back">
                    <figure class="vs__image--back">
                        <img src="" alt="">
                    </figure>
                </section>

            </article>
                <!-- <section class="grid-template">

                    
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

                  
                    <section class="objects">
                        <ul class="objects__list">
                            <li class="objects__item image__one"><img src='/img/games/bad.png' alt="..." /></li>
                            <li class="objects__item image__two"><img src='/img/games/Borstel.png' alt="..." /></li>
                            <li class="objects__item image__three"><img src='/img/games/doekie.png' alt="..." /></li>
                            <li class="objects__item image__four"><img src='/img/games/frogie.png' alt="..." /></li>
                            <li class="objects__item image__five"><img src='/img/games/Spook.png' alt="..." /></li>
                        </ul>
                    </section>

                </section> -->

            
            
        </main>
    </article>
@endsection

@section('rules')
    <ul class="rules">
        <p>#1: Met één hand probeer je het gewenste item te pakken dat in de originele kleur op de kaart staat afgebeeld, bijvoorbeeld de blauwe borstel of de rode handdoek</p>
        <br/>
        <p>#2: En als er geen item in de originele kleur is afgebeeld? In dit geval pak je het item dat niet is afgebeeld en waarvan de kleur niet op de kaart staat.</p>
        <br/>
        <p>#3: Als je het juiste item pakt, leg je de omgedraaide kaart als beloning voor je neer. De gegrepen items worden in het midden van de tafel teruggeplaatst. Dan draait een van de spelers de volgende kaart om.</p>
        <br/>
        <p>#4: De speler die als laatste het afgebeelde item heeft gepakt, moet de bovenste kaart van de stapel verwijderen.</p>
    </ul>
@endsection




