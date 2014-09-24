@extends('layouts.base')

@section('head')
  @parent
@if ($data['games'])
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
google.load("visualization", "1", {packages:["corechart"]});
google.setOnLoadCallback(drawChart);
function drawChart() {
  var data = google.visualization.arrayToDataTable([
    ['Game', 'Team Points', 'Player Points'],
    @foreach( $data['games'] as $index => $game )
    @if ($index+1 == count($data['games']))
    [{{{$game['game']}}}, {{{$game['teamPoints']}}}, {{{$game['playerPoints']}}}]
    @else
    [{{{$game['game']}}}, {{{$game['teamPoints']}}}, {{{$game['playerPoints']}}}],
    @endif
    @endforeach
    ]);

  var options = {
    hAxis: {title: 'Game', minValue:0, maxValue:{{{count($data['games']) + 1}}}, gridlines:{count:{{{count($data['games']) + 2}}}}, format:'0'},
      vAxis: {title: 'Points', minValue:0, format: '0'},
      chartArea:{ left: 40, top: 20, width: "70%", height:"80%"}
  };

  var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

  chart.draw(data, options);
  @endif
}
</script>
@stop

@section('body')
<h1>{{$data['name']}}</h1>
@if ($data['games'])
  <table>
    <tr class="tableHeader">
      <th></th>
      <th>Opponent</th>
      <th>Player Score</th>
      <th>Team Score</th>
      <th>W/L</th>
    </tr>
    @foreach( $data['games'] as $game )
    <tr>
      <td class="tableHeader">Game {{ $game['game'] }}</td>
      <td>{{ $game['opponent'] }}</td>
      <td class="score">{{ $game['playerPoints'] }}</td>
      <td class="score">{{ $game['teamPoints'] }}</td>
      @if ($game['gameWon'])
      <td class="gameResult">W</td>
      @else
      <td class="gameResult">L</td>
      @endif
    </tr>
    @endforeach
  </table>
    <div id="chart_div" style="width: 600px; height: 300px;"></div>
@else
  <p>No game data found</p>
@endif
@stop
