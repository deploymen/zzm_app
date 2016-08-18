@extends('layouts.docs-page', ['sidebar_item' => 'list-game'])

@section('title', 'GET   /api/game/result/system-planet/progress')

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
    <pre class="prettyprint">GET http://staging.zapzapmath.com/api/game/result/system-planet/progress HTTP/1.1
X-game-code: 0000014n
Cookie: _gat=1; _ga=GA1.2.238970283.1430284975; laravel_session=eyJpdiI6IkR0TWdMMTJyeHk3TlltWStPTVQrR3c9PSIsInZhbHVlIjoiUVg5TFpLR1VGdFNGU1FWd2JzQ0F4N2RIMkhQdlwvXC94MXNUMlZwQVBiTUNKT25FeTF1WnN0MEcyTDI3MVZZTXFKTU9CZDRnSm4rYnpGdWpsbXliXC9qa2c9PSIsIm1hYyI6IjAzYmM0MDNmZWEwMGZlOTA1YmMyZGE0OTMxYWY2YzkwNDQ2YjRhYjgxNzhkY2E5YzUxYjc3ODQ2MDBiNzJhYzIifQ%3D%3D
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
@stop