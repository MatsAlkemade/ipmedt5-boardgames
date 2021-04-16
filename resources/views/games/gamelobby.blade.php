@extends('games.defaultGame')

@section('title')
    Lobby - {{$gameType}}
@endsection

@section('head-extra')
    <script type="text/javascript">
        let __u__ = "{{ auth()->user()->email }}";
        let __p__ = "{{ auth()->user()->password }}";
        let user_id = {{ auth()->user()->id }};
        let gameType = "{{$gameType}}"
    </script>
    <script src="/js/gamelobby.js" defer></script>
@endsection

@section('gamecontent')
    <section class="lobby">
        <section class="lobby__title">
            <h1>Welkom bij {{$gameType}}!</h1>
            <h2>Game code: {{$gameCode}}</h2>
        </section>
        <section class="lobby__users">
            <h2>Spelers</h2>
            <ul class="lobby__users__list" id="js--userList">
                @foreach($users as $user)
                    <li class="lobby__users__list__item" data-id="{{$user->id}}">
                        <i class="fas fa-trash-alt"></i>
                        <p>{{$user->name}}</p>
                        @if($gameType == "Thirty Seconds")
                            <i class="fas fa-flag redFlag"></i>
                            <i class="fas fa-flag blueFlag"></i>
                        @endif
                    </li>
                @endforeach
            </ul>
        </section>
        <section class="lobby__error">
            <p id="js--error">Errors</p>
        </section>
        <section class="lobby__button">
            <button class="u-button-style" id="js--startGameBtn">Start het spel</button>
        </section>
    </section>
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