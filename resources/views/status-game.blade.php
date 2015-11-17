<style>

table {
    width:100%;
}
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
th, td {
    padding: 5px;
    text-align: left;
}
</style>

<table style="width:920px;">
<caption>Planet And System</caption>
  <tr>
    <td style="width:50%;">Total System</td>
    <td style="width:50%;">{{$status['system_count']}}</td> 
  </tr>
  <tr>
    <td>Total Planet</td>
    <td>{{$status['planet_count']}}</td> 
  </tr>
</table>
<br>
<table style="width:920px;">
<caption>Game GET Question</caption>

@for($i = 0; $i < $status['planet_count'] ; $i++)
  <tr>
    <td style="width:48%;">{{$status['planet'][$i]['planet_name']}}</td>
    <td style="width:48%;">{{$status['planet'][$i]['game_type']}}</td>
    @if ($status['planet'][$i]['status'] === 1)
       <td style="width:100%;background-color: #10FF00;"></td> 
    @else
       <td style="width:100%;background-color: #FF0A0A;"></td> 
    @endif

  </tr>
@endfor

  
</table>