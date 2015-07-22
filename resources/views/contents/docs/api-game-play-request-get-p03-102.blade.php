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
        <h3>GET  /api/game/play/102/request</h3>
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
               
                <div style="margin-top:50px; height:500px; overflow:auto; font-size:12px">
<pre class="prettyprint">GET http://staging.zapzapmath.com/api/game/play/102/request HTTP/1.1
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
      "id": 102,
      "name": "The 'Correct' Collector",
      "description": "Yes? No?",
      "parameters": null,
      "question_count": 20,
      "badges": null
    },
    "status": {
      "star": "0",
      "difficulty": 1,
      "top_score": 0
    },
    "planet_top_score": [
      
    ],
    "questions": [
      {
        "id": 205022,
        "question": "2 = 5",
        "answer": "FALSE",
        "answer_option_1": "T",
        "answer_option_2": "F",
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
        "id": 205024,
        "question": "4 = 5",
        "answer": "FALSE",
        "answer_option_1": "T",
        "answer_option_2": "F",
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
        "id": 205016,
        "question": "1 = 4",
        "answer": "FALSE",
        "answer_option_1": "T",
        "answer_option_2": "F",
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
        "id": 205040,
        "question": "10 = 8",
        "answer": "FALSE",
        "answer_option_1": "T",
        "answer_option_2": "F",
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
        "id": 205044,
        "question": "9 = 9",
        "answer": "TRUE",
        "answer_option_1": "T",
        "answer_option_2": "F",
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
        "id": 205007,
        "question": "2 = 2",
        "answer": "TRUE",
        "answer_option_1": "T",
        "answer_option_2": "F",
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
        "id": 205027,
        "question": "7 = 6",
        "answer": "FALSE",
        "answer_option_1": "T",
        "answer_option_2": "F",
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
        "id": 205014,
        "question": "4 = 3",
        "answer": "FALSE",
        "answer_option_1": "T",
        "answer_option_2": "F",
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
        "id": 205034,
        "question": "9 = 7",
        "answer": "FALSE",
        "answer_option_1": "T",
        "answer_option_2": "F",
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
        "id": 205015,
        "question": "5 = 3",
        "answer": "FALSE",
        "answer_option_1": "T",
        "answer_option_2": "F",
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
        "id": 205011,
        "question": "1 = 3",
        "answer": "FALSE",
        "answer_option_1": "T",
        "answer_option_2": "F",
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
        "id": 205038,
        "question": "8 = 8",
        "answer": "TRUE",
        "answer_option_1": "T",
        "answer_option_2": "F",
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
        "id": 205004,
        "question": "4 = 1",
        "answer": "FALSE",
        "answer_option_1": "T",
        "answer_option_2": "F",
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
        "id": 205046,
        "question": "6 = 10",
        "answer": "FALSE",
        "answer_option_1": "T",
        "answer_option_2": "F",
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
        "id": 205037,
        "question": "7 = 8",
        "answer": "FALSE",
        "answer_option_1": "T",
        "answer_option_2": "F",
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
        "id": 205006,
        "question": "1 = 2",
        "answer": "FALSE",
        "answer_option_1": "T",
        "answer_option_2": "F",
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
        "id": 205026,
        "question": "6 = 6",
        "answer": "TRUE",
        "answer_option_1": "T",
        "answer_option_2": "F",
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
        "id": 205032,
        "question": "7 = 7",
        "answer": "TRUE",
        "answer_option_1": "T",
        "answer_option_2": "F",
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
        "id": 205029,
        "question": "9 = 6",
        "answer": "FALSE",
        "answer_option_1": "T",
        "answer_option_2": "F",
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
        "id": 205028,
        "question": "8 = 6",
        "answer": "FALSE",
        "answer_option_1": "T",
        "answer_option_2": "F",
        "difficulty": 1,
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
}
</pre>
            </div>

        </div>
    </div>
    <!--END ROW -->
</div>


@stop