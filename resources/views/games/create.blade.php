@extends('default')

@section('content')
    <main class="defaultGame">
        <header class="defaultGame__title">
            <button class="defaultGame__title__button"><i class="fas fa-home"></i></button>
            <h1 class="defaultGame__title__text">@yield('title')</h1>
        </header>
        <p>Create for game: {{ $game }}</p>
        @yield('gamecontent')
        <footer class="defaultGame__footer">
            <ul class="defaultGame__footer__list">
                <li class="defaultGame__footer__list__item"></i><i class="fas fa-comment-alt"></i></li>
                <li class="defaultGame__footer__list__item"><i class="fas fa-book-user"></i></li>
                <li class="defaultGame__footer__list__item"><i class="fas fa-chess-pawn-alt"></i></li>
            </ul>
        </footer>
    </main>
@endsection