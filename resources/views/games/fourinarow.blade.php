@extends('games.defaultGame')
@section('head-extra')
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<script src="/js/fourinarow.js"></script>
<link rel="stylesheet" type="text/css" href="/css/fourinarow.css">
@endsection

@section('title')
    Vier op een rij
@endsection
@section('gamecontent')
    <section class="fourinarow">
		<section class="fourinarow__buttons">
			<button class="fourinarow__button"><i class="fad fa-arrow-square-down"></i></button>
			<button class="fourinarow__button"><i class="fad fa-arrow-square-down"></i></button>
			<button class="fourinarow__button"><i class="fad fa-arrow-square-down"></i></button>
			<button class="fourinarow__button"><i class="fad fa-arrow-square-down"></i></button>
			<button class="fourinarow__button"><i class="fad fa-arrow-square-down"></i></button>
			<button class="fourinarow__button"><i class="fad fa-arrow-square-down"></i></button>
			<button class="fourinarow__button"><i class="fad fa-arrow-square-down"></i></button>
			<button class="fourinarow__button"><i class="fad fa-arrow-square-down"></i></button>
		</section>
		<section class="fourinarow__pieces">
			
		</section>
	</section>
@endsection