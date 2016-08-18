@extends('layouts.docs-page', ['sidebar_item' => 'list-game'])

@section('title', 'GET  /api/game/play/102/request')

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
    <pre class="prettyprint">GET http://staging.zapzapmath.com/api/game/play/102/request HTTP/1.1
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
      "id": 102,
      "name": "The 'Correct' Collector",
      "description": "Yes? No?",
      "question_count": 20,
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
        "id": 205017,
        "question": "2 = 4",
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
        "id": 205033,
        "question": "8 = 7",
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
        "id": 205019,
        "question": "4 = 4",
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
        "id": 205049,
        "question": "9 = 10",
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
        "id": 205009,
        "question": "4 = 2",
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
        "id": 205031,
        "question": "6 = 7",
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
        "id": 205043,
        "question": "8 = 9",
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
        "id": 205002,
        "question": "2 = 1",
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
        "id": 205042,
        "question": "7 = 9",
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
        "id": 205039,
        "question": "9 = 8",
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
        "id": 205045,
        "question": "10 = 9",
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
        "id": 205013,
        "question": "3 = 3",
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
        "id": 205048,
        "question": "8 = 10",
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
      }
    ]
  }
}
</pre>
@stop