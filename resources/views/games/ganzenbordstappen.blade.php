@section('head-extra')
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<script type="text/javascript">
    let __u__ = "{{ auth()->user()->email }}";
    let __p__ = "{{ auth()->user()->password }}";
    let user_id = {{ auth()->user()->id }};
</script>
<script src="/js/ganzenbord.js"></script>
@endsection
@extends('games.defaultGame')
@section('title')
    Ganzenbord
@endsection

@section('gamecontent')
<ul class="gb__players">
                <li class="gb__players__goose">
                    <figure class="gb__players__goose__figure">
                        <img src="/img/gb_vakjes/gb_rood.png" alt="gans">
                        <figcaption>Speler 1</figcaption>
                    </figure>
                </li>
                <li class="gb__players__goose">
                    <figure class="gb__players__goose__figure">
                     <img src="/img/gb_vakjes/gb_paars.png" alt="gans">
                     <figcaption>Speler 2</figcaption>
                    </figure>
                </li>
                <li class="gb__players__goose">
                    <figure class="gb__players__goose__figure">
                      <img src="/img/gb_vakjes/gb_geel.png" alt="gans">
                      <figcaption>Speler 3</figcaption>
                    </figure>
                </li>
                <li class="gb__players__goose">
                    <figure class="gb__players__goose__figure">
                        <img src="/img/gb_vakjes/gb_blauw.png" alt="gans">
                        <figcaption>Speler 4</figcaption>
                    </figure>
                </li>  


                <li class="gb__player">
                    <figure class="gb__players__figure">
                        <img id="speler_1" name="canvas" src="/img/gb_vakjes/gb_start.png" alt="Start vakje">
                    </figure>
                </li>
            

                <li class="gb__player">
                    <figure class="gb__players__figure">
                     <img src="/img/gb_vakjes/gb_start.png" alt="Start vakje">
                    </figure>
                </li>
                <li class="gb__player">
                    <figure class="gb__players__figure">
                      <img src="/img/gb_vakjes/gb_start.png" alt="Start vakje">
                    </figure>
                </li>
                <li class="gb__player">
                    <figure class="gb__players__figure">
                        <img src="/img/gb_vakjes/gb_start.png" alt="Start vakje">
                    </figure>

                </li>
            </ul>
            <input id="gb_button" type="submit" name="button" value="Dobbelen"/>

@endsection
