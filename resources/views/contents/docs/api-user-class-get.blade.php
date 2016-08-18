@extends('layouts.docs-page', ['sidebar_item' => 'list-user'])

@section('title', 'GET   /api/1.0/class')

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
<div style="margin-top:50px; height:500px; overflow:auto; font-size:12px">
    <pre class="prettyprint">GET http://staging.zapzapmath.com/api/1.0/class HTTP/1.1
Host: staging.zapzapmath.com
X-access-token: 1234
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
    "game_class": [
      {
        "id": 1,
        "user_id": 2,
        "name": "Class 2",
        "created_at": "2015-11-26 13:19:56",
        "updated_at": "2015-11-26 13:28:42",
        "deleted_at": null
      }
    ]
  }
}
</pre>
@stop