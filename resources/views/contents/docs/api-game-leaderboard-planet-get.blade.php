@extends('layouts.docs-page', ['sidebar_item' => 'list-game'])

@section('title', 'GET  /api/game/leaderboard/planet/{planet_id}')

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
        <td>X-game-code</td>
        <td></td>
        <td></td>
    </tr>
</table>
<div style="margin-top:50px; height:500px; overflow:auto; font-size:12px">
    <pre class="prettyprint">
GET http://www.zapzapmath.com/api/game/leaderboard/planet/103 HTTP/1.1
Host: www.zapzapmath.com
X-game-code: 0000015k
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
    "Leaderboard_planet": [
      {
        "id": 1,
        "rank": 1,
        "planet_id": 185,
        "profile_id": 1,
        "nickname1": "Mozviss",
        "nickname2": "Oznin",
        "avatar": "default.jpg",
        "score": 1,
        "created_at": "2015-07-29 11:59:18",
        "updated_at": null,
        "deleted_at": null
      },
      {
        "id": 2,
        "rank": 1,
        "planet_id": 185,
        "profile_id": 1,
        "nickname1": "Mozviss",
        "nickname2": "Oznin",
        "avatar": "default.jpg",
        "score": 1,
        "created_at": "2015-07-29 12:00:05",
        "updated_at": null,
        "deleted_at": null
      },
      {
        "id": 3,
        "rank": 1,
        "planet_id": 185,
        "profile_id": 1,
        "nickname1": "Mozviss",
        "nickname2": "Oznin",
        "avatar": "default.jpg",
        "score": 1,
        "created_at": "2015-07-30 13:53:12",
        "updated_at": null,
        "deleted_at": null
      }
    ]
  }
}
</pre>
@stop