@extends('layouts.docs-page', ['sidebar_item' => 'list-game'])

@section('title', 'GET  /api/game/play/103/request')

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
    <pre class="prettyprint">GET http://staging.zapzapmath.com/api/game/play/103/request HTTP/1.1
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
@stop