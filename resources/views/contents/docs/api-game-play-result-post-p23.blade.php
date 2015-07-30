@extends('layouts.master-docs', ['sidebar_item' => 'list-game'])

@section('breadcrumb')
<!--BEGIN TITLE & BREADCRUMB PAGE-->
<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left">
        <div class="page-title">GAME API</div>
    </div>
    <div class="clearfix"></div>
</div>
<!--END TITLE & BREADCRUMB PAGE-->
@stop

@section('css_include')

@stop

@section('js_include')

@stop

@section('content')

<div class="row">
    <div class="col-lg-8">
        <h3>POST  /api/game/play/185/result</h3>
        <ul id="myTab" class="nav nav-tabs">
            <li class="active"><a href="#descriptions" data-toggle="tab">Explain</a>
            </li>
            <li><a href="#request" data-toggle="tab">Request</a>
            </li>
            <li><a href="#respone" data-toggle="tab">Response</a>
            </li>
        </ul>
        <div id="myTabContent" class="tab-content">
            <div id="descriptions" class="tab-pane fade in active">
                <p>

                </p>
            </div>
            <div id="request" class="tab-pane fade">
                <p>Header</p>
                <table class="table table-striped table-bordered table-hover">
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
                <table class="table table-striped table-bordered table-hover">
                    <tr>
                        <th style="width:175px;">Key</th>
                        <th style="width:500px;">Description</th>
                        <th style="width:360px;">Example</th>
                    </tr>
                    <tr>
                        <td>game_result</td>
                        <td></td>
                        <td>
                        {"score":"1","status":"pass","badges":{"speed":"5","accuracy":"0.8","score_mul_base":"1","score_mul_accuracy":"1","score_mul_speed":"1"},"answers":[{"question_id":213104,"answer":"9","correct":1},{"question_id":213106,"answer":"2","correct":0},{"question_id":213108,"answer":"5","correct":1},{"question_id":213111,"answer":"5","correct":0},{"question_id":213112,"answer":"2","correct":0},{"question_id":213105,"answer":"5","correct":1},{"question_id":213107,"answer":"5","correct":0},{"question_id":213109,"answer":"2","correct":0},{"question_id":213110,"answer":"5","correct":1},{"question_id":213115,"answer":"5","correct":0}]}
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
POST http://staging.zapzapmath.com/api/game/play/185/result HTTP/1.1
Host: staging.zapzapmath.com
X-game-code: 00000015k
Content-Type: application/x-www-form-urlencoded

random=ak55a4w78vx4a12c&game_result={"score":"1","status":"pass","badges":{"speed":"5","accuracy":"0.8","score_mul_base":"1","score_mul_accuracy":"1","score_mul_speed":"1"},"answers":[{"question_id":213104,"answer":"9","correct":1},{"question_id":213106,"answer":"2","correct":0},{"question_id":213108,"answer":"5","correct":1},{"question_id":213111,"answer":"5","correct":0},{"question_id":213112,"answer":"2","correct":0},{"question_id":213105,"answer":"5","correct":1},{"question_id":213107,"answer":"5","correct":0},{"question_id":213109,"answer":"2","correct":0},{"question_id":213110,"answer":"5","correct":1},{"question_id":213115,"answer":"5","correct":0}]}&hash=59a59c7af895929256c7bccb0665f33ac71b5ccc
</pre>
                </div>
            </div>
            <div id="respone" class="tab-pane fade">
                <table class="table table-striped table-bordered table-hover">
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
            </div>

        </div>
    </div>
    <!--END ROW -->
</div>


@stop