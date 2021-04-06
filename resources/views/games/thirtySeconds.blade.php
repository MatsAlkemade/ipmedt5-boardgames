@extends('games.defaultGame')
@section('title')
    30 Seconds
@endsection
@section('gamecontent')
    <article class="thirtySeconds">
        <h1>Content</h1>
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