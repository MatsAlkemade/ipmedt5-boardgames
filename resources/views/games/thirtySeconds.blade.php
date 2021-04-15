@extends('games.defaultGame')
@section('title')
    30 Seconds
@endsection

@section('head-extra')
    <script type="text/javascript">
        let __u__ = "{{ auth()->user()->email }}";
        let __p__ = "{{ auth()->user()->password }}";
        let user_id = {{ auth()->user()->id }};
    </script>
    <script src="/js/thirtyseconds.js" defer></script>
    <link rel="stylesheet" type="text/css" href="/css/thirtyseconds.css">
@endsection

@section('gamecontent')
    <article class="ts">
        <section class="ts__state">
            <p id="js--tsState">Niemand is aan de beurt</p>
        </section>
        <section class="ts__cardWrapper" id="js--tsCard">
            <section class="ts__card ts__front">
                <figure>
                    <img src="/img/ts/ts.png" alt="Thirty Seconds">
                </figure>
            </section>
            <section class="ts__card ts__back" id="js--tsCardBack">
                <form action="/thirtyseconds" method="post" class="ts__card__form" id="js--tsCardForm">
                    @csrf
                    <input type="hidden" name="gameId" id="js--formGameId">
                    <section class="ts__card__form__item">
                        <label for="q1" id="label-q1">{{$tsq[0]->question_1}}</label>
                        <input type="checkbox" value="true" id="q1" name="q1">
                    </section>
                    <section class="ts__card__form__item">
                        <label for="q2" id="label-q2">{{$tsq[0]->question_2}}</label>
                        <input type="checkbox" value="true" id="q2" name="q2">
                    </section>
                    <section class="ts__card__form__item">
                        <label for="q3" id="label-q3">{{$tsq[0]->question_3}}</label>
                        <input type="checkbox" value="true" id="q3" name="q3">
                    </section>
                    <section class="ts__card__form__item">
                        <label for="q4" id="label-q4">{{$tsq[0]->question_4}}</label>
                        <input type="checkbox" value="true" id="q4" name="q4">
                    </section>
                    <section class="ts__card__form__item">
                        <label for="q5" id="label-q5">{{$tsq[0]->question_5}}</label>
                        <input type="checkbox" value="true" id="q5" name="q5">
                    </section>
                </form>
            </section>
        </section>
        <section class="ts__timer">
            <section class="ts__timer__line">
                <section id="js--tsTimerBar"></section>
            </section>
            <p class="ts__timer__time" id="js--tsTimer">30</p>
        </section>
        <section class="ts__btns">
            <button class="u-button-style" id="js--tsCardTurnBtn" onclick="turnCard()">Draai kaart</button>
            <button class="u-button-style" id="js--tsCardSubmitBtn" onclick="submitTurn(event)" disabled>Bevestigen</button>
        </section>
    </article>
@endsection

@section('livechat')
    <li class="livechat__item livechat__item--console">
        <p class="livechat__item__username">30 Seconds</p>
        <p class="livechat__item__message">Welkom bij 30 seconds! Dit is de chat.</p>
    </li>
@endsection

@section('rules')
    <p>{{$ts->description}}</p>
@endsection