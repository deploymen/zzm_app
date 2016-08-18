@extends('layouts.docs-page', ['sidebar_item' => 'list-game'])

@section('title', 'POST  /api/game/play/105/result')

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
            {"score":1,"status":pass,"badges":{"speed":1,"accuracy":0},"answers":[{"question_id":210011,"answer":"2","correct":1},{"question_id":210012,"answer":"4","correct":0},{"question_id":210013,"answer":"5","correct":1},{"question_id":210014,"answer":"5","correct":0},{"question_id":210015,"answer":"9","correct":0},{"question_id":210016,"answer":"2","correct":1},{"question_id":210017,"answer":"7","correct":0},{"question_id":210018,"answer":"10","correct":0},{"question_id":210019,"answer":"6","correct":1},{"question_id":210020,"answer":"7","correct":0}]}
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
    <pre class="prettyprint">
POST http://staging.zapzapmath.com/api/game/play/105/result HTTP/1.1
Host: staging.zapzapmath.com
X-game-code: 0000001x

random=ak55a4w78vx4a12c&game_result={"score":1,"status":"pass","badges":{"speed":1,"accuracy":0},"answers":[{"question_id":210011,"answer":"2","correct":1},{"question_id":210012,"answer":"4","correct":0},{"question_id":210013,"answer":"5","correct":1},{"question_id":210014,"answer":"5","correct":0},{"question_id":210015,"answer":"9","correct":0},{"question_id":210016,"answer":"2","correct":1},{"question_id":210017,"answer":"7","correct":0},{"question_id":210018,"answer":"10","correct":0},{"question_id":210019,"answer":"6","correct":1},{"question_id":210020,"answer":"7","correct":0}]}&hash=256a7fce34f1f002b6f6cb1611034ba5e8b8ea3d
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