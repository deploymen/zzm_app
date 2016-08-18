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

<h3>GET  /api/game/result/system-planet/play/planet/{planet_id}</h3>
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
            <pre class="prettyprint">GET http://staging.zapzapmath.com/api/game/result/system-planet/play?planet_id=6 HTTP/1.1
Host: staging.zapzapmath.com
X-game-code: 0000014n
Cookie: _ga=GA1.2.238970283.1430284975; laravel_session=eyJpdiI6IjgxUGczUE0wSnBzY2Nzajk0eUNoTFE9PSIsInZhbHVlIjoic3FoYWxwdG5PeExcL0Zud3EzXC9YM0F6c2wwUkZKVFBPdU0xZ3NiQUZjd3BcL0Uxc002ZDVEUnBUUkxISU4zYUtJMmhJbHU0TCtONko3UEQzUzA0YnY0YXc9PSIsIm1hYyI6IjZiZmNlNjBjNWFkZWIxYjllZWQ4MGE5ODk2NmVmZmY3MGQ0OTg3MmZiYmEyZGNiZGYyYTUzOTI0YzA5MTQ3MTgifQ%3D%3D
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
    "0": [
      {
        "id": 1,
        "planet_id": 6,
        "score": 90,
        "status": "pass",
        "target_type": "p06",
        "result": [
          {
            "id": 1,
            "play_id": 1,
            "question_id": 9226,
            "target_type": "p06",
            "target_id": 1,
            "game_type_id": 6,
            "topic_main_id": 6,
            "topic_sub_id": 2,
            "created_at": "2015-05-05 18:46:59",
            "updated_at": null,
            "deleted_at": null,
            "answer": "9",
            "correct": "1"
          },
          {
            "id": 2,
            "play_id": 1,
            "question_id": 9227,
            "target_type": "p06",
            "target_id": 2,
            "game_type_id": 6,
            "topic_main_id": 6,
            "topic_sub_id": 2,
            "created_at": "2015-05-05 18:46:59",
            "updated_at": null,
            "deleted_at": null,
            "answer": "2",
            "correct": "0"
          },
          {
            "id": 3,
            "play_id": 1,
            "question_id": 9228,
            "target_type": "p06",
            "target_id": 3,
            "game_type_id": 6,
            "topic_main_id": 6,
            "topic_sub_id": 2,
            "created_at": "2015-05-05 18:46:59",
            "updated_at": null,
            "deleted_at": null,
            "answer": "5",
            "correct": "1"
          },
          {
            "id": 4,
            "play_id": 1,
            "question_id": 9229,
            "target_type": "p06",
            "target_id": 4,
            "game_type_id": 6,
            "topic_main_id": 6,
            "topic_sub_id": 2,
            "created_at": "2015-05-05 18:46:59",
            "updated_at": null,
            "deleted_at": null,
            "answer": "5",
            "correct": "0"
          },
          {
            "id": 5,
            "play_id": 1,
            "question_id": 9227,
            "target_type": "p06",
            "target_id": 2,
            "game_type_id": 6,
            "topic_main_id": 6,
            "topic_sub_id": 2,
            "created_at": "2015-05-05 18:46:59",
            "updated_at": null,
            "deleted_at": null,
            "answer": "2",
            "correct": "0"
          },
          {
            "id": 6,
            "play_id": 1,
            "question_id": 9228,
            "target_type": "p06",
            "target_id": 3,
            "game_type_id": 6,
            "topic_main_id": 6,
            "topic_sub_id": 2,
            "created_at": "2015-05-05 18:46:59",
            "updated_at": null,
            "deleted_at": null,
            "answer": "5",
            "correct": "1"
          },
          {
            "id": 7,
            "play_id": 1,
            "question_id": 9229,
            "target_type": "p06",
            "target_id": 4,
            "game_type_id": 6,
            "topic_main_id": 6,
            "topic_sub_id": 2,
            "created_at": "2015-05-05 18:46:59",
            "updated_at": null,
            "deleted_at": null,
            "answer": "5",
            "correct": "0"
          },
          {
            "id": 8,
            "play_id": 1,
            "question_id": 9227,
            "target_type": "p06",
            "target_id": 2,
            "game_type_id": 6,
            "topic_main_id": 6,
            "topic_sub_id": 2,
            "created_at": "2015-05-05 18:46:59",
            "updated_at": null,
            "deleted_at": null,
            "answer": "2",
            "correct": "0"
          },
          {
            "id": 9,
            "play_id": 1,
            "question_id": 9228,
            "target_type": "p06",
            "target_id": 3,
            "game_type_id": 6,
            "topic_main_id": 6,
            "topic_sub_id": 2,
            "created_at": "2015-05-05 18:46:59",
            "updated_at": null,
            "deleted_at": null,
            "answer": "5",
            "correct": "1"
          },
          {
            "id": 10,
            "play_id": 1,
            "question_id": 9229,
            "target_type": "p06",
            "target_id": 4,
            "game_type_id": 6,
            "topic_main_id": 6,
            "topic_sub_id": 2,
            "created_at": "2015-05-05 18:46:59",
            "updated_at": null,
            "deleted_at": null,
            "answer": "5",
            "correct": "0"
          }
        ]
      }
    ]
  },
  "pageSize": "30",
  "pageTotal": 1
}
        </pre>
    </div>

</div>

@stop