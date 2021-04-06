@extends('games.defaultGame')
@section('head-extra')
<script src="/js/fourinarow.js"></script>
@endsection

@section('title')
    Vier op een rij
@endsection
@section('gamecontent')
    <article class="defaultGame__main">
        <h1>Four in a row</h1>
        <p>Join code: <span>{{ $gameCode }}</span></p>
        <p class="js--users">{{ $users }}</p>
    </article>
@endsection