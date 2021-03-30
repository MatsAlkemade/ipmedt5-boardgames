@extends('default')

@section('title')
    Ultimate Boardgames
@endsection

@section('content')
    <main class="home">
        <header class="home__title">
            <h1 class="home__title__text">Ultimate Boardgames</h1>
            <button class="home__title__button">
                <i class="fal fa-user-circle"></i>
            </button>
        </header>
        <article class="home__main">
            <h2>Spellen</h2>
            <ul class="home__games">
                <li class="home__game">
                    <figure class="home__game__figure">
                        <img src="/img/games/vieropeenrij.jpg" alt="Vier Op Een Rij">
                        <figcaption>Vier Op Een Rij</figcaption>
                    </figure>
                    <button class="home__game__button u-button-style">Spelen</button>
                </li>
                <li class="home__game">
                    <figure class="home__game__figure">
                        <img src="/img/games/thirtyseconds.jpg" alt="30 Seconds">
                        <figcaption>30 Seconds</figcaption>
                    </figure>
                    <button class="home__game__button u-button-style">Spelen</button>
                </li>
                <li class="home__game">
                    <figure class="home__game__figure">
                        <img src="/img/games/trivialpursuit.jpg" alt="Trivial Pursuit">
                        <figcaption>Trivial Pursuit</figcaption>
                    </figure>
                    <button class="home__game__button u-button-style">Spelen</button>
                </li>
                <li class="home__game">
                    <figure class="home__game__figure">
                        <img src="/img/games/vlottegeest.jpg" alt="Vlotte Geesten">
                        <figcaption>Vlotte Geesten</figcaption>
                    </figure>
                    <button class="home__game__button u-button-style">Spelen</button>
                </li>
                <li class="home__game">
                    <figure class="home__game__figure">
                        <img src="/img/games/ganzenbord.jpg" alt="Ganzenbord">
                        <figcaption>Ganzenbord</figcaption>
                    </figure>
                    <button class="home__game__button u-button-style">Spelen</button>
                </li>
            </ul>
        </article>
        <footer class="home__footer">
            <p>Bordspel verbonden: </p>
            <i class="fas fa-microchip home__footer__icon"></i>
        </footer>
    </main>
@endsection