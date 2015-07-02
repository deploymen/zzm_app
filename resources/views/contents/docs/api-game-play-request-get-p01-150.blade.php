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
        <h3>GET  /api/game/play/150/request</h3>
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
<pre class="prettyprint">GET http://staging.zapzapmath.com/api/game/play/150/request HTTP/1.1
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
      "id": "150",
      "name": "Sushi Star: Sushimetry 3",
      "description": "Know your ingredients!",
      "parameters": null,
      "question_count": "10",
      "badges": {
        "speed": "1",
        "accuracy": "0.1",
        "score_mul_base": "1",
        "score_mul_accuracy": "1",
        "score_mul_speed": "1"
      }
    },
    "status": {
      "star": "1",
      "difficulty": 2,
      "top_score": "1"
    },
    "planet_top_score": {
      "nickname1": "Azoil",
      "nickname2": "Smishis",
      "avatar": "avatar5.jpg",
      "score": "1"
    },
    "questions": [
      {
        "id": "85",
        "question": "4 Triangles and 2 Hexagons",
        "difficulty": "2",
        "questions": {
          "angle3": "4",
          "angle4": "4",
          "angle5": "0",
          "angle6": "4"
        },
        "answers": {
          "angle3": "4",
          "angle4": "0",
          "angle5": "0",
          "angle6": "2"
        },
        "subject": [
          {
            "subject_code": "0",
            "name": null,
            "description": null
          }
        ]
      },
      {
        "id": "330",
        "question": "3 Triangles and 3 Quadrilaterals",
        "difficulty": "2",
        "questions": {
          "angle3": "4",
          "angle4": "4",
          "angle5": "0",
          "angle6": "4"
        },
        "answers": {
          "angle3": "3",
          "angle4": "3",
          "angle5": "0",
          "angle6": "0"
        },
        "subject": [
          {
            "subject_code": "0",
            "name": null,
            "description": null
          }
        ]
      },
      {
        "id": "112",
        "question": "3 Quadrilaterals and 3 Hexagons",
        "difficulty": "2",
        "questions": {
          "angle3": "4",
          "angle4": "4",
          "angle5": "0",
          "angle6": "4"
        },
        "answers": {
          "angle3": "0",
          "angle4": "3",
          "angle5": "0",
          "angle6": "3"
        },
        "subject": [
          {
            "subject_code": "0",
            "name": null,
            "description": null
          }
        ]
      },
      {
        "id": "418",
        "question": "2 Quadrilaterals and 1 Hexagon",
        "difficulty": "2",
        "questions": {
          "angle3": "4",
          "angle4": "4",
          "angle5": "0",
          "angle6": "4"
        },
        "answers": {
          "angle3": "0",
          "angle4": "2",
          "angle5": "0",
          "angle6": "1"
        },
        "subject": [
          {
            "subject_code": "0",
            "name": null,
            "description": null
          }
        ]
      },
      {
        "id": "235",
        "question": "1 Triangle and 1 Hexagon",
        "difficulty": "2",
        "questions": {
          "angle3": "4",
          "angle4": "4",
          "angle5": "0",
          "angle6": "4"
        },
        "answers": {
          "angle3": "1",
          "angle4": "0",
          "angle5": "0",
          "angle6": "1"
        },
        "subject": [
          {
            "subject_code": "0",
            "name": null,
            "description": null
          }
        ]
      },
      {
        "id": "325",
        "question": "3 Triangles and 1 Quadrilateral",
        "difficulty": "2",
        "questions": {
          "angle3": "4",
          "angle4": "4",
          "angle5": "0",
          "angle6": "4"
        },
        "answers": {
          "angle3": "3",
          "angle4": "1",
          "angle5": "0",
          "angle6": "0"
        },
        "subject": [
          {
            "subject_code": "0",
            "name": null,
            "description": null
          }
        ]
      },
      {
        "id": "242",
        "question": "3 Triangles and 3 Hexagons",
        "difficulty": "2",
        "questions": {
          "angle3": "4",
          "angle4": "4",
          "angle5": "0",
          "angle6": "4"
        },
        "answers": {
          "angle3": "3",
          "angle4": "0",
          "angle5": "0",
          "angle6": "3"
        },
        "subject": [
          {
            "subject_code": "0",
            "name": null,
            "description": null
          }
        ]
      },
      {
        "id": "423",
        "question": "4 Quadrilaterals and 2 Hexagons",
        "difficulty": "2",
        "questions": {
          "angle3": "4",
          "angle4": "4",
          "angle5": "0",
          "angle6": "4"
        },
        "answers": {
          "angle3": "0",
          "angle4": "4",
          "angle5": "0",
          "angle6": "2"
        },
        "subject": [
          {
            "subject_code": "0",
            "name": null,
            "description": null
          }
        ]
      },
      {
        "id": "399",
        "question": "4 Triangles and 3 Hexagons",
        "difficulty": "2",
        "questions": {
          "angle3": "4",
          "angle4": "4",
          "angle5": "0",
          "angle6": "4"
        },
        "answers": {
          "angle3": "4",
          "angle4": "0",
          "angle5": "0",
          "angle6": "3"
        },
        "subject": [
          {
            "subject_code": "0",
            "name": null,
            "description": null
          }
        ]
      },
      {
        "id": "169",
        "question": "3 Triangles and 1 Quadrilateral",
        "difficulty": "2",
        "questions": {
          "angle3": "4",
          "angle4": "4",
          "angle5": "0",
          "angle6": "4"
        },
        "answers": {
          "angle3": "3",
          "angle4": "1",
          "angle5": "0",
          "angle6": "0"
        },
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