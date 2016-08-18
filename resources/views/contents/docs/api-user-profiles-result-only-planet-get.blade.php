@extends('layouts.docs-page', ['sidebar_item' => 'list-user'])

@section('title', 'GET   /api/profiles/result/only-planet')

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
        <td>system_id</td>
        <td></td>
        <td></td> 
    </tr>
</table>
<div style="margin-top:50px; height:500px; overflow:auto; font-size:12px">
    <pre class="prettyprint">
GET http://dev.zapzapmath.com/api/profiles/result/only-planet?profile_id=1&system_id=1001 HTTP/1.1
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
    "planet": [
      {
        "id": 102,
        "subtitle": "Yes? No?",
        "play_count": 0,
        "star": "0",
        "max_score": 0,
        "played": "1"
      },
      {
        "id": 103,
        "subtitle": "What + What = What??",
        "play_count": 1,
        "star": "1",
        "max_score": 108,
        "played": "1"
      },
      {
        "id": 104,
        "subtitle": "What's your (word) problem?",
        "play_count": 0,
        "star": "0",
        "max_score": 0,
        "played": "1"
      },
      {
        "id": 105,
        "subtitle": "How many ones are in a ten?",
        "play_count": 1,
        "star": "1",
        "max_score": 100,
        "played": "1"
      },
      {
        "id": 106,
        "subtitle": "Get up to 20 passengers!",
        "play_count": 0,
        "star": "0",
        "max_score": 0,
        "played": "1"
      }
    ],
    "breakcrumb": {
      "system_id": "1001",
      "system_name": "grade 1"
    },
    "page": "1",
    "page_size": "30",
    "pageTotal": 2
  }
}
</pre>
@stop