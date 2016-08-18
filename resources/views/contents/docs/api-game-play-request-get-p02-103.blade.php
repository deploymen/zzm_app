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

<h3>GET  /api/game/play/103/request</h3>
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
            <pre class="prettyprint">GET http://staging.zapzapmath.com/api/game/play/103/request HTTP/1.1
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
      "id": 103,
      "name": "Space Taxi",
      "description": "What + What = What??",
      "question_count": 5,
      "badges": {
        "speed": "2",
        "accuracy": "0.2",
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
        "id": 1111,
        "question": "9",
        "answer_option_1": "2",
        "answer_option_2": "7",
        "answer_option_3": "3",
        "answer_option_4": "4",
        "answer_option_5": "4",
        "answer_option_6": "",
        "fixed_num": 0,
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
        "id": 1071,
        "question": "9",
        "answer_option_1": "2",
        "answer_option_2": "2",
        "answer_option_3": "5",
        "answer_option_4": "3",
        "answer_option_5": "",
        "answer_option_6": "",
        "fixed_num": 0,
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
        "id": 1116,
        "question": "10",
        "answer_option_1": "3",
        "answer_option_2": "7",
        "answer_option_3": "2",
        "answer_option_4": "6",
        "answer_option_5": "7",
        "answer_option_6": "",
        "fixed_num": 0,
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
        "id": 1118,
        "question": "10",
        "answer_option_1": "5",
        "answer_option_2": "5",
        "answer_option_3": "4",
        "answer_option_4": "8",
        "answer_option_5": "9",
        "answer_option_6": "",
        "fixed_num": 0,
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
        "id": 1085,
        "question": "7",
        "answer_option_1": "1",
        "answer_option_2": "1",
        "answer_option_3": "5",
        "answer_option_4": "3",
        "answer_option_5": "8",
        "answer_option_6": "",
        "fixed_num": 0,
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

@stop