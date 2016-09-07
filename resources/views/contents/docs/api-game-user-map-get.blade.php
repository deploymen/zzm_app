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
        <h3>GET  /api/game/user-map?version=1.1</h3>
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
<pre class="prettyprint">
GET http://staging.zapzapmath.com/api/game/user-map/version=1.1 HTTP/1.1
Host: staging.zapzapmath.com
X-game-code: devanm01
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
    "profile": {
      "first_name": "lai",
      "last_name": "",
      "nick_name1": "Extremum",
      "nick_name2": "preschool",
      "total_star": "2",
      "user_type": 1,
      "game_code": "devanm01"
    },
    "system_planet": [
      {
        "system_id": 102,
        "name": "Adding Tens and Ones",
        "subsystem": [
          {
            "subsystem_id": 5,
            "subsytem_name": "Accuracy",
            "planet": [
              {
                "planet_id": 123,
                "name": "Tap Hundreds",
                "description": "Ten tens!",
                "star": 0,
                "enable": 1
              }
            ]
          }
        ]
      },
      {
        "system_id": 107,
        "name": "Plus and Minus Tens and Ones",
        "subsystem": [
          {
            "subsystem_id": 4,
            "subsytem_name": "Skills",
            "planet": [
              {
                "planet_id": 105,
                "name": "Tap Tens",
                "description": "How many ones are in a ten?",
                "star": 0,
                "enable": 0
              },
              {
                "planet_id": 114,
                "name": "Gears!",
                "description": "What do the signs mean? (>=< 40)",
                "star": 0,
                "enable": 0
              }
            ]
          },
          {
            "subsystem_id": 5,
            "subsytem_name": "Accuracy",
            "planet": [
              {
                "planet_id": 103,
                "name": "Space Shuttle",
                "description": "What makes the number?",
                "star": 0,
                "enable": 0
              },
              {
                "planet_id": 106,
                "name": "Space Shuttle 2",
                "description": "Ship up to 20 parcels!",
                "star": 0,
                "enable": 0
              },
              {
                "planet_id": 115,
                "name": "Space Shuttle 3",
                "description": "Up to 40 parcels at a time!",
                "star": 0,
                "enable": 0
              }
            ]
          },
          {
            "subsystem_id": 7,
            "subsytem_name": "Mission",
            "planet": [
              {
                "planet_id": 119,
                "name": "Hexcavations",
                "description": "Find the correct path for the equations!",
                "star": 0,
                "enable": 0
              },
              {
                "planet_id": 121,
                "name": "Orb Oracle",
                "description": "Figure out the pattern!",
                "star": 0,
                "enable": 0
              }
            ]
          }
        ]
      },
      {
        "system_id": 109,
        "name": "Time to Hours and Half Hours",
        "subsystem": [
          {
            "subsystem_id": 5,
            "subsytem_name": "Accuracy",
            "planet": [
              {
                "planet_id": 149,
                "name": "Tick Tock",
                "description": "How do you tell time?",
                "star": 0,
                "enable": 0
              }
            ]
          },
          {
            "subsystem_id": 7,
            "subsytem_name": "Mission",
            "planet": [
              {
                "planet_id": 151,
                "name": "Time Out!",
                "description": "What time is it?",
                "star": 0,
                "enable": 0
              }
            ]
          }
        ]
      },
      {
        "system_id": 204,
        "name": "Relating Addition to Multiplication",
        "subsystem": [
          {
            "subsystem_id": 4,
            "subsytem_name": "Skills",
            "planet": [
              {
                "planet_id": 120,
                "name": "Cell Cloning",
                "description": "How do you count multiples?",
                "star": 0,
                "enable": 0
              }
            ]
          },
          {
            "subsystem_id": 5,
            "subsytem_name": "Accuracy",
            "planet": [
              {
                "planet_id": 141,
                "name": "The 'Correct' Collector: Even or Odd?",
                "description": "Do you EVEN find it ODD?",
                "star": 0,
                "enable": 0
              }
            ]
          }
        ]
      }
      ...........................
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