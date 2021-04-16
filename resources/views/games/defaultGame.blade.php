@extends('default')

@section('content')
    <main class="defaultGame">
        <section class="defaultGame__title">
            <button class="defaultGame__title__button" onclick="window.location.href='/'"><i class="fas fa-home"></i></button>
            <h1 class="defaultGame__title__text">@yield('title')</h1>
        </section>
        @yield('gamecontent')
        <section class="defaultGame__popups" id="js--popups">
            <section class="defaultGame__popups__popup" id="js--liveChat">
                <button class="popup__closeBtn" onclick="showPopup(liveChat)"><i class="fal fa-times"></i></button>
                <h2>Live Chat</h2>
                <ul class="livechat js--livechat--list">
                    <!-- <li class="livechat__item livechat__item--console">
                        <p class="livechat__item__username">Vier op een rij</p>
                        <p class="livechat__item__message">Welkom bij vier op een rij! Dit is de chat.</p>
                    </li> -->
                </ul>
                <form class="livechat__form js--livechat-form">
                    <input class="livechat__form__input" type="text" name="message">
                    <input class="livechat__form__input livechat__form__input--submit" type="submit" name="submit" value="Send">
                </form>
                @yield('livechat')
            </section>
            <section class="defaultGame__popups__popup" id="js--rules">
                <button class="popup__closeBtn" onclick="showPopup(rules)"><i class="fal fa-times"></i></button>
                <h2>Spelregels</h2>
                @yield('rules')
            </section>
        </section>
        <section class="defaultGame__footer">
        @isset ($gameCode) 
            <ul class="defaultGame__footer__list" id="js--popupBtns">
                <li class="defaultGame__footer__list__item defaultGame__footer__list__item--badge js--chat-button">
                    <button onclick="showPopup(liveChat)">
                        <i class="fas fa-comment-alt js--chat-icon"></i>
                    </button>
                </li>
                <li class="defaultGame__footer__list__item">
                    <button onclick="showPopup(rules)">
                        <i class="fas fa-book-user"></i>
                    </button>
                </li>
                <li class="defaultGame__footer__list__item">
                    <button onclick="socket.emit('game_start', {game: game, id: {{$gameCode}}})">
                    <i class="fas fa-play"></i>
                    </button>
                </li>
            </ul>
            @endisset
        </section>
    </main>
@endsection