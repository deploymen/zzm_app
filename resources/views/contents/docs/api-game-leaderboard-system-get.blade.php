@extends('layouts.docs-page', ['sidebar_item' => 'list-game'])

@section('title', 'GET  /api/game/leaderboard/world/{system_id}')

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
GET http://www.zapzapmath.com/api/game/leaderboard/system/101 HTTP/1.1
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
  "data": [
    {
      "id": "1",
      "rank": "1",
      "system_id": "101",
      "profile_id": "1",
      "first_name": "lai",
      "last_name": "weizhong",
      "score": "108",
      "created_at": "2015-06-12 04:24:26",
      "updated_at": null,
      "deleted_at": null
    },
    {
      "id": "6",
      "rank": "1",
      "system_id": "101",
      "profile_id": "1",
      "first_name": "lai",
      "last_name": "weizhong",
      "score": "108",
      "created_at": "2015-06-12 04:28:32",
      "updated_at": null,
      "deleted_at": null
    },
    {
      "id": "7",
      "rank": "1",
      "system_id": "101",
      "profile_id": "1",
      "first_name": "lai",
      "last_name": "weizhong",
      "score": "108",
      "created_at": "2015-06-12 04:30:17",
      "updated_at": null,
      "deleted_at": null
    }
  ]
}
</pre>
@stop