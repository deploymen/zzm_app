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
@for($i = 0; $i < 27; $i++)
  <tr>
    <td style="width:50%;">{{$status['planet'][$i]['planet_name']}}</td>
    <td style="width:50%;">{{$status['planet'][$i]['status']}}</td> 
  </tr>
@endfor

  
</table>