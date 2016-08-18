@extends('layouts.docs-page', ['sidebar_item' => 'list-game'])

@section('title', 'GET  /api/game/play/225/request')

@section('desc')
<p>

</p>
@stop

@section('req')
<p>Header</p>
<table class="hover">
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
    <pre class="prettyprint">GET http://staging.zapzapmath.com/api/game/play/225/request HTTP/1.1
Host: staging.zapzapmath.com
X-game-code: 0000015k
    </pre>
</div>
@stop

@section('resp')
<table class="hover">
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
      "id": 225,
      "name": "calculator instructions 3",
      "description": "calculator instructions 3",
      "question_count": 10,
      "badges": {
        "speed": "1",
        "accuracy": "1",
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
        "nickname1": "Abscissa",
        "nickname2": "Alpha",
        "avatar": "default.jpg",
        "score": 8375
      }
    "questions": [
      {
        "id": 215329,
        "question": "(9, 6)",
        "answer_x": 9,
        "answer_y": 6,
        "origin_x": 0,
        "origin_y": 0,
        "diff_x": 1,
        "diff_y": 1,
        "initial_x": 0,
        "initial_y": 0,
        "planet_1": "",
        "planet_1_x": 0,
        "planet_1_y": 0,
        "planet_2": "",
        "planet_2_x": 0,
        "planet_2_y": 0,
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
        "id": 215354,
        "question": "(7, 4)",
        "answer_x": 7,
        "answer_y": 4,
        "origin_x": 0,
        "origin_y": 0,
        "diff_x": 1,
        "diff_y": 1,
        "initial_x": 0,
        "initial_y": 0,
        "planet_1": "",
        "planet_1_x": 0,
        "planet_1_y": 0,
        "planet_2": "",
        "planet_2_x": 0,
        "planet_2_y": 0,
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
        "id": 215254,
        "question": "(2, 4)",
        "answer_x": 2,
        "answer_y": 4,
        "origin_x": 0,
        "origin_y": 0,
        "diff_x": 1,
        "diff_y": 1,
        "initial_x": 0,
        "initial_y": 0,
        "planet_1": "",
        "planet_1_x": 0,
        "planet_1_y": 0,
        "planet_2": "",
        "planet_2_x": 0,
        "planet_2_y": 0,
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
        "id": 215270,
        "question": "(10, 3)",
        "answer_x": 10,
        "answer_y": 3,
        "origin_x": 0,
        "origin_y": 0,
        "diff_x": 1,
        "diff_y": 1,
        "initial_x": 0,
        "initial_y": 0,
        "planet_1": "",
        "planet_1_x": 0,
        "planet_1_y": 0,
        "planet_2": "",
        "planet_2_x": 0,
        "planet_2_y": 0,
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
        "id": 215357,
        "question": "(7, 7)",
        "answer_x": 7,
        "answer_y": 7,
        "origin_x": 0,
        "origin_y": 0,
        "diff_x": 1,
        "diff_y": 1,
        "initial_x": 0,
        "initial_y": 0,
        "planet_1": "",
        "planet_1_x": 0,
        "planet_1_y": 0,
        "planet_2": "",
        "planet_2_x": 0,
        "planet_2_y": 0,
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
        "id": 215396,
        "question": "(9, 6)",
        "answer_x": 9,
        "answer_y": 6,
        "origin_x": 0,
        "origin_y": 0,
        "diff_x": 1,
        "diff_y": 1,
        "initial_x": 0,
        "initial_y": 0,
        "planet_1": "",
        "planet_1_x": 0,
        "planet_1_y": 0,
        "planet_2": "",
        "planet_2_x": 0,
        "planet_2_y": 0,
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
        "id": 215232,
        "question": "(1, 2)",
        "answer_x": 1,
        "answer_y": 2,
        "origin_x": 0,
        "origin_y": 0,
        "diff_x": 1,
        "diff_y": 1,
        "initial_x": 0,
        "initial_y": 0,
        "planet_1": "",
        "planet_1_x": 0,
        "planet_1_y": 0,
        "planet_2": "",
        "planet_2_x": 0,
        "planet_2_y": 0,
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
        "id": 215311,
        "question": "(5, 1)",
        "answer_x": 5,
        "answer_y": 1,
        "origin_x": 0,
        "origin_y": 0,
        "diff_x": 1,
        "diff_y": 1,
        "initial_x": 0,
        "initial_y": 0,
        "planet_1": "",
        "planet_1_x": 0,
        "planet_1_y": 0,
        "planet_2": "",
        "planet_2_x": 0,
        "planet_2_y": 0,
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
        "id": 215389,
        "question": "(9, 9)",
        "answer_x": 9,
        "answer_y": 9,
        "origin_x": 0,
        "origin_y": 0,
        "diff_x": 1,
        "diff_y": 1,
        "initial_x": 0,
        "initial_y": 0,
        "planet_1": "",
        "planet_1_x": 0,
        "planet_1_y": 0,
        "planet_2": "",
        "planet_2_x": 0,
        "planet_2_y": 0,
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
        "id": 215226,
        "question": "(6, 1)",
        "answer_x": 6,
        "answer_y": 1,
        "origin_x": 0,
        "origin_y": 0,
        "diff_x": 1,
        "diff_y": 1,
        "initial_x": 0,
        "initial_y": 0,
        "planet_1": "",
        "planet_1_x": 0,
        "planet_1_y": 0,
        "planet_2": "",
        "planet_2_x": 0,
        "planet_2_y": 0,
        "difficulty": 2,
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
@stop