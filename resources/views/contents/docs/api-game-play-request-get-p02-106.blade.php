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
        <h3>GET  /api/game/play/106/request</h3>
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
<pre class="prettyprint">GET http://staging.zapzapmath.com/api/game/play/106/request HTTP/1.1
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
      "id": 106,
      "name": "Space Taxi 2",
      "description": "Get up to 20 passengers!",
      "question_count": 10,
      "badges": {
        "speed": "2",
        "accuracy": "0.2",
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
    "questions": [
      {
        "id": 209037,
        "question": "15",
        "answer_option_1": "8",
        "answer_option_2": "6",
        "answer_option_3": "9",
        "answer_option_4": "",
        "answer_option_5": "",
        "answer_option_6": "",
        "fixed_num": 7,
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
        "id": 209011,
        "question": "12",
        "answer_option_1": "10",
        "answer_option_2": "2",
        "answer_option_3": "7",
        "answer_option_4": "",
        "answer_option_5": "",
        "answer_option_6": "",
        "fixed_num": 2,
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
        "id": 209021,
        "question": "13",
        "answer_option_1": "9",
        "answer_option_2": "1",
        "answer_option_3": "5",
        "answer_option_4": "",
        "answer_option_5": "",
        "answer_option_6": "",
        "fixed_num": 4,
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
        "id": 209019,
        "question": "12",
        "answer_option_1": "2",
        "answer_option_2": "7",
        "answer_option_3": "3",
        "answer_option_4": "",
        "answer_option_5": "",
        "answer_option_6": "",
        "fixed_num": 10,
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
        "id": 209005,
        "question": "11",
        "answer_option_1": "6",
        "answer_option_2": "10",
        "answer_option_3": "1",
        "answer_option_4": "",
        "answer_option_5": "",
        "answer_option_6": "",
        "fixed_num": 5,
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
        "id": 209034,
        "question": "14",
        "answer_option_1": "4",
        "answer_option_2": "2",
        "answer_option_3": "6",
        "answer_option_4": "",
        "answer_option_5": "",
        "answer_option_6": "",
        "fixed_num": 10,
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
        "id": 209006,
        "question": "11",
        "answer_option_1": "5",
        "answer_option_2": "4",
        "answer_option_3": "7",
        "answer_option_4": "",
        "answer_option_5": "",
        "answer_option_6": "",
        "fixed_num": 6,
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
        "id": 209014,
        "question": "12",
        "answer_option_1": "7",
        "answer_option_2": "4",
        "answer_option_3": "1",
        "answer_option_4": "",
        "answer_option_5": "",
        "answer_option_6": "",
        "fixed_num": 5,
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
        "id": 209032,
        "question": "14",
        "answer_option_1": "6",
        "answer_option_2": "7",
        "answer_option_3": "9",
        "answer_option_4": "",
        "answer_option_5": "",
        "answer_option_6": "",
        "fixed_num": 8,
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
        "id": 209040,
        "question": "15",
        "answer_option_1": "5",
        "answer_option_2": "4",
        "answer_option_3": "6",
        "answer_option_4": "",
        "answer_option_5": "",
        "answer_option_6": "",
        "fixed_num": 10,
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