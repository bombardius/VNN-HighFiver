@extends('layouts.base')

@section('body')
<h1>Top 5 Players</h1>
@if ($players)
  <ul>
    @foreach( $players as $player )
      <li><a href="{{$player['link']}}">{{$player['name']}}</a></li>
    @endforeach
  </ul>
@else
  <p>No player data found</p>
@endif
@stop
