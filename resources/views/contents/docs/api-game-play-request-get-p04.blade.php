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
        <h3>GET  /api/game/play/4/request</h3>
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
                <table class="table table-striped table-bordered table-hover">
                    <tr>
                        <th style="width:175px;">Key</th>
                        <th style="width:500px;">Description</th>
                        <th style="width:360px;">Example</th>
                    </tr>
                    <tr>
                        <td>difficulty</td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
                <div style="margin-top:50px; height:500px; overflow:auto; font-size:12px">
<pre class="prettyprint">GET http://staging.zapzapmath.com/api/game/play/4/request HTTP/1.1
Host: staging.zapzapmath.com
X-game-code: 0000014n
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
  "status": "success",
  "data": {
    "questions": {
      "set": {
        "challenge_set": 29,
        "game_play": 9
      },
      "result": {
        "score": 80,
        "status": "win",
        "set_id": 29,
        "opponent_play_id": 0,
        "opponent_game_code": "system"
      },
      "result_answer": [
        {
          "question_id": 9221,
          "answer": 1,
          "correct": 0
        },
        {
          "question_id": 9218,
          "answer": 1,
          "correct": 1
        },
        {
          "question_id": 9219,
          "answer": 2,
          "correct": 1
        },
        {
          "question_id": 9217,
          "answer": 4,
          "correct": 0
        },
        {
          "question_id": 9223,
          "answer": 1,
          "correct": 1
        },
        {
          "question_id": 9216,
          "answer": 2,
          "correct": 1
        },
        {
          "question_id": 9215,
          "answer": 1,
          "correct": 1
        },
        {
          "question_id": 9220,
          "answer": 1,
          "correct": 1
        },
        {
          "question_id": 9222,
          "answer": 2,
          "correct": 1
        },
        {
          "question_id": 9225,
          "answer": 2,
          "correct": 1
        }
      ],
      "questions": [
        {
          "id": 7,
          "answer": "3",
          "question_string": "6-1=?",
          "grade": "1",
          "difficulty": "1",
          "answer_option_1": "3",
          "answer_option_2": "4",
          "answer_option_3": "5",
          "answer_option_4": "6"
        },
        {
          "id": 4,
          "answer": "1",
          "question_string": "4-2=?",
          "grade": "1",
          "difficulty": "1",
          "answer_option_1": "2",
          "answer_option_2": "4",
          "answer_option_3": "6",
          "answer_option_4": "8"
        },
        {
          "id": 5,
          "answer": "2",
          "question_string": "5-1=?",
          "grade": "1",
          "difficulty": "1",
          "answer_option_1": "3",
          "answer_option_2": "4",
          "answer_option_3": "5",
          "answer_option_4": "6"
        },
        {
          "id": 3,
          "answer": "2",
          "question_string": "4-1=?",
          "grade": "1",
          "difficulty": "1",
          "answer_option_1": "2",
          "answer_option_2": "3",
          "answer_option_3": "4",
          "answer_option_4": "5"
        },
        {
          "id": 9,
          "answer": "1",
          "question_string": "6-3=?",
          "grade": "1",
          "difficulty": "1",
          "answer_option_1": "3",
          "answer_option_2": "4",
          "answer_option_3": "5",
          "answer_option_4": "6"
        },
        {
          "id": 2,
          "answer": "2",
          "question_string": "3-1=?",
          "grade": "1",
          "difficulty": "1",
          "answer_option_1": "1",
          "answer_option_2": "2",
          "answer_option_3": "3",
          "answer_option_4": "4"
        },
        {
          "id": 1,
          "answer": "1",
          "question_string": "2-1=?",
          "grade": "1",
          "difficulty": "1",
          "answer_option_1": "1",
          "answer_option_2": "2",
          "answer_option_3": "3",
          "answer_option_4": "4"
        },
        {
          "id": 6,
          "answer": "1",
          "question_string": "5-2=?",
          "grade": "1",
          "difficulty": "1",
          "answer_option_1": "3",
          "answer_option_2": "4",
          "answer_option_3": "5",
          "answer_option_4": "6"
        },
        {
          "id": 8,
          "answer": "2",
          "question_string": "6-2=?",
          "grade": "1",
          "difficulty": "1",
          "answer_option_1": "3",
          "answer_option_2": "4",
          "answer_option_3": "5",
          "answer_option_4": "6"
        },
        {
          "id": 11,
          "answer": "2",
          "question_string": "11-1=?",
          "grade": "1",
          "difficulty": "1",
          "answer_option_1": "5",
          "answer_option_2": "6",
          "answer_option_3": "7",
          "answer_option_4": "8"
        }
      ]
    }
  }
}
</pre>
            </div>

        </div>
    </div>
    <!--END ROW -->
</div>

@stop