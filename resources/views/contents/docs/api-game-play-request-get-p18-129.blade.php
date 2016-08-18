@extends('layouts.docs-page', ['sidebar_item' => 'list-game'])

@section('title', 'GET  /api/game/play/129/request')

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
    <pre class="prettyprint">GET http://staging.zapzapmath.com/api/game/play/129/request HTTP/1.1
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
      "id": 129,
      "name": "Engine Engine Number Line",
      "description": "Number line, number line",
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
      "star": 1,
      "difficulty": 2,
      "top_score": 1
    },
    "planet_top_score": [
      {
        "nickname1": "Mozviss",
        "nickname2": "Oznin",
        "avatar": "default.jpg",
        "score": 17700
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
        "id": 211020,
        "question": 10,
        "option_from": 0,
        "option_until_total": 20,
        "answer": 10,
        "ruler_type": 2,
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
        "id": 211026,
        "question": 16,
        "option_from": 0,
        "option_until_total": 20,
        "answer": 16,
        "ruler_type": 2,
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
        "id": 211023,
        "question": 13,
        "option_from": 0,
        "option_until_total": 20,
        "answer": 13,
        "ruler_type": 2,
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
        "id": 211027,
        "question": 17,
        "option_from": 0,
        "option_until_total": 20,
        "answer": 17,
        "ruler_type": 2,
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
        "id": 211028,
        "question": 18,
        "option_from": 0,
        "option_until_total": 20,
        "answer": 18,
        "ruler_type": 2,
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
        "id": 211017,
        "question": 7,
        "option_from": 0,
        "option_until_total": 20,
        "answer": 7,
        "ruler_type": 2,
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
        "id": 211018,
        "question": 8,
        "option_from": 0,
        "option_until_total": 20,
        "answer": 8,
        "ruler_type": 2,
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
        "id": 211016,
        "question": 6,
        "option_from": 0,
        "option_until_total": 20,
        "answer": 6,
        "ruler_type": 2,
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
        "id": 211014,
        "question": 4,
        "option_from": 0,
        "option_until_total": 20,
        "answer": 4,
        "ruler_type": 2,
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
        "id": 211015,
        "question": 5,
        "option_from": 0,
        "option_until_total": 20,
        "answer": 5,
        "ruler_type": 2,
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