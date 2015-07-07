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
        <h3>GET  /api/game/play/104/request</h3>
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
<pre class="prettyprint">GET http://staging.zapzapmath.com/api/game/play/104/request HTTP/1.1
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
      "id": "104",
      "name": "Word Games",
      "description": "What's your (word) problem?",
      "parameters": null,
      "question_count": "10",
      "badges": {
        "speed": "6",
        "accuracy": "0.6",
        "score_mul_base": "1",
        "score_mul_accuracy": "1",
        "score_mul_speed": "1"
      }
    },
    "status": {
      "star": "0",
      "difficulty": 1,
      "top_score": "0"
    },
    "planet_top_score": {
      "nickname1": "NULL",
      "nickname2": "NULL",
      "avatar": "NULL",
      "score": "NULL"
    },
    "questions": [
      {
        "id": "3383",
        "param_1": "8",
        "param_2": "1",
        "param_3": "",
        "p1_object": "coin",
        "p2_object": "coin",
        "p3_object": "",
        "setting": "Small town",
        "part_1": "Alvin has 8 coins.",
        "part_2": "Bert has 1 less coin(s).",
        "part_3": "How many coins does Bert have?",
        "expression": "8 - 1",
        "answer": 7,
        "subject": [
          {
            "subject_code": "0",
            "name": null,
            "description": null
          }
        ]
      },
      {
        "id": "3501",
        "param_1": "1",
        "param_2": "1",
        "param_3": "",
        "p1_object": "coin",
        "p2_object": "coin",
        "p3_object": "",
        "setting": "Small town",
        "part_1": "I had 1 coin(s).",
        "part_2": "I received 1 more coin(s).",
        "part_3": "How many coins do I have now?",
        "expression": "1 + 1",
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
        "id": "3360",
        "param_1": "4",
        "param_2": "1",
        "param_3": "",
        "p1_object": "fruit",
        "p2_object": "fruit",
        "p3_object": "",
        "setting": "Small town",
        "part_1": "I had 4 fruits.",
        "part_2": "I ate 1 of them.",
        "part_3": "How many fruits do I have left?",
        "expression": "4 - 1",
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
        "id": "3315",
        "param_1": "7",
        "param_2": "1",
        "param_3": "",
        "p1_object": "fruit",
        "p2_object": "fruit",
        "p3_object": "",
        "setting": "Small town",
        "part_1": "I have 7 fruit(s).",
        "part_2": "I received another 1 fruit(s).",
        "part_3": "How many fruits do I have in total?",
        "expression": "7 + 1",
        "answer": 8,
        "subject": [
          {
            "subject_code": "0",
            "name": null,
            "description": null
          }
        ]
      },
      {
        "id": "3363",
        "param_1": "3",
        "param_2": "1",
        "param_3": "",
        "p1_object": "fruit",
        "p2_object": "fruit",
        "p3_object": "",
        "setting": "Small town",
        "part_1": "I had 3 fruits.",
        "part_2": "I ate 1 of them.",
        "part_3": "How many fruits do I have left?",
        "expression": "3 - 1",
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
        "id": "3428",
        "param_1": "3",
        "param_2": "1",
        "param_3": "",
        "p1_object": "coin",
        "p2_object": "coin",
        "p3_object": "",
        "setting": "Small town",
        "part_1": "Arvin has 3 coin(s).",
        "part_2": "Bella has 1 coin(s) more than Arvin.",
        "part_3": "How many coins does Bella have?",
        "expression": "3 + 1",
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
        "id": "3456",
        "param_1": "10",
        "param_2": "1",
        "param_3": "",
        "p1_object": "fruit",
        "p2_object": "fruit",
        "p3_object": "",
        "setting": "Small town",
        "part_1": "Abdul and Brendan have 10 fruits.",
        "part_2": "1 of those fruits belong to Abdul.",
        "part_3": "How many fruits belong to Brendan?",
        "expression": "10 - 1",
        "answer": 9,
        "subject": [
          {
            "subject_code": "0",
            "name": null,
            "description": null
          }
        ]
      },
      {
        "id": "3455",
        "param_1": "9",
        "param_2": "1",
        "param_3": "",
        "p1_object": "coin",
        "p2_object": "coin",
        "p3_object": "",
        "setting": "Small town",
        "part_1": "Arvin has 9 coin(s).",
        "part_2": "Bella has 1 coin(s) more than Arvin.",
        "part_3": "How many coins does Bella have?",
        "expression": "9 + 1",
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
        "id": "3318",
        "param_1": "8",
        "param_2": "1",
        "param_3": "",
        "p1_object": "fruit",
        "p2_object": "fruit",
        "p3_object": "",
        "setting": "Small town",
        "part_1": "I have 8 fruit(s).",
        "part_2": "I received another 1 fruit(s).",
        "part_3": "How many fruits do I have in total?",
        "expression": "8 + 1",
        "answer": 9,
        "subject": [
          {
            "subject_code": "0",
            "name": null,
            "description": null
          }
        ]
      },
      {
        "id": "3585",
        "param_1": "4",
        "param_2": "1",
        "param_3": "",
        "p1_object": "coin",
        "p2_object": "coin",
        "p3_object": "",
        "setting": "Small town",
        "part_1": "I had 4 coins.",
        "part_2": "I used 1 coin(s).",
        "part_3": "How many coins do I have now?",
        "expression": "4 - 1",
        "answer": 3,
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