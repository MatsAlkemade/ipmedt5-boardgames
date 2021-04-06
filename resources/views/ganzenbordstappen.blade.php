@extends('games.defaultGame')
@section('title')
    Ganzenbord
@endsection

@section('gamecontent')
    <article class="thirtySeconds">
        <h1>Content</h1>
    </article>
@endsection

@section('livechat')

@endsection

@section('rules')
    <p>regels</p>
@endsection
@section('content')
<h2 class="gb__title" >Ganzenbord</h2>
<ul class="gb__players">
                <li class="gb__players__goose">
                    <figure class="gb__players__goose__figure">
                        <img src="/img/gb_vakjes/gb_rood.png" alt="gans">
                        <figcaption>Speler 1</figcaption>
                    </figure>
                </li>
                <li class="gb__players__goose">
                    <figure class="gb__players__goose__figure">
                     <img src="/img/gb_vakjes/gb_paars.png" alt="gans">
                     <figcaption>Speler 2</figcaption>
                    </figure>
                </li>
                <li class="gb__players__goose">
                    <figure class="gb__players__goose__figure">
                      <img src="/img/gb_vakjes/gb_geel.png" alt="gans">
                      <figcaption>Speler 3</figcaption>
                    </figure>
                </li>
                <li class="gb__players__goose">
                    <figure class="gb__players__goose__figure">
                        <img src="/img/gb_vakjes/gb_blauw.png" alt="gans">
                        <figcaption>Speler 4</figcaption>
                    </figure>
                </li>  


                <li class="gb__player">
                    <figure class="gb__players__figure">
                        <img src="/img/gb_vakjes/gb_start.png" alt="Start vakje">
                    </figure>
                </li>
                <li class="gb__player">
                    <figure class="gb__players__figure">
                     <img src="/img/gb_vakjes/gb_start.png" alt="Start vakje">
                    </figure>
                </li>
                <li class="gb__player">
                    <figure class="gb__players__figure">
                      <img src="/img/gb_vakjes/gb_start.png" alt="Start vakje">
                    </figure>
                </li>
                <li class="gb__player">
                    <figure class="gb__players__figure">
                        <img src="/img/gb_vakjes/gb_start.png" alt="Start vakje">
                    </figure>

                </li>
            </ul>

@endsection