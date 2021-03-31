@extends('default')

@section('content')
    <main class="home">
        <header class="default_title">
            <i class="fas fa-home"></i>
        </header>

        <article class="default__main">
            @yield('gamecontent')
        </article>

        <footer class="default__footer">
            <ul class="default__footer__list">
                <li class="default__footer__list__item"></i><i class="fas fa-comment-alt"></i></li>
                <li class="default__footer__list__item"><i class="fas fa-book-user"></i></li>
                <li class="default__footer__list__item"><i class="fas fa-chess-pawn-alt"></i></li>
            </ul>
        </footer>
    </main>
@endsection