@extends('layouts.docs-page', ['sidebar_item' => 'list-game'])

@section('title', 'POST  /api/game/play/4/result')

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
<p>INPUT</p>
<table class="hover">
    <tr>
        <th style="width:175px;">Key</th>
        <th style="width:500px;">Description</th>
        <th style="width:360px;">Example</th>
    </tr>
    <tr>
        <td>game_result</td>
        <td></td>
        <td>
            {"score":"70","opponet_play_id":"1","opponet_game_code":"1","set_id":"2","status":"win","answers":[{"question_id":1,"answer":"1","correct":1},{"question_id":3,"answer":"1","correct":1},{"question_id":5,"answer":"2","correct":1},{"question_id":7,"answer":"2","correct":0},{"question_id":9,"answer":"2","correct":0},{"question_id":8,"answer":"2","correct":1},{"question_id":10,"answer":"2","correct":1},{"question_id":6,"answer":"1","correct":1},{"question_id":4,"answer":"2","correct":0},{"question_id":2,"answer":"2","correct":1}]}
        </td>
    </tr>
    <tr>
        <td>random</td>
        <td></td>
        <td>ak55a4w78vx4a12c</td>
    </tr>
    <tr>
        <td>hash</td>
        <td>hash = sha1(game_result + random + secret_key)</td>
        <td>
            <p>= sha1("{something}" + "123" + "d60dK53A40I6HBTBNVoC") </p>
            <p> = sha1("{something}123d60dK53A40I6HBTBNVoC") </p>
            <p> = ce855ac541231884f284e1e0994ef0aa590326a0 </p>
        </td>
    </tr>
</table>
<div style="margin-top:50px; height:500px; overflow:auto; font-size:12px">
    <pre class="prettyprint">POST http://staging.zapzapmath.com/api/game/play/4/result HTTP/1.1
Host: staging.zapzapmath.com
X-game-code: 0000015k

random=ak55a4w78vx4a12c&game_result={"score":70,"opponet_play_id":"1","opponet_game_code":"1","set_id":"2","status":"win","answers":[{"question_id":1,"answer":"1","correct":1},{"question_id":3,"answer":"1","correct":1},{"question_id":5,"answer":"2","correct":1},{"question_id":7,"answer":"2","correct":0},{"question_id":9,"answer":"2","correct":0},{"question_id":8,"answer":"2","correct":1},{"question_id":10,"answer":"2","correct":1},{"question_id":6,"answer":"1","correct":1},{"question_id":4,"answer":"2","correct":0},{"question_id":2,"answer":"2","correct":1}]}&hash=cad5aab9706f15c9bb4b06b52300173558627d63
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
  "status": "success"
}
</pre>
@stop