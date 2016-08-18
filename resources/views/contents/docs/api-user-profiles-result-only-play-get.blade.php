@extends('layouts.docs-page', ['sidebar_item' => 'list-user'])

@section('title', 'GET   /api/profiles/result/only-play')

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
        <td>X-access-token</td>
        <td></td>
        <td></td>
    </tr>
</table>
<table class="hover">
    <tr>
        <th style="width:175px;">Key</th>
        <th style="width:500px;">Description</th>
        <th style="width:360px;">Example</th>
    </tr>
    <tr>
        <td>profile_id</td>
        <td></td>
        <td></td> 
    </tr>
    <tr>
        <td>planet_id</td>
        <td></td>
        <td></td> 
    </tr>
</table>
<div style="margin-top:50px; height:500px; overflow:auto; font-size:12px">
    <pre class="prettyprint">
GET http://dev.zapzapmath.com/api/profiles/result/only-play?profile_id=1&planet_id=166 HTTP/1.1
Host: dev.zapzapmath.com
X-access-token: 1|4db2af27acb0da7dd5fce6e45c54416a59b7ddcc
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
    "play": [
      {
        "id": 2,
        "planet_id": 166,
        "score": 108,
        "status": "pass",
        "target_type": "p03",
        "played": "1",
        "play_time": "2015-07-09 14:22:23"
      }
    ],
    "breakcrumb": {
      "system_id": 1003,
      "system_name": "grade 3",
      "planet_id": "166",
      "planet_subtitle": "Which piece fits?"
    },
    "page": "1",
    "page_size": "30",
    "pageTotal": 2
  }
}
</pre>
@stop