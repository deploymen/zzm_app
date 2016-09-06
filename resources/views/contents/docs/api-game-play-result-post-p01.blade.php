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
        <h3>POST  /api/game/play/150/result</h3>
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
                        {"score":122,"status":"pass","badges":{"speed":1,"accuracy":0},"answers":[{"question_id":2270,"answer":{"angle3":1,"angle4":3,"angle5":0,"angle6":0},"correct":1},{"question_id":2271,"answer":{"angle3":0,"angle4":2,"angle5":0,"angle6":1},"correct":1},{"question_id":2272,"answer":{"angle3":1,"angle4":3,"angle5":0,"angle6":6},"correct":1},{"question_id":2273,"answer":{"angle3":3,"angle4":2,"angle5":0,"angle6":1},"correct":1},{"question_id":2274,"answer":{"angle3":0,"angle4":0,"angle5":2,"angle6":2},"correct":1},{"question_id":2275,"answer":{"angle3":5,"angle4":0,"angle5":0,"angle6":0},"correct":1},{"question_id":2276,"answer":{"angle3":0,"angle4":1,"angle5":0,"angle6":3},"correct":1},{"question_id":2277,"answer":{"angle3":2,"angle4":1,"angle5":0,"angle6":0},"correct":1},{"question_id":2278,"answer":{"angle3":1,"angle4":0,"angle5":0,"angle6":2},"correct":1},{"question_id":2279,"answer":{"angle3":1,"angle4":2,"angle5":0,"angle6":0},"correct":1}]}
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
POST http://staging.zapzapmath.com/api/game/play/150/result HTTP/1.1
Host: staging.zapzapmath.com
X-game-code: 0000015k

random=ak55a4w78vx4a12aa&game_result={"score":122,"status":"pass","badges":{"speed":1,"accuracy":0},"answers":[{"question_id":2270,"answer":{"angle3":1,"angle4":3,"angle5":0,"angle6":0},"correct":1},{"question_id":2271,"answer":{"angle3":0,"angle4":2,"angle5":0,"angle6":1},"correct":1},{"question_id":2272,"answer":{"angle3":1,"angle4":3,"angle5":0,"angle6":6},"correct":1},{"question_id":2273,"answer":{"angle3":3,"angle4":2,"angle5":0,"angle6":1},"correct":1},{"question_id":2274,"answer":{"angle3":0,"angle4":0,"angle5":2,"angle6":2},"correct":1},{"question_id":2275,"answer":{"angle3":5,"angle4":0,"angle5":0,"angle6":0},"correct":1},{"question_id":2276,"answer":{"angle3":0,"angle4":1,"angle5":0,"angle6":3},"correct":1},{"question_id":2277,"answer":{"angle3":2,"angle4":1,"angle5":0,"angle6":0},"correct":1},{"question_id":2278,"answer":{"angle3":1,"angle4":0,"angle5":0,"angle6":2},"correct":1},{"question_id":2279,"answer":{"angle3":1,"angle4":2,"angle5":0,"angle6":0},"correct":1}]}&hash=df04f731e8c76d8373367695767f0ce1bfecea1c
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