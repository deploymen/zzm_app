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
        <h3>GET  /api/game/user-map</h3>
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
GET http://www.zapzapmath.com/api/game/user-map HTTP/1.1
Host: www.zapzapmath.com
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
  "data": [
    {
      "system_id": 1001,
      "name": "grade 1",
      "planets": [
        {
          "planet_id": 102,
          "name": "The 'Correct' Collector",
          "description": "Yes? No?",
          "star": 0,
          "subjects": [
            {
              "id": "1",
              "code": "c.0.1"
            }
          ],
          "enable": 1
        },
        {
          "planet_id": 103,
          "name": "Space Taxi",
          "description": "What + What = What??",
          "star": 0,
          "subjects": [
            {
              "id": "1",
              "code": "c.0.1"
            }
          ],
          "enable": 0
        },
        {
          "planet_id": 104,
          "name": "Word Games",
          "description": "What's your (word) problem?",
          "star": 0,
          "subjects": [
            {
              "id": "1",
              "code": "c.0.1"
            }
          ],
          "enable": 0
        },
        {
          "planet_id": 105,
          "name": "Tap Tens",
          "description": "How many ones are in a ten?",
          "star": 0,
          "subjects": [
            {
              "id": "1",
              "code": "c.0.1"
            }
          ],
          "enable": 0
        },
        {
          "planet_id": 106,
          "name": "Space Taxi 2",
          "description": "Get up to 20 passengers!",
          "star": 0,
          "subjects": [
            {
              "id": "1",
              "code": "c.0.1"
            }
          ],
          "enable": 0
        }
      ]
    },
    {
      "system_id": 1002,
      "name": "grade 2",
      "planets": [
        {
          "planet_id": 114,
          "name": "More or Less?",
          "description": ">=<",
          "star": 0,
          "subjects": [
            {
              "id": "1",
              "code": "c.0.1"
            }
          ],
          "enable": 0
        },
        {
          "planet_id": 115,
          "name": "Space Taxi 3",
          "description": "Up to 40 passengers at a time!",
          "star": 0,
          "subjects": [
            {
              "id": "1",
              "code": "c.0.1"
            }
          ],
          "enable": 0
        }
      ]
    },
    {
      "system_id": 108,
      "name": " Lengths",
      "planets": [
        {
          "planet_id": 129,
          "name": "Engine Engine Number Line",
          "description": "Number line, number line",
          "star": 0,
          "subjects": [
            {
              "id": "1",
              "code": "c.0.1"
            }
          ],
          "enable": 0
        }
      ]
    },
    {
      "system_id": 112,
      "name": " Foundation for Multiplication & Division",
      "planets": [
        {
          "planet_id": 141,
          "name": "The 'Correct' Collector 2",
          "description": "Do you EVEN find it ODD?",
          "star": 0,
          "subjects": [
            {
              "id": "1",
              "code": "c.0.1"
            }
          ],
          "enable": 0
        }
      ]
    },
    {
      "system_id": 1002,
      "name": "grade 2",
      "planets": [
        {
          "planet_id": 150,
          "name": "Sushi Star: Sushimetry 3",
          "description": "Know your ingredients!",
          "star": 0,
          "subjects": [
            {
              "id": "1",
              "code": "c.0.1"
            }
          ],
          "enable": 0
        }
      ]
    },
    {
      "system_id": 1003,
      "name": "grade 3",
      "planets": [
        {
          "planet_id": 155,
          "name": "Word Games 10",
          "description": "Do you divide or multiply?",
          "star": 0,
          "subjects": [
            {
              "id": "1",
              "code": "c.0.1"
            }
          ],
          "enable": 0
        },
        {
          "planet_id": 166,
          "name": "The Big Showdown",
          "description": "Which piece fits?",
          "star": 0,
          "subjects": [
            {
              "id": "1",
              "code": "c.0.1"
            }
          ],
          "enable": 0
        }
      ]
    },
    {
      "system_id": 125,
      "name": " Angles and Planes",
      "planets": [
        {
          "planet_id": 185,
          "name": "measure angles with a protractor",
          "description": "",
          "star": 3,
          "subjects": [
            {
              "id": "1",
              "code": "c.0.1"
            }
          ],
          "enable": 0
        }
      ]
    }
  ]
}
</pre>
            </div>

        </div>
    </div>
    <!--END ROW -->
</div>

@stop