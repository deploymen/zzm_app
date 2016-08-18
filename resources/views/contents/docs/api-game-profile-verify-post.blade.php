@extends('layouts.docs-page', ['sidebar_item' => 'list-game'])

@section('title', 'POST   /api/game/verify-code')

@section('desc')
<p>
    This api is for game landing screen. It trigger when user key in game code to proceed. Api will return profile_transfer=1 if there's anonymous game history, expect game client will prompt user to do profile transfer(PT) or not.
</p>
@stop

@section('req')
<p>INPUT</p>
<table class="hover">
    <tr>
        <th style="width:175px;">Key</th>
        <th style="width:500px;">Description</th>
        <th style="width:360px;">Example</th>
    </tr>
    <tr>
        <td>game_code</td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>game_code_anonymous</td>
        <td></td>
        <td></td>
    </tr>
</table>
<div style="margin-top:50px; height:500px; overflow:auto; font-size:12px">
    <pre class="prettyprint">POST http://staging.zapzapmath.com/api/game/verify-code HTTP/1.1
Host: staging.zapzapmath.com

game_code=1&game_code_anonymous=5
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
    "profile_transfer": "0",
    "profile": {
      "id": 1,
      "user_id": 1,
      "class_id": 0,
      "first_name": "Profile",
      "last_name": "1",
      "school": "",
      "city": "",
      "email": null,
      "nickname1": 1,
      "nickname2": 1,
      "avatar_id": 1,
      "created_at": "2015-06-02 13:05:26",
      "updated_at": "2015-06-02 13:05:26",
      "deleted_at": null
    }
  }
}
</pre>
@stop