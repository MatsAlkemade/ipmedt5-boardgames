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
    <main class="vs" id="vs--js">

        <section class="vs__devider">
            <section class="vs__section">
                <p class="vs__counter">Aantal kaarten: &nbsp; <span id="cardCount">60</span> </p>
                <button class="vs__button--turn" id="turn--180" onclick="cardFlip()">kaaart draaien</button>
                <button class="vs__button--turnBack" id="turn--360" onclick="cardFlipBack()">volgende kaart</button>
            </section>

            <section class="vs__flip-card-c">
                <div class="vs__flip-card" id="flip_card--js">
                    <div class="vs__flip-card-inner" id="flip_card--js">
                        <div class="vs__flip-card-front">
                          
                        </div>

                        <div class="vs__flip-card-back">
                            <figure class="vs__flip-card--image">
                                <img alt="leeg" id="randomImages--js">
                            </figure>
                        </div>
                    </div>
                </div>
            </section>
        </section>
        
        <article class="vs__objects">
            <ul class="vs__list">
                <li class="vs__list__item" id="spook--js" data-value="Spook.png">Spook</li>
                <li class="vs__list__item" id="kikker--js" data-value="frogie.png">Kikker</li>
                <li class="vs__list__item" id="badkuip--js" data-value="bad.png">Badkuip</li>
                <li class="vs__list__item" id="borstel--js" data-value="Borstel.png">Borstel</li>
                <li class="vs__list__item" id="kleed--js" data-value="doekie.png">Kleed</li>
            </ul>
        </article>

    </main>
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




