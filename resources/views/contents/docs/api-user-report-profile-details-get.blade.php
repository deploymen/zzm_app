@extends('layouts.docs-page', ['sidebar_item' => 'list-user'])

@section('title', 'GET   /api/profiles/report/profile-details')

@section('desc')
<p>

</p>
@stop

@section('req')
<p>Header</p>
<table class="hover">
    <tr>
        <th style="width:175px;">Key</th>
        <th style="width:500px;">Description</th>
        <th style="width:360px;">Example</th>
    </tr>
    <tr>
        <td>X-access-token</td>
        <td></td>
        <td></td>
    </tr>
</table>
<table class="hover">
    <tr>
        <th style="width:175px;">Key</th>
        <th style="width:500px;">Description</th>
        <th style="width:360px;">Example</th>
    </tr>
    <tr>
        <td>profile_id</td>
        <td></td>
        <td></td> 
    </tr>
</table>
<div style="margin-top:50px; height:500px; overflow:auto; font-size:12px">
    <pre class="prettyprint">
GET http://dev.zapzapmath.com/api/profiles/report/profile-details?profile_id=1 HTTP/1.1
Host: dev.zapzapmath.com
X-access-token: 123
    </pre>
</div>
@stop

@section('resp')
<table class="hover">
    <tr>
        <th style="width:175px;">Key</th>
        <th style="width:500px;">Description</th>
        <th style="width:360px;">Example</th>
    </tr>
    <tr>
        <td>status</td>
        <td></td>
        <td>success, fail, exception</td>
    </tr>
    <tr>
        <td>message</td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>data</td>
        <td></td>
        <td></td>
    </tr>
</table>
<pre class="prettyprint">
{
  "status": "success",
  "data": {
    "first_name": "Profile",
    "last_name": "1",
    "game_code": "0000001x",
    "total_play": "6",
    "total_pass": "6",
    "total_fail": "0",
    "total_completed_planet": "0\/12",
    "last_play": [a
      {
        "system_name": "grade 1",
        "planet_name": "Space Taxi",
        "description": "What + What = What??",
        "score": "108",
        "status": "pass",
        "last_play": "2015-07-13 11:29:54"
      },
      {
        "system_name": "grade 3",
        "planet_name": "Word Games 10",
        "description": "Do you divide or multiply?",
        "score": "1000",
        "status": "pass",
        "last_play": "2015-07-13 11:16:16"
      },
      {
        "system_name": "grade 3",
        "planet_name": "The Big Showdown",
        "description": "Which piece fits?",
        "score": "108",
        "status": "pass",
        "last_play": "2015-07-09 13:52:45"
      },
      {
        "system_name": "grade 1",
        "planet_name": "Space Taxi",
        "description": "What + What = What??",
        "score": "108",
        "status": "pass",
        "last_play": "2015-07-09 13:52:28"
      },
      {
        "system_name": "grade 2",
        "planet_name": "Sushi Star: Sushimetry 3",
        "description": "Know your ingredients!",
        "score": "122",
        "status": "pass",
        "last_play": "2015-07-09 13:52:09"
      }
    ],
    "planet_progress": [
      {
        "name": "The 'Correct' Collector",
        "star": "0"
      },
      {
        "name": "Space Taxi",
        "star": "1"
      },
      {
        "name": "Space Taxi",
        "star": "2"
      },
      {
        "name": "Space Taxi",
        "star": "1"
      },
      {
        "name": "Word Games",
        "star": "0"
      },
      {
        "name": "Tap Tens",
        "star": "0"
      },
      {
        "name": "Tap Tens",
        "star": "0"
      },
      {
        "name": "Space Taxi 2",
        "star": "0"
      },
      {
        "name": "More or Less?",
        "star": "0"
      },
      {
        "name": "Space Taxi 3",
        "star": "0"
      },
      {
        "name": "Space Taxi 3",
        "star": "0"
      },
      {
        "name": "Engine Engine Number Line",
        "star": "0"
      },
      {
        "name": "Engine Engine Number Line",
        "star": "0"
      },
      {
        "name": "The 'Correct' Collector 2",
        "star": "0"
      },
      {
        "name": "Sushi Star: Sushimetry 3",
        "star": "1"
      },
      {
        "name": "Sushi Star: Sushimetry 3",
        "star": "1"
      },
      {
        "name": "Word Games 10",
        "star": "1"
      },
      {
        "name": "Word Games 10",
        "star": "2"
      },
      {
        "name": "The Big Showdown",
        "star": "1"
      },
      {
        "name": "The Big Showdown",
        "star": "1"
      }
    ]
  }
}
</pre>
@stop