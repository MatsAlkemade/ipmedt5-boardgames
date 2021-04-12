@extends('default')

@section('content')
    <main class="defaultGame">
        <section class="defaultGame__title">
            <button class="defaultGame__title__button"><i class="fas fa-home"></i></button>
            <h1 class="defaultGame__title__text">@yield('title')</h1>
        </section>
        @yield('gamecontent')
        <section class="defaultGame__popups" id="js--popups">
            <section class="defaultGame__popups__popup" id="js--liveChat">
                <button class="popup__closeBtn" onclick="showPopup(liveChat)"><i class="fal fa-times"></i></button>
                <h2>Live Chat</h2>
                @yield('livechat')
            </section>
            <section class="defaultGame__popups__popup" id="js--rules">
                <button class="popup__closeBtn" onclick="showPopup(rules)"><i class="fal fa-times"></i></button>
                <h2>Spelregels</h2>
                @yield('rules')
            </section>
            <section class="defaultGame__popups__popup" id="js--position">
                <button class="popup__closeBtn" onclick="showPopup(position)"><i class="fal fa-times"></i></button>
                <h2>Positie</h2>
                @yield('position')
            </section>
        </section>
        <section class="defaultGame__footer">
            <ul class="defaultGame__footer__list" id="js--popupBtns">
                <li class="defaultGame__footer__list__item">
                    <button onclick="showPopup(liveChat)">
                        <i class="fas fa-comment-alt"></i>
                    </button>
                </li>
                <li class="defaultGame__footer__list__item">
                    <button onclick="showPopup(rules)">
                        <i class="fas fa-book-user"></i>
                    </button>
                </li>
                <li class="defaultGame__footer__list__item">
                    <button onclick="showPopup(position)">
                        <i class="fas fa-chess-pawn-alt"></i>
                    </button>
                </li>
            </ul>
        </section>
    </main>
@endsection