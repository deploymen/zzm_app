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
table#t01 tr:nth-child(even) {
    background-color: #eee;
}
table#t01 tr:nth-child(odd) {
   background-color:#fff;
}
table#t01 th	{
    background-color: black;
    color: white;
}
</style>



<table id="t01">
<caption style="font-weight:bold; font-size:20px;">Last Game Play</caption>
  <tr>
    <td style="width:250px;">status</td>
    <td>{{$status['last_update'][0]['status']}}</td> 
  </tr>
  <tr>
    <td>last_update</td>
    <td>{{$status['last_update'][0]['last_update']}}</td> 
  </tr>
</table>
<br>
<br>
<br>

<table id="t01">
<caption style="font-weight:bold; font-size:20px;">System Planet Enable</caption>
 <tr>
    <td style="width:250px;">system_planet_enable</td>
    <td>{{$status['system_planet'][0]['system_planet_enable']}}</td> 
  </tr>
</table>
<br>
<br>
<br>

<table id="t01">
<caption style="font-weight:bold; font-size:20px;">Qustion Enable</caption>
<tr>
    <td style="width:250px;">p01</td>
    <td>{{$status['number_of_quesitons'][0]['p01']}}</td> 
  </tr>
  <tr>
    <td>p02</td>
    <td>{{$status['number_of_quesitons'][0]['p02']}}</td> 
  </tr>
  <tr>
    <td>p03</td>
    <td>{{$status['number_of_quesitons'][0]['p03']}}</td> 
  </tr>
  <tr>
    <td>p06</td>
    <td>{{$status['number_of_quesitons'][0]['p06']}}</td> 
  </tr>
  <tr>
    <td>p07</td>
    <td>{{$status['number_of_quesitons'][0]['p07']}}</td> 
  </tr>
</table>
<br>
<br>
<br>

<table id="t01">
<caption style="font-weight:bold; font-size:20px;">User Number</caption>
  <tr>
    <td style="width:33%">role</td>
    <td style="width:33%">total</td>
    <td style="width:33%">last_update</td>
  </tr>
    <tr>
    <td>{{$status['user'][0]['role']}}</td>
    <td>{{$status['user'][0]['total']}}</td>
    <td>{{$status['user'][0]['last_update']}}</td>
  </tr>
      <tr>
    <td>{{$status['user'][1]['role']}}</td>
    <td>{{$status['user'][1]['total']}}</td>
    <td>{{$status['user'][1]['last_update']}}</td>
  </tr>
</table>

<br>
<br>
<br>

<table id="t01">
<caption style="font-weight:bold; font-size:20px;">Log General</caption>
  <tr>
    <td style="width:25px">id</td>
    <td>level_name</td>
    <td style="width:75px">message</td>
    <td>environment</td>
    <td>created_at</td>
    <td>created_ip</td>
</tr>
<tr>
    <td>{{$status['log_general'][0]['id']}}</td>
    <td>{{$status['log_general'][0]['level_name']}}</td>
    <td>{{$status['log_general'][0]['message']}}</td>
    <td>{{$status['log_general'][0]['environment']}}</td>
    <td>{{$status['log_general'][0]['created_at']}}</td>
    <td>{{$status['log_general'][0]['created_ip']}}</td>
</tr>
  <tr>
    <td>{{$status['log_general'][1]['id']}}</td>
    <td>{{$status['log_general'][1]['level_name']}}</td>
    <td>{{$status['log_general'][1]['message']}}</td>
    <td>{{$status['log_general'][1]['environment']}}</td>
    <td>{{$status['log_general'][1]['created_at']}}</td>
    <td>{{$status['log_general'][1]['created_ip']}}</td>
  </tr>

  <tr>
    <td>{{$status['log_general'][2]['id']}}</td>
    <td>{{$status['log_general'][2]['level_name']}}</td>
    <td>{{$status['log_general'][2]['message']}}</td>
    <td>{{$status['log_general'][2]['environment']}}</td>
    <td>{{$status['log_general'][2]['created_at']}}</td>
    <td>{{$status['log_general'][2]['created_ip']}}</td>
  </tr>

  <tr>
    <td>{{$status['log_general'][3]['id']}}</td>
    <td>{{$status['log_general'][3]['level_name']}}</td>
    <td>{{$status['log_general'][3]['message']}}</td>
    <td>{{$status['log_general'][3]['environment']}}</td>
    <td>{{$status['log_general'][3]['created_at']}}</td>
    <td>{{$status['log_general'][3]['created_ip']}}</td>
  </tr>

  <tr>
    <td>{{$status['log_general'][4]['id']}}</td>
    <td>{{$status['log_general'][4]['level_name']}}</td>
  	<td>{{$status['log_general'][4]['message']}}</td>
    <td>{{$status['log_general'][4]['environment']}}</td>
     <td>{{$status['log_general'][4]['created_at']}}</td>
     <td>{{$status['log_general'][4]['created_ip']}}</td>
  </tr>

  <tr>
    <td>{{$status['log_general'][5]['id']}}</td>
    <td>{{$status['log_general'][5]['level_name']}}</td>
    <td>{{$status['log_general'][5]['message']}}</td>
    <td>{{$status['log_general'][5]['environment']}}</td>
    <td>{{$status['log_general'][5]['created_at']}}</td>
    <td>{{$status['log_general'][5]['created_ip']}}</td>
  </tr>

    <tr>
    <td>{{$status['log_general'][6]['id']}}</td>
    <td>{{$status['log_general'][6]['level_name']}}</td>
    <td>{{$status['log_general'][6]['message']}}</td>
    <td>{{$status['log_general'][6]['environment']}}</td>
    <td>{{$status['log_general'][6]['created_at']}}</td>
    <td>{{$status['log_general'][6]['created_ip']}}</td>
  </tr>
    <tr>
    <td>{{$status['log_general'][7]['id']}}</td>
    <td>{{$status['log_general'][7]['level_name']}}</td>
    <td>{{$status['log_general'][7]['message']}}</td>
    <td>{{$status['log_general'][7]['environment']}}</td>
    <td>{{$status['log_general'][7]['created_at']}}</td>
    <td>{{$status['log_general'][7]['created_ip']}}</td>
  </tr>
    <tr>
    <td>{{$status['log_general'][8]['id']}}</td>
    <td>{{$status['log_general'][8]['level_name']}}</td>
    <td>{{$status['log_general'][8]['message']}}</td>
    <td>{{$status['log_general'][8]['environment']}}</td>
    <td>{{$status['log_general'][8]['created_at']}}</td>
    <td>{{$status['log_general'][8]['created_ip']}}</td>
  </tr>
    <tr>
    <td>{{$status['log_general'][9]['id']}}</td>
    <td>{{$status['log_general'][9]['level_name']}}</td>
    <td>{{$status['log_general'][9]['message']}}</td>
    <td>{{$status['log_general'][9]['environment']}}</td>
    <td>{{$status['log_general'][9]['created_at']}}</td>
    <td>{{$status['log_general'][9]['created_ip']}}</td>
  </tr>
</table>