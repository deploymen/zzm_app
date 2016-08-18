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
        
      }
    },
    "status": {
      "star": 1,
      "difficulty": 2,
      "top_score": 1
    },
    "planet_top_score": [
      
    ],
    "questions": {
      "player": [
        {
          "level": 10,
          "exp": 0,
          "top_score": 1,
          "question": [
            {
              "id": 275367,
              "question": "14 + 17",
              "question_option1": 30,
              "question_option2": 31,
              "question_option3": 32,
              "question_option4": 33,
              "answer": 31,
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
              "id": 275343,
              "question": "12 + 15",
              "question_option1": 26,
              "question_option2": 27,
              "question_option3": 28,
              "question_option4": 29,
              "answer": 27,
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
              "id": 275479,
              "question": "15 - 12",
              "question_option1": 2,
              "question_option2": 3,
              "question_option3": 4,
              "question_option4": 5,
              "answer": 3,
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
              "id": 275472,
              "question": "16 - 11",
              "question_option1": 4,
              "question_option2": 5,
              "question_option3": 6,
              "question_option4": 7,
              "answer": 5,
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
              "id": 275376,
              "question": "15 + 15",
              "question_option1": 29,
              "question_option2": 30,
              "question_option3": 31,
              "question_option4": 32,
              "answer": 30,
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
              "id": 275383,
              "question": "16 + 11",
              "question_option1": 26,
              "question_option2": 27,
              "question_option3": 28,
              "question_option4": 29,
              "answer": 27,
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
              "id": 275355,
              "question": "13 + 16",
              "question_option1": 28,
              "question_option2": 29,
              "question_option3": 30,
              "question_option4": 31,
              "answer": 29,
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
              "id": 275401,
              "question": "17 + 18",
              "question_option1": 34,
              "question_option2": 35,
              "question_option3": 36,
              "question_option4": 37,
              "answer": 35,
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
              "id": 275375,
              "question": "15 + 14",
              "question_option1": 28,
              "question_option2": 29,
              "question_option3": 30,
              "question_option4": 31,
              "answer": 29,
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
              "id": 275359,
              "question": "13 + 20",
              "question_option1": 32,
              "question_option2": 33,
              "question_option3": 34,
              "question_option4": 35,
              "answer": 33,
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
              "id": 275333,
              "question": "11 + 16",
              "question_option1": 26,
              "question_option2": 27,
              "question_option3": 28,
              "question_option4": 29,
              "answer": 27,
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
              "id": 275454,
              "question": "19 - 17",
              "question_option1": 1,
              "question_option2": 2,
              "question_option3": 3,
              "question_option4": 4,
              "answer": 2,
              "difficulty": 3,
              "subject": [
                {
                  "subject_code": "0",
                  "name": null,
                  "description": null
                }
              ]
            }
          ]
        }
      ],
      "opponent": [
        {
          "play_id": 10,
          "level": 10,
          "score": 1,
          "ghost_data": [
            {
              "answer": "2",
              "answer_option": 2,
              "correct": "1",
              "complete_time": "3",
              "difficulty": 1
            },
            {
              "answer": "2",
              "answer_option": 2,
              "correct": "1",
              "complete_time": "3",
              "difficulty": 1
            },
            {
              "answer": "1",
              "answer_option": 2,
              "correct": "1",
              "complete_time": "3",
              "difficulty": 1
            },
            {
              "answer": "2",
              "answer_option": 2,
              "correct": "0",
              "complete_time": "3",
              "difficulty": 1
            },
            {
              "answer": "3",
              "answer_option": 2,
              "correct": "0",
              "complete_time": "3",
              "difficulty": 1
            },
            {
              "answer": "2",
              "answer_option": 2,
              "correct": "1",
              "complete_time": "3",
              "difficulty": 1
            },
            {
              "answer": "4",
              "answer_option": 2,
              "correct": "0",
              "complete_time": "3",
              "difficulty": 1
            },
            {
              "answer": "3",
              "answer_option": 2,
              "correct": "0",
              "complete_time": "3",
              "difficulty": 1
            },
            {
              "answer": "2",
              "answer_option": 2,
              "correct": "1",
              "complete_time": "3",
              "difficulty": 1
            },
            {
              "answer": "1",
              "answer_option": 2,
              "correct": "0",
              "complete_time": "3",
              "difficulty": 1
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

@stop