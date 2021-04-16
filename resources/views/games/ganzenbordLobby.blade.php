@section('head-extra')
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<script type="text/javascript">
    let __u__ = "{{ auth()->user()->email }}";
    let __p__ = "{{ auth()->user()->password }}";
    let user_id = {{ auth()->user()->id }};
</script>
@endsection
@extends('games.defaultGame')
@section('title')
    Ganzenbord
@endsection

@section('gamecontent')
    <section class = "joinGame__buttons">
         <input class="u-button-style joinGame__buttonCreate" type="button" onclick="location.href='/ganzenbord/create';" value="Start een Spel"/>
         <p class ="joinGame__text"> Vul hier de Gamecode in om het spel te joinen</p>
         <input class="joinGame__input" id="gameInput" type="text" placeholder="123456"/>
         <input class="u-button-style joinGame__buttonJoin"  type="button" onclick="location.href='/ganzenbord/' + document.getElementById('gameInput').value;" value="Join"/>
@endsection



