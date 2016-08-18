@extends('layouts.docs-page', ['sidebar_item' => 'list-game'])

@section('title', 'GET  /api/game/play/114/request')

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
    <pre class="prettyprint">GET http://staging.zapzapmath.com/api/game/play/114/request HTTP/1.1
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
      "id": 114,
      "name": "More or Less?",
      "description": ">=<",
      "question_count": 10,
      "badges": null
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
        "id": 5017,
        "difficulty": 1,
        "questions": {
          "left_question_1": 2,
          "left_question_2": "",
          "left_question_3": null,
          "right_question_1": 7,
          "right_question_2": "",
          "right_question_3": null
        },
        "answers": {
          "answer": "<"
        },
        "subject": [
          {
            "subject_code": "subject_1",
            "name": "subject_1",
            "description": "subject_1"
          }
        ]
      },
      {
        "id": 5019,
        "difficulty": 1,
        "questions": {
          "left_question_1": 2,
          "left_question_2": "",
          "left_question_3": null,
          "right_question_1": 9,
          "right_question_2": "",
          "right_question_3": null
        },
        "answers": {
          "answer": "<"
        },
        "subject": [
          {
            "subject_code": "subject_3",
            "name": "subject_3",
            "description": "subject_3"
          },
          {
            "subject_code": "subject_1",
            "name": "subject_1",
            "description": "subject_1"
          }
        ]
      },
      {
        "id": 5003,
        "difficulty": 1,
        "questions": {
          "left_question_1": 1,
          "left_question_2": "",
          "left_question_3": null,
          "right_question_1": 3,
          "right_question_2": "",
          "right_question_3": null
        },
        "answers": {
          "answer": "<"
        },
        "subject": [
          {
            "subject_code": "subject_1",
            "name": "subject_1",
            "description": "subject_1"
          },
          {
            "subject_code": "subject_3",
            "name": "subject_3",
            "description": "subject_3"
          }
        ]
      },
      {
        "id": 5044,
        "difficulty": 1,
        "questions": {
          "left_question_1": 5,
          "left_question_2": "",
          "left_question_3": null,
          "right_question_1": 4,
          "right_question_2": "",
          "right_question_3": null
        },
        "answers": {
          "answer": ">"
        },
        "subject": [
          {
            "subject_code": "subject_2",
            "name": "subject_2",
            "description": "subject_2"
          }
        ]
      },
      {
        "id": 5018,
        "difficulty": 1,
        "questions": {
          "left_question_1": 2,
          "left_question_2": "",
          "left_question_3": null,
          "right_question_1": 8,
          "right_question_2": "",
          "right_question_3": null
        },
        "answers": {
          "answer": "<"
        },
        "subject": [
          {
            "subject_code": "subject_2",
            "name": "subject_2",
            "description": "subject_2"
          }
        ]
      },
      {
        "id": 5015,
        "difficulty": 1,
        "questions": {
          "left_question_1": 2,
          "left_question_2": "",
          "left_question_3": null,
          "right_question_1": 5,
          "right_question_2": "",
          "right_question_3": null
        },
        "answers": {
          "answer": "<"
        },
        "subject": [
          {
            "subject_code": "subject_1",
            "name": "subject_1",
            "description": "subject_1"
          }
        ]
      },
      {
        "id": 5083,
        "difficulty": 1,
        "questions": {
          "left_question_1": 9,
          "left_question_2": "",
          "left_question_3": null,
          "right_question_1": 3,
          "right_question_2": "",
          "right_question_3": null
        },
        "answers": {
          "answer": ">"
        },
        "subject": [
          {
            "subject_code": "subject_1",
            "name": "subject_1",
            "description": "subject_1"
          }
        ]
      },
      {
        "id": 5002,
        "difficulty": 1,
        "questions": {
          "left_question_1": 1,
          "left_question_2": "",
          "left_question_3": null,
          "right_question_1": 2,
          "right_question_2": "",
          "right_question_3": null
        },
        "answers": {
          "answer": "<"
        },
        "subject": [
          {
            "subject_code": "subject_2",
            "name": "subject_2",
            "description": "subject_2"
          },
          {
            "subject_code": "subject_3",
            "name": "subject_3",
            "description": "subject_3"
          }
        ]
      },
      {
        "id": 5043,
        "difficulty": 1,
        "questions": {
          "left_question_1": 5,
          "left_question_2": "",
          "left_question_3": null,
          "right_question_1": 3,
          "right_question_2": "",
          "right_question_3": null
        },
        "answers": {
          "answer": ">"
        },
        "subject": [
          {
            "subject_code": "subject_3",
            "name": "subject_3",
            "description": "subject_3"
          },
          {
            "subject_code": "subject_1",
            "name": "subject_1",
            "description": "subject_1"
          }
        ]
      },
      {
        "id": 5059,
        "difficulty": 1,
        "questions": {
          "left_question_1": 6,
          "left_question_2": "",
          "left_question_3": null,
          "right_question_1": 9,
          "right_question_2": "",
          "right_question_3": null
        },
        "answers": {
          "answer": "<"
        },
        "subject": [
          {
            "subject_code": "subject_1",
            "name": "subject_1",
            "description": "subject_1"
          }
        ]
      }
    ]
  }
}
</pre>
@stop