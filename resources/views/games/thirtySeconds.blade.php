@extends('games.defaultGame')
@section('title')
    30 Seconds
@endsection
@section('gamecontent')
    <article class="thirtySeconds">
        <h1>Content</h1>
    </article>
@endsection

@section('livechat')

@endsection

@section('rules')
    <p>{{$ts->description}}</p>
@endsection

@section('position')

@endsection