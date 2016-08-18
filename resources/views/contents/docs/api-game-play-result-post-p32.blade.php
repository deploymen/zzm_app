@extends('layouts.docs-page', ['sidebar_item' => 'list-game'])

@section('title', 'POST  /api/game/play/225/result')

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
            {"score":"1","status":"pass","badges":{"speed":"1","accuracy":"1"},"answers":[{"question_id":215329,"answer_x":"2","answer_y":"2","correct":1},{"question_id":215354,"answer_x":"2","answer_y":"2","correct":1},{"question_id":215354,"answer_x":"2","answer_y":"2","correct":1},{"question_id":215354,"answer_x":"2","answer_y":"2","correct":1},{"question_id":215354,"answer_x":"2","answer_y":"2","correct":1},{"question_id":215354,"answer_x":"2","answer_y":"2","correct":1},{"question_id":215354,"answer_x":"2","answer_y":"2","correct":1},{"question_id":215354,"answer_x":"2","answer_y":"2","correct":1},{"question_id":215354,"answer_x":"2","answer_y":"2","correct":1},{"question_id":215354,"answer_x":"2","answer_y":"2","correct":1}]}
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
POST http://staging.zapzapmath.com/api/game/play/225/result HTTP/1.1
Host: staging.zapzapmath.com
X-game-code: 00000015k
Content-Type: application/x-www-form-urlencoded

random=ak55a4w78vx4a12cs&game_result=%7B%22score%22%3A%221%22%2C%22status%22%3A%22pass%22%2C%22badges%22%3A%7B%22speed%22%3A%221%22%2C%22accuracy%22%3A%221%22%7D%2C%22answers%22%3A%5B%7B%22question_id%22%3A215329%2C%22answer_x%22%3A%222%22%2C%22answer_y%22%3A%222%22%2C%22correct%22%3A1%7D%2C%7B%22question_id%22%3A215354%2C%22answer_x%22%3A%222%22%2C%22answer_y%22%3A%222%22%2C%22correct%22%3A1%7D%2C%7B%22question_id%22%3A215354%2C%22answer_x%22%3A%222%22%2C%22answer_y%22%3A%222%22%2C%22correct%22%3A1%7D%2C%7B%22question_id%22%3A215354%2C%22answer_x%22%3A%222%22%2C%22answer_y%22%3A%222%22%2C%22correct%22%3A1%7D%2C%7B%22question_id%22%3A215354%2C%22answer_x%22%3A%222%22%2C%22answer_y%22%3A%222%22%2C%22correct%22%3A1%7D%2C%7B%22question_id%22%3A215354%2C%22answer_x%22%3A%222%22%2C%22answer_y%22%3A%222%22%2C%22correct%22%3A1%7D%2C%7B%22question_id%22%3A215354%2C%22answer_x%22%3A%222%22%2C%22answer_y%22%3A%222%22%2C%22correct%22%3A1%7D%2C%7B%22question_id%22%3A215354%2C%22answer_x%22%3A%222%22%2C%22answer_y%22%3A%222%22%2C%22correct%22%3A1%7D%2C%7B%22question_id%22%3A215354%2C%22answer_x%22%3A%222%22%2C%22answer_y%22%3A%222%22%2C%22correct%22%3A1%7D%2C%7B%22question_id%22%3A215354%2C%22answer_x%22%3A%222%22%2C%22answer_y%22%3A%222%22%2C%22correct%22%3A1%7D%5D%7D&hash=e26eb5beea77788a09f20418f69cc7a554289435
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