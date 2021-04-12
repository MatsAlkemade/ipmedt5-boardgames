@extends('games.defaultGame')
@section('title')
    30 Seconds
@endsection

<?php
    $r = mt_rand(0,1);
?>

@section('gamecontent')
    <article class="ts">
        <section class="ts__cardWrapper" id="js--tsCard">
            <section class="ts__card ts__front">
                <figure>
                    <img src="/img/ts/ts.png" alt="Thirty Seconds">
                </figure>
            </section>
            <section class="ts__card ts__back" id="js--tsCardBack">
                <form action="/thirtyseconds" method="post" class="ts__card__form" id="js--tsCardForm">
                    @csrf
                    <section class="ts__card__form__item">
                        <label for="q1">{{$tsq[0]->question_1}}</label>
                        <input type="checkbox" value="true" id="q1" name="q1">
                    </section>
                    <section class="ts__card__form__item">
                        <label for="q2">{{$tsq[0]->question_2}}</label>
                        <input type="checkbox" value="true" id="q2" name="q2">
                    </section>
                    <section class="ts__card__form__item">
                        <label for="q3">{{$tsq[0]->question_3}}</label>
                        <input type="checkbox" value="true" id="q3" name="q3">
                    </section>
                    <section class="ts__card__form__item">
                        <label for="q4">{{$tsq[0]->question_4}}</label>
                        <input type="checkbox" value="true" id="q4" name="q4">
                    </section>
                    <section class="ts__card__form__item">
                        <label for="q5">{{$tsq[0]->question_5}}</label>
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
            <button class="u-button-style" id="js--tsCardSubmitBtn" onclick="tsSubmitForm()" disabled>Bevestigen</button>
        </section>
    </article>
@endsection

@section('livechat')

@endsection

@section('rules')
    <p>{{$ts->description}}</p>
@endsection

@section('position')
    <section class="tsPos">
        <section class="tsPos__team">
            <p class="tsPos__team__title">Rood</p>
            <figure class="tsPos__team__img">
                <img src="/img/ts/ts_rood.png" alt="Logo Team Rood">
            </figure>
            <section class="tsPos__team__pos">
                <p>0</p>
            </section>
        </section>
        <section class="tsPos__team">
            <p class="tsPos__team__title">Blauw</p>
            <figure class="tsPos__team__img">
                <img src="/img/ts/ts_blauw.png" alt="Logo Team Blauw">
            </figure>
            <section class="tsPos__team__pos">
                <p>0</p>
            </section>
        </section>
    </section>
@endsection