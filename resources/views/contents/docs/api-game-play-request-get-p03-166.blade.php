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
        <h3>GET  /api/game/play/166/request</h3>
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
<pre class="prettyprint">GET http://staging.zapzapmath.com/api/game/play/166/request HTTP/1.1
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
      "id": 166,
      "name": "The Big Showdown",
      "description": "Which piece fits?",
      "question_count": 20,
      "badges": {
        "speed": "3",
        "accuracy": "0.3",
        "score_mul_base": "1",
        "score_mul_accuracy": "1",
        "score_mul_speed": "1"
      }
    },
    "status": {
      "star": 2,
      "difficulty": 3,
      "top_score": 108
    },
    "planet_top_score": [
      {
        "nickname1": "Mozviss",
        "nickname2": "Oznin",
        "avatar": "default.jpg",
        "score": 108
      },
      {
        "nickname1": "Mozviss",
        "nickname2": "Oznin",
        "avatar": "default.jpg",
        "score": 1
      }
    ],
    "questions": [
      {
        "id": 2165,
        "question": "9\u00d76=15",
        "answer": "FALSE",
        "answer_option_1": "T",
        "answer_option_2": "F",
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
        "id": 2164,
        "question": "8\u00d76=14",
        "answer": "FALSE",
        "answer_option_1": "T",
        "answer_option_2": "F",
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
        "id": 2167,
        "question": "30\u00d76=36",
        "answer": "FALSE",
        "answer_option_1": "T",
        "answer_option_2": "F",
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
        "id": 2021,
        "question": "3\u00d75=15",
        "answer": "TRUE",
        "answer_option_1": "T",
        "answer_option_2": "F",
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
        "id": 2168,
        "question": "40\u00d76=46",
        "answer": "FALSE",
        "answer_option_1": "T",
        "answer_option_2": "F",
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
        "id": 2135,
        "question": "5\u00d75=10",
        "answer": "FALSE",
        "answer_option_1": "T",
        "answer_option_2": "F",
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
        "id": 2022,
        "question": "4\u00d75=20",
        "answer": "TRUE",
        "answer_option_1": "T",
        "answer_option_2": "F",
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
        "id": 2162,
        "question": "6\u00d76=12",
        "answer": "FALSE",
        "answer_option_1": "T",
        "answer_option_2": "F",
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
        "id": 2245,
        "question": "6-6=1",
        "answer": "FALSE",
        "answer_option_1": "T",
        "answer_option_2": "F",
        "difficulty": 3,
        "subject": [
          {
            "subject_code": "subject_1",
            "name": "subject_1",
            "description": "subject_1"
          }
        ]
      },
      {
        "id": 2057,
        "question": "50\u00d76=300",
        "answer": "TRUE",
        "answer_option_1": "T",
        "answer_option_2": "F",
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
        "id": 2019,
        "question": "1\u00d75=5",
        "answer": "TRUE",
        "answer_option_1": "T",
        "answer_option_2": "F",
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
        "id": 2024,
        "question": "10\u00d75=50",
        "answer": "TRUE",
        "answer_option_1": "T",
        "answer_option_2": "F",
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
        "id": 2254,
        "question": "5-5=1",
        "answer": "FALSE",
        "answer_option_1": "T",
        "answer_option_2": "F",
        "difficulty": 3,
        "subject": [
          {
            "subject_code": "subject_2",
            "name": "subject_2",
            "description": "subject_2"
          }
        ]
      },
      {
        "id": 2132,
        "question": "2\u00d75=7",
        "answer": "FALSE",
        "answer_option_1": "T",
        "answer_option_2": "F",
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
        "id": 2056,
        "question": "40\u00d76=240",
        "answer": "TRUE",
        "answer_option_1": "T",
        "answer_option_2": "F",
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
        "id": 2049,
        "question": "1\u00d76=6",
        "answer": "TRUE",
        "answer_option_1": "T",
        "answer_option_2": "F",
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
        "id": 2246,
        "question": "6-5=2",
        "answer": "FALSE",
        "answer_option_1": "T",
        "answer_option_2": "F",
        "difficulty": 3,
        "subject": [
          {
            "subject_code": "subject_2",
            "name": "subject_2",
            "description": "subject_2"
          }
        ]
      },
      {
        "id": 2163,
        "question": "7\u00d76=13",
        "answer": "FALSE",
        "answer_option_1": "T",
        "answer_option_2": "F",
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
        "id": 2020,
        "question": "2\u00d75=10",
        "answer": "TRUE",
        "answer_option_1": "T",
        "answer_option_2": "F",
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
        "id": 2052,
        "question": "8\u00d76=48",
        "answer": "TRUE",
        "answer_option_1": "T",
        "answer_option_2": "F",
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
}
</pre>
            </div>

        </div>
    </div>
    <!--END ROW -->
</div>


@stop