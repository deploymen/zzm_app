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
        <h3>POST  /api/1.0/game/play/push-result</h3>
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
                       [{"planet_id":225,"game_result":{"score":"1","status":"pass","badges":{"speed":"1","accuracy":"1"},"answers":[{"question_id":215329,"answer_x":"2","answer_y":"2","correct":1},{"question_id":215354,"answer_x":"2","answer_y":"2","correct":1},{"question_id":215354,"answer_x":"2","answer_y":"2","correct":1},{"question_id":215354,"answer_x":"2","answer_y":"2","correct":1},{"question_id":215354,"answer_x":"2","answer_y":"2","correct":1},{"question_id":215354,"answer_x":"2","answer_y":"2","correct":1},{"question_id":215354,"answer_x":"2","answer_y":"2","correct":1},{"question_id":215354,"answer_x":"2","answer_y":"2","correct":1},{"question_id":215354,"answer_x":"2","answer_y":"2","correct":1},{"question_id":215354,"answer_x":"2","answer_y":"2","correct":1}]},"random":"ak55a4w78vx4a12c1","hash":"18dcafbd6566e7b2bed90dc08f33e75afce77a50"},{"planet_id":155,"game_result":{"score":"1","status":"pass","badges":{"speed":"1","accuracy":"1"},"answers":[{"question_id":5090,"answer":"<","correct":1},{"question_id":5143,"answer":"<","correct":1},{"question_id":5089,"answer":"<","correct":1},{"question_id":5227,"answer":">","correct":0},{"question_id":5377,"answer":">","correct":0},{"question_id":5406,"answer":">","correct":1},{"question_id":5403,"answer":"=","correct":0},{"question_id":5378,"answer":"=","correct":0},{"question_id":5091,"answer":"=","correct":1},{"question_id":5089,"answer":"999","correct":0}]},"random":"ak55a4w78vx4a12c","hash":"4bbbf2bec9814923da1e72d890e9165e7c18f2f5"}]
                        </td>
                    </tr>
                </table>
                <div style="margin-top:50px; height:500px; overflow:auto; font-size:12px">
<pre class="prettyprint">

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