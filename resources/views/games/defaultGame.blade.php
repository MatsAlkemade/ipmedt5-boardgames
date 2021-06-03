@extends('default')

@section('content')
    <main class="defaultGame">
        <section class="defaultGame__title">
            <button class="defaultGame__title__button" aria-label="Go to home" onclick="window.location.href='/'"><i class="fas fa-home"></i></button>
            <h1 class="defaultGame__title__text">@yield('title')</h1>
        </section>
        @yield('gamecontent')
        <section class="defaultGame__popups" id="js--popups">
            <section class="defaultGame__popups__popup" id="js--liveChat">
                <button class="popup__closeBtn" aria-label="Close popup" onclick="showPopup(liveChat)"><i class="fal fa-times"></i></button>
                <h2>Live Chat</h2>
                <ul class="livechat js--livechat--list">
                    @yield('livechat')
                </ul>
                <form class="livechat__form js--livechat-form">
                    <input aria-label="Message" class="livechat__form__input" type="text" name="message">
                    <input aria-label="Send message" class="livechat__form__input livechat__form__input--submit" type="submit" name="submit" value="Send">
                </form>
            </section>
            <section class="defaultGame__popups__popup" id="js--rules">
                <button class="popup__closeBtn" aria-label="Close popup" onclick="showPopup(rules)"><i class="fal fa-times"></i></button>
                <h2>Spelregels</h2>
                @yield('rules')
            </section>
        </section>
        <section class="defaultGame__footer">
        @isset ($gameCode) 
            <ul class="defaultGame__footer__list" id="js--popupBtns">
                <li class="defaultGame__footer__list__item defaultGame__footer__list__item--badge js--chat-button">
                    <button aria-label="Open popup" onclick="showPopup(liveChat)">
                        <i class="fas fa-comment-alt js--chat-icon"></i>
                    </button>
                </li>
                <li class="defaultGame__footer__list__item">
                    <button aria-label="Open popup" onclick="showPopup(rules)">
                        <i class="fas fa-book-user"></i>
                    </button>
                </li>
                <li class="defaultGame__footer__list__item">
                    <button aria-label="Start de game" onclick="socket.emit('game_start', {game: game, id: {{$gameCode}}})">
                    <i class="fas fa-play"></i>
                    </button>
                </li>
            </ul>
            @endisset
        </section>
    </main>
@endsection