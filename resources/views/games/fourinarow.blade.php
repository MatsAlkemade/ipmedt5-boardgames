@extends('games.defaultGame')
@section('head-extra')
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<script type="text/javascript">
	let __u__ = "{{ auth()->user()->email }}";
	let __p__ = "{{ auth()->user()->password }}";
	let user_id = {{ auth()->user()->id }};
</script>
<script src="/js/fourinarow.js"></script>
<link rel="stylesheet" type="text/css" href="/css/fourinarow.css">
@endsection

@section('title')
    Vier op een rij
@endsection
@section('gamecontent')
    <section class="fourinarow">
    	<h2 class="fourinarow__header"><span class="js--fiar-turn js--fiar-other">(Other players turn)</span></h2>
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