@section('head-extra')
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<script type="text/javascript">
    let __u__ = "{{ auth()->user()->email }}";
    let __p__ = "{{ auth()->user()->password }}";
    let user_id = {{ auth()->user()->id }};
</script>
<script src="/js/ganzenbord.js"></script>
@endsection
@extends('games.defaultGame')
@section('title')
    Ganzenbord
@endsection

@section('gamecontent')
<section class="ganzenbord">
<h2 class="gb__header"><span class="js--gb-turn js--gb-other"> </span></h2>
<h2 class="gb__secondHeader"><span class="js--gb-dobbel"> </span></h2>
<ul class="gb__players">
                <li class="gb__players__goose">
                    <figure class="gb__players__goose__figure">
                        <img src="/img/gb_vakjes/gb_rood.png" alt="gans">
                        <figcaption id="speler_1">Geen Deelnemer</figcaption>
                    </figure>
                </li>
                <li class="gb__players__goose">
                    <figure class="gb__players__goose__figure">
                     <img src="/img/gb_vakjes/gb_paars.png" alt="gans">
                     <figcaption id="speler_2">Geen Deelnemer</figcaption>
                    </figure>
                </li>
                <li class="gb__players__goose">
                    <figure class="gb__players__goose__figure">
                      <img src="/img/gb_vakjes/gb_geel.png" alt="gans">
                      <figcaption id="speler_3">Geen Deelnemer</figcaption>
                    </figure>
                </li>
                <li class="gb__players__goose">
                    <figure class="gb__players__goose__figure">
                        <img src="/img/gb_vakjes/gb_blauw.png" alt="gans">
                        <figcaption id="speler_4">Geen Deelnemer</figcaption>
                    </figure>
                </li>  


                <li class="gb__player js--player1">
                    <figure class="gb__players__figure">
                        <img id="speler_1" src="/img/gb_vakjes/gb_start.png" alt="Start vakje">
                    </figure>
                </li>
            
                <li class="gb__player js--player2">
                    <figure class="gb__players__figure">
                     <img src="/img/gb_vakjes/gb_start.png" alt="Start vakje">
                    </figure>
                </li>
                <li class="gb__player js--player3">
                    <figure class="gb__players__figure">
                      <img src="/img/gb_vakjes/gb_start.png" alt="Start vakje">
                    </figure>
                </li>
                <li class="gb__player js--player4">
                    <figure class="gb__players__figure">
                        <img src="/img/gb_vakjes/gb_start.png" alt="Start vakje">
                    </figure>

                </li>
            </ul>
            <section class="gb__button">
                  <input class="u-button-style u-button-style-center" id="gb_button" type="submit" name="button" value="Dobbelen"/>
            </section>
        </section>

@endsection

@section('livechat')
    <li class="livechat__item livechat__item--console">
        <p class="livechat__item__username">Ganzenbord</p>
        <p class="livechat__item__message">Welkom bij Ganzenbord! Dit is de chat.</p>
    </li>
@endsection

@section('rules')
    <p class="gb__description"> {{$ganzenbord->description}}</p><br />
        @foreach ($ganzenbordstappen as $ganzenbordstap)
            <p class="gb__description"> {{$ganzenbordstap->description}} </p><br />
        @endforeach
@endsection


