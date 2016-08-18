@extends('layouts.docs-page', ['sidebar_item' => 'list-admin'])

@section('title', 'GET   /api/planet/{id}')

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
<p>INPUT</p>
<table class="hover">
    <tr>
        <th style="width:175px;">Key</th>
        <th style="width:500px;">Description</th>
        <th style="width:360px;">Example</th>
    </tr>
    <tr>
        <td>id(URL)</td>
        <td></td>
        <td></td>
    </tr>
</table>
<div style="margin-top:50px; height:500px; overflow:auto; font-size:12px">
    <pre class="prettyprint">GET http://local.zapzapmath.com/api/planet/2 HTTP/1.1
Host: local.zapzapmath.com
X-access-token: 12
Cookie: __utmx=208893977.e5U6QuyaSKqesLvm_jKPxw$99127049-0:1; __utmxx=208893977.e5U6QuyaSKqesLvm_jKPxw$99127049-0:1428307792:15552000; _ga=GA1.2.1098556987.1429157607; access_token=12; laravel_session=eyJpdiI6ImNqYytxdGpSNEFvSlwvQlJubnlsbFJRPT0iLCJ2YWx1ZSI6IjArOHlCOVZaUVhyRzlPMW9IdFgyK21uVlFnXC9YaEc0UUVhdkdXXC9DNTRRUzVBd0MyN21sRTNIc1NzcElUT1dyVys5ZTFDMzNXTWtHYUVLUVJ0WEpIWEE9PSIsIm1hYyI6IjRmOGZhMmE4YmUyODg4MWEzMzRjYzQxNDBjZWUxMGUyYTlmZmJiMWM4ZTk3NjE2MGJhZDMxODZkMzE2OWI3NjgifQ%3D%3D
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
    "list": [
      {
        "id": 6,
        "game_type_id": 1,
        "type": "quiz",
        "name": "11111",
        "question_count": 50,
        "question_random": 0,
        "enable": 0,
        "created_at": "2015-04-16 18:26:46",
        "updated_at": "2015-04-16 18:56:05",
        "deleted_at": null
      },
      {
        "id": 12,
        "game_type_id": 1,
        "type": "quiz",
        "name": "plant 10",
        "question_count": 10,
        "question_random": 0,
        "enable": 0,
        "created_at": "2015-04-16 19:01:28",
        "updated_at": "2015-04-16 19:01:28",
        "deleted_at": null
      },
      {
        "id": 13,
        "game_type_id": 1,
        "type": "game",
        "name": "create test 1",
        "question_count": 15,
        "question_random": 1,
        "enable": 1,
        "created_at": "2015-04-17 10:35:26",
        "updated_at": "2015-04-17 10:35:26",
        "deleted_at": null
      }
    ]
  }
}
</pre>
@stop