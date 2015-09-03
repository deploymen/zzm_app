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
        <h3>GET  /api/game/play/228/request?game_type=?</h3>
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
                        <td>game_type</td>
                        <td></td>
                        <td>2,4,6,8</td>
                    </tr>
                </table>
                <div style="margin-top:50px; height:500px; overflow:auto; font-size:12px">
<pre class="prettyprint">GET http://staging.zapzapmath.com/api/game/play/228/request?game_type=2 HTTP/1.1
Host: staging.zapzapmath.com
X-game-code: 0000015k
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
    "planet": {
      "id": 228,
      "name": "Multiplayer",
      "description": "Multiplayer",
      "question_count": 50,
      "badges": {
        "speed": "1",
        "accuracy": "1",
        "score_mul_base": "1",
        "score_mul_accuracy": "1",
        "score_mul_speed": "1"
      }
    },
    "status": {
      "star": 0,
      "difficulty": 1,
      "top_score": 0
    },
    "planet_top_score": [
      
    ],
    "questions": {
      "player": [
        {
          "id": 275437,
          "question": "20 - 10",
          "question_option1": 9,
          "question_option2": 10,
          "question_option3": 11,
          "question_option4": 12,
          "difficulty": 3,
          "subject": [
            {
              "subject_code": "0",
              "name": null,
              "description": null
            }
          ]
        },
        {
          "id": 275016,
          "question": "2 + 7",
          "question_option1": 7,
          "question_option2": 8,
          "question_option3": 9,
          "question_option4": 10,
          "difficulty": 1,
          "subject": [
            {
              "subject_code": "0",
              "name": null,
              "description": null
            }
          ]
        },
        {
          "id": 275019,
          "question": "3 + 1",
          "question_option1": 2,
          "question_option2": 3,
          "question_option3": 4,
          "question_option4": 5,
          "difficulty": 1,
          "subject": [
            {
              "subject_code": "0",
              "name": null,
              "description": null
            }
          ]
        },
        {
          "id": 275127,
          "question": "5 - 2",
          "question_option1": 4,
          "question_option2": 3,
          "question_option3": 2,
          "question_option4": 1,
          "difficulty": 1,
          "subject": [
            {
              "subject_code": "0",
              "name": null,
              "description": null
            }
          ]
        },
        {
          "id": 275098,
          "question": "10 - 8",
          "question_option1": 4,
          "question_option2": 3,
          "question_option3": 2,
          "question_option4": 1,
          "difficulty": 1,
          "subject": [
            {
              "subject_code": "0",
              "name": null,
              "description": null
            }
          ]
        },
        {
          "id": 275091,
          "question": "10 - 1",
          "question_option1": 10,
          "question_option2": 9,
          "question_option3": 8,
          "question_option4": 7,
          "difficulty": 1,
          "subject": [
            {
              "subject_code": "0",
              "name": null,
              "description": null
            }
          ]
        },
        {
          "id": 275306,
          "question": "12 - 1",
          "question_option1": 12,
          "question_option2": 11,
          "question_option3": 10,
          "question_option4": 9,
          "difficulty": 2,
          "subject": [
            {
              "subject_code": "0",
              "name": null,
              "description": null
            }
          ]
        },
        {
          "id": 275128,
          "question": "5 - 3",
          "question_option1": 4,
          "question_option2": 3,
          "question_option3": 2,
          "question_option4": 1,
          "difficulty": 1,
          "subject": [
            {
              "subject_code": "0",
              "name": null,
              "description": null
            }
          ]
        },
        {
          "id": 275358,
          "question": "13 + 19",
          "question_option1": 31,
          "question_option2": 32,
          "question_option3": 33,
          "question_option4": 34,
          "difficulty": 3,
          "subject": [
            {
              "subject_code": "0",
              "name": null,
              "description": null
            }
          ]
        },
        {
          "id": 275304,
          "question": "12 - 3",
          "question_option1": 10,
          "question_option2": 9,
          "question_option3": 8,
          "question_option4": 7,
          "difficulty": 2,
          "subject": [
            {
              "subject_code": "0",
              "name": null,
              "description": null
            }
          ]
        }
      ],
      "opponent": [
        {
          "play_id": 7,
          "level": 1,
          "score": 75200,
          "ghost_data": [
            {
              "answer": "2",
              "answer_option": 2,
              "correct": "0",
              "complite_time": "3"
            },
            {
              "answer": "4",
              "answer_option": 4,
              "correct": "1",
              "complite_time": "3"
            },
            {
              "answer": "4",
              "answer_option": 4,
              "correct": "0",
              "complite_time": "3"
            },
            {
              "answer": "2",
              "answer_option": 2,
              "correct": "1",
              "complite_time": "3"
            },
            {
              "answer": "4",
              "answer_option": 4,
              "correct": "0",
              "complite_time": "3"
            },
            {
              "answer": "3",
              "answer_option": 3,
              "correct": "1",
              "complite_time": "3"
            },
            {
              "answer": "3",
              "answer_option": 3,
              "correct": "0",
              "complite_time": "3"
            },
            {
              "answer": "1",
              "answer_option": 1,
              "correct": "1",
              "complite_time": "3"
            },
            {
              "answer": "3",
              "answer_option": 3,
              "correct": "0",
              "complite_time": "3"
            }
          ]
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