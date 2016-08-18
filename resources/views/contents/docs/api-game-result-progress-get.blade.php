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

<h3>GET   /api/game/result/system-planet/progress</h3>
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
            <pre class="prettyprint">GET http://staging.zapzapmath.com/api/game/result/system-planet/progress HTTP/1.1
X-game-code: 0000014n
Cookie: _gat=1; _ga=GA1.2.238970283.1430284975; laravel_session=eyJpdiI6IkR0TWdMMTJyeHk3TlltWStPTVQrR3c9PSIsInZhbHVlIjoiUVg5TFpLR1VGdFNGU1FWd2JzQ0F4N2RIMkhQdlwvXC94MXNUMlZwQVBiTUNKT25FeTF1WnN0MEcyTDI3MVZZTXFKTU9CZDRnSm4rYnpGdWpsbXliXC9qa2c9PSIsIm1hYyI6IjAzYmM0MDNmZWEwMGZlOTA1YmMyZGE0OTMxYWY2YzkwNDQ2YjRhYjgxNzhkY2E5YzUxYjc3ODQ2MDBiNzJhYzIifQ%3D%3D
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
      "system_name": "s1",
      "planet_name": "p1",
      "sequence": 1,
      "COUNT(gp.`id`)": 0,
      "MAX(gp.`score`)": null
    },
    {
      "system_name": "s1",
      "planet_name": "p2",
      "sequence": 2,
      "COUNT(gp.`id`)": 0,
      "MAX(gp.`score`)": null
    },
    {
      "system_name": "s2",
      "planet_name": "p3",
      "sequence": 1,
      "COUNT(gp.`id`)": 0,
      "MAX(gp.`score`)": null
    },
    {
      "system_name": "s2",
      "planet_name": "p4",
      "sequence": 2,
      "COUNT(gp.`id`)": 0,
      "MAX(gp.`score`)": null
    },
    {
      "system_name": "s3",
      "planet_name": "p5",
      "sequence": 1,
      "COUNT(gp.`id`)": 0,
      "MAX(gp.`score`)": null
    },
    {
      "system_name": "s3",
      "planet_name": "p6",
      "sequence": 2,
      "COUNT(gp.`id`)": 3,
      "MAX(gp.`score`)": 92
    }
  ]
}
        </pre>
    </div>

</div>

@stop