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
        <h3>POST  /api/game/play/228/result</h3>
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
                          {"score":"1","status":"pass","level":"10","experience":"8000","badges":{"speed":"1","accuracy":"1"},"answers":[{"question_id":275018,"answer":"2","answer_option":"2","correct":1,"complite_time":"1.2"},{"question_id":275018,"answer":"2","answer_option":"2","correct":1,"complite_time":"1.2"},{"question_id":275018,"answer":"1","answer_option":"2","correct":1,"complite_time":"1.2"},{"question_id":275018,"answer":"2","answer_option":"2","correct":0,"complite_time":"1.2"},{"question_id":275018,"answer":"3","answer_option":"2","correct":0,"complite_time":"1.2"},{"question_id":275018,"answer":"2","answer_option":"2","correct":1,"complite_time":"1.2"},{"question_id":275018,"answer":"4","answer_option":"2","correct":0,"complite_time":"1.2"},{"question_id":275018,"answer":"3","answer_option":"2","correct":0,"complite_time":"1.2"},{"question_id":275018,"answer":"2","answer_option":"2","correct":1,"complite_time":"1.2"},{"question_id":275018,"answer":"1","answer_option":"2","correct":0,"complite_time":"1.2"}]}
                        </td>
                    </tr>
                    <tr>
                        <td>random</td>
                        <td></td>
                        <td>ak55a4w78vx4a12</td>
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
POST http://staging.zapzapmath.com/api/game/play/228/result HTTP/1.1
Host: staging.zapzapmath.com
X-game-code: 0000015k

random=ak55a4w78vx4a12c11122asd1&game_result=%7B%22score%22%3A%221%22%2C%22status%22%3A%22pass%22%2C%22level%22%3A%2210%22%2C%22experience%22%3A%228000%22%2C%22badges%22%3A%7B%22speed%22%3A%221%22%2C%22accuracy%22%3A%221%22%7D%2C%22answers%22%3A%5B%7B%22question_id%22%3A275018%2C%22answer%22%3A%222%22%2C%22answer_option%22%3A%222%22%2C%22correct%22%3A1%2C%22complete_time%22%3A%221.2%22%7D%2C%7B%22question_id%22%3A275018%2C%22answer%22%3A%222%22%2C%22answer_option%22%3A%222%22%2C%22correct%22%3A1%2C%22complete_time%22%3A%221.2%22%7D%2C%7B%22question_id%22%3A275018%2C%22answer%22%3A%221%22%2C%22answer_option%22%3A%222%22%2C%22correct%22%3A1%2C%22complete_time%22%3A%221.2%22%7D%2C%7B%22question_id%22%3A275018%2C%22answer%22%3A%222%22%2C%22answer_option%22%3A%222%22%2C%22correct%22%3A0%2C%22complete_time%22%3A%221.2%22%7D%2C%7B%22question_id%22%3A275018%2C%22answer%22%3A%223%22%2C%22answer_option%22%3A%222%22%2C%22correct%22%3A0%2C%22complete_time%22%3A%221.2%22%7D%2C%7B%22question_id%22%3A275018%2C%22answer%22%3A%222%22%2C%22answer_option%22%3A%222%22%2C%22correct%22%3A1%2C%22complete_time%22%3A%221.2%22%7D%2C%7B%22question_id%22%3A275018%2C%22answer%22%3A%224%22%2C%22answer_option%22%3A%222%22%2C%22correct%22%3A0%2C%22complete_time%22%3A%221.2%22%7D%2C%7B%22question_id%22%3A275018%2C%22answer%22%3A%223%22%2C%22answer_option%22%3A%222%22%2C%22correct%22%3A0%2C%22complete_time%22%3A%221.2%22%7D%2C%7B%22question_id%22%3A275018%2C%22answer%22%3A%222%22%2C%22answer_option%22%3A%222%22%2C%22correct%22%3A1%2C%22complete_time%22%3A%221.2%22%7D%2C%7B%22question_id%22%3A275018%2C%22answer%22%3A%221%22%2C%22answer_option%22%3A%222%22%2C%22correct%22%3A0%2C%22complete_time%22%3A%221.2%22%7D%5D%7D&hash=4da1701adf70a8ba1e8021b9b3f163a23c3c4206
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