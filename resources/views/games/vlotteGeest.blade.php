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
    <main class="vs">

        <section class="vs__devider">
            <section class="vs__section">
                <p class="vs__counter">Aantal kaarten: 0</p>
                <button class="vs__button--turn">kaaart draaien</button>
                <button class="vs__button--turnBack">volgende kaart</button>
            </section>

            <section class="vs__card">
                <div class="vs__card__inner">
                    <div class="vs__card__face vs__card__face--front">
                        <!-- <figure>
                            <img src="" alt="empty">
                        </figure> -->
                        <p>vlotte geest</p>
                    </div>
                    
                    <div class="vs__card__face vs__card__face--back">
                        <!-- <figure>
                            <img src="" alt="empty">
                        </figure> -->
                        <p>spook</p>
                    </div>
                </div>
                
            </section>
        </section>
        
        <article class="vs__objects">
            <ul class="vs__list">
                <li class="vs__list__item">Geest</li>
                <li class="vs__list__item">Kikker</li>
                <li class="vs__list__item">Badkuip</li>
                <li class="vs__list__item">Borstel</li>
                <li class="vs__list__item">Kleed</li>
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




