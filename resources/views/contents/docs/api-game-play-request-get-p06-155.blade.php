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
        <h3>GET  /api/game/play/155/request</h3>
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
<pre class="prettyprint">GET http://staging.zapzapmath.com/api/game/play/155/request HTTP/1.1
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
      "id": 155,
      "name": "Word Games 10",
      "description": "Do you divide or multiply?",
      "question_count": 10,
      "badges": {
        "speed": "6",
        "accuracy": "0.6",
        "score_mul_base": "1",
        "score_mul_accuracy": "1",
        "score_mul_speed": "1"
      }
    },
    "status": {
      "star": 1,
      "difficulty": 2,
      "top_score": 1
    },
    "planet_top_score": [
      {
        "nickname1": "Mozviss",
        "nickname2": "Oznin",
        "avatar": "default.jpg",
        "score": 1
      }
    ],
    "questions": [
      {
        "id": 3083,
        "param_1": "12",
        "param_2": "4",
        "param_3": "",
        "p1_object": "fruit",
        "p2_object": "fruit",
        "p3_object": "",
        "setting": "Day",
        "part_1": "I have 12 fruits.",
        "part_2": "One bag could contain only 4 fruits.",
        "part_3": "How many bags do I need in total in order to contain all the fruits?",
        "expression": "12 \/ 4",
        "answer": 3,
        "subject": [
          {
            "subject_code": "0",
            "name": null,
            "description": null
          }
        ]
      },
      {
        "id": 3073,
        "param_1": "10",
        "param_2": "4",
        "param_3": "",
        "p1_object": "tree",
        "p2_object": "fruit",
        "p3_object": "",
        "setting": "Day",
        "part_1": "I planted 10 trees in my garden.",
        "part_2": "Each tree bore 4 fruits.",
        "part_3": "How many fruits are there in total?",
        "expression": "10 * 4",
        "answer": 40,
        "subject": [
          {
            "subject_code": "0",
            "name": null,
            "description": null
          }
        ]
      },
      {
        "id": 3085,
        "param_1": "30",
        "param_2": "10",
        "param_3": "",
        "p1_object": "fruit",
        "p2_object": "fruit",
        "p3_object": "",
        "setting": "Day",
        "part_1": "I have 30 fruits.",
        "part_2": "One bag could contain only 10 fruits.",
        "part_3": "How many bags do I need in total in order to contain all the fruits?",
        "expression": "30 \/ 10",
        "answer": 3,
        "subject": [
          {
            "subject_code": "0",
            "name": null,
            "description": null
          }
        ]
      },
      {
        "id": 3080,
        "param_1": "20",
        "param_2": "10",
        "param_3": "",
        "p1_object": "fruit",
        "p2_object": "fruit",
        "p3_object": "",
        "setting": "Day",
        "part_1": "I have 20 fruits.",
        "part_2": "One bag could contain only 10 fruits.",
        "part_3": "How many bags do I need in total in order to contain all the fruits?",
        "expression": "20 \/ 10",
        "answer": 2,
        "subject": [
          {
            "subject_code": "0",
            "name": null,
            "description": null
          }
        ]
      },
      {
        "id": 3024,
        "param_1": "10",
        "param_2": "5",
        "param_3": "",
        "p1_object": "fruit",
        "p2_object": "fruit slice",
        "p3_object": "",
        "setting": "Day",
        "part_1": "I have 10 fruits.",
        "part_2": "I am going to cut them into 5 pieces each.",
        "part_3": "How many pieces will there be in total?",
        "expression": "10 * 5",
        "answer": 50,
        "subject": [
          {
            "subject_code": "0",
            "name": null,
            "description": null
          }
        ]
      },
      {
        "id": 3035,
        "param_1": "30",
        "param_2": "10",
        "param_3": "",
        "p1_object": "fruit",
        "p2_object": "bag",
        "p3_object": "",
        "setting": "Day",
        "part_1": "I have 30 fruits.",
        "part_2": "I have 10 bags.",
        "part_3": "How many fruits should go in each bag?",
        "expression": "30 \/ 10",
        "answer": 3,
        "subject": [
          {
            "subject_code": "0",
            "name": null,
            "description": null
          }
        ]
      },
      {
        "id": 3098,
        "param_1": "40",
        "param_2": "4",
        "param_3": "",
        "p1_object": "fruit",
        "p2_object": "fruit",
        "p3_object": "",
        "setting": "Day",
        "part_1": "I have 40 fruits.",
        "part_2": "One bag could contain only 4 fruits.",
        "part_3": "How many bags do I need in total in order to contain all the fruits?",
        "expression": "40 \/ 4",
        "answer": 10,
        "subject": [
          {
            "subject_code": "0",
            "name": null,
            "description": null
          }
        ]
      },
      {
        "id": 3064,
        "param_1": "4",
        "param_2": "5",
        "param_3": "",
        "p1_object": "tree",
        "p2_object": "fruit",
        "p3_object": "",
        "setting": "Day",
        "part_1": "I planted 4 trees in my garden.",
        "part_2": "Each tree bore 5 fruits.",
        "part_3": "How many fruits are there in total?",
        "expression": "4 * 5",
        "answer": 20,
        "subject": [
          {
            "subject_code": "0",
            "name": null,
            "description": null
          }
        ]
      },
      {
        "id": 3090,
        "param_1": "40",
        "param_2": "10",
        "param_3": "",
        "p1_object": "fruit",
        "p2_object": "fruit",
        "p3_object": "",
        "setting": "Day",
        "part_1": "I have 40 fruits.",
        "part_2": "One bag could contain only 10 fruits.",
        "part_3": "How many bags do I need in total in order to contain all the fruits?",
        "expression": "40 \/ 10",
        "answer": 4,
        "subject": [
          {
            "subject_code": "0",
            "name": null,
            "description": null
          }
        ]
      },
      {
        "id": 3045,
        "param_1": "50",
        "param_2": "10",
        "param_3": "",
        "p1_object": "fruit",
        "p2_object": "bag",
        "p3_object": "",
        "setting": "Day",
        "part_1": "I have 50 fruits.",
        "part_2": "I have 10 bags.",
        "part_3": "How many fruits should go in each bag?",
        "expression": "50 \/ 10",
        "answer": 5,
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