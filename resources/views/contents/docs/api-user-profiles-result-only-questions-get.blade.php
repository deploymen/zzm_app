@extends('layouts.docs-page', ['sidebar_item' => 'list-user'])

@section('title', 'GET   /api/profiles/result/only-questions')

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
        <td>play_id</td>
        <td></td>
        <td></td> 
    </tr>
</table>
<div style="margin-top:50px; height:500px; overflow:auto; font-size:12px">
    <pre class="prettyprint">
GET http://dev.zapzapmath.com/api/profiles/result/only-questions?profile_id=1&play_id=1 HTTP/1.1
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
    "questions": [
      
    ],
    "breakcrumb": {
      "system_id": 108,
      "system_name": " Lengths",
      "planet_id": 129,
      "planet_subtitle": "Number line, number line",
      "play_id": "1"
    },
    "page": "1",
    "page_size": "30",
    "pageTotal": 2
  }
}
</pre>
@stop