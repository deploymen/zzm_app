@extends('layouts.docs-page', ['sidebar_item' => 'list-game'])

@section('title', 'POST  /api/game/play/166/result')

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
        <td>MIN = 10 , MAX = 20</td>
        <td>
            {"score":108,"status":"pass","badges":{"speed":1,"accuracy":0},"answers":[{"question_id":256,"answer":"T","correct":1},{"question_id":257,"answer":"F","correct":0},{"question_id":258,"answer":"+","correct":1},{"question_id":259,"answer":"-","correct":0},{"question_id":260,"answer":"F","correct":0},{"question_id":261,"answer":"F","correct":0},{"question_id":262,"answer":"F","correct":0},{"question_id":263,"answer":"F","correct":0},{"question_id":264,"answer":"F","correct":0},{"question_id":265,"answer":"F","correct":0}]}
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
    <pre class="prettyprint">
POST http://staging.zapzapmath.com/api/game/play/166/result HTTP/1.1
Host: staging.zapzapmath.com
X-game-code: 000015k

random=ak55a4w78vx4a12c&game_result={"score":108,"status":"pass","badges":{"speed":1, "accuracy":0},"answers":[{"question_id":256,"answer":"T","correct":1},{"question_id":257,"answer":"F","correct":0},{"question_id":258,"answer":"+","correct":1},{"question_id":259,"answer":"-","correct":0},{"question_id":260,"answer":"F","correct":0},{"question_id":261,"answer":"F","correct":0},{"question_id":262,"answer":"F","correct":0},{"question_id":263,"answer":"F","correct":0},{"question_id":264,"answer":"F","correct":0},{"question_id":265,"answer":"F","correct":0}]}&hash=a0a5689e4a6c5057580ef8a8a797348d4003e16c
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