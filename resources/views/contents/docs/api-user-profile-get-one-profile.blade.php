@extends('layouts.docs-page', ['sidebar_item' => 'list-user'])

@section('title', 'GET   /api/profiles/{id}')

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
        <td>id</td>
        <td></td>
        <td></td>
    </tr>
</table>
<div style="margin-top:50px; height:500px; overflow:auto; font-size:12px">
    <pre class="prettyprint">GET http://staging.zapzapmath.com/api/profiles/1 HTTP/1.1
Host: staging.zapzapmath.com
X-access-token: 1|92b943b0ff3ffe4ff943f448d30eb5a0ff7ef7e9
Cookie: __utmx=208893977.kkr4s3aaRwa7IjcDX5IuXg$99127049-2:0; __utmxx=208893977.kkr4s3aaRwa7IjcDX5IuXg$99127049-2:1431580824:15552000; __utmx=204351314.kkr4s3aaRwa7IjcDX5IuXg$99127049-2:0; __utmxx=204351314.kkr4s3aaRwa7IjcDX5IuXg$99127049-2:1431584530:15552000; _ga=GA1.2.238970283.1430284975; laravel_session=eyJpdiI6IkRVeVNJV2ZJNXZ0MDZ1ZnlhUFNcL3FnPT0iLCJ2YWx1ZSI6InQyb1JMMHZVMGVpNjh6OUFyWmlqTTlyTlFVTWhOT1BiNCtNakpBNWVhQWtkNklIeFR3blltUEM0RDZpMGFudmh5dkhpU3N5b2ZxaEhUYnBqRmowaHh3PT0iLCJtYWMiOiI0YzQ4MjI2MzdmM2ZmNzZhZDE4MTIxMDc0ZjE4N2I1NGFhM2RlZjljYjY1NDczZjYwYjVkNDBkOGUwMTY2YjQyIn0%3D
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
    "profile": {
      "id": "1",
      "user_id": "1",
      "class_id": "1",
      "first_name": "lai",
      "last_name": "weizhong",
      "school": "123456789",
      "city": "BM",
      "email": "weizhong@gmail.com",
      "nickname1": "1",
      "nickname2": "2",
      "avatar_id": "1",
      "nick_name1": {
        "id": "1",
        "name": "Mozviss"
      },
      "nick_name2": {
        "id": "2",
        "name": "Vaais"
      },
      "avatar": {
        "id": "1",
        "name": "_blank",
        "filename": "_blank.jpg"
      },
      "game_code": {
        "id": "1",
        "type": "profile",
        "code": "0000014n",
        "seed": "40",
        "profile_id": "1",
        "device_id": null,
        "quiz_id": null,
        "class_id": null,
        "enable": "1",
        "created_at": "2015-04-22 13:40:04",
        "updated_at": "2015-04-22 13:40:04",
        "deleted_at": null
      }
    }
  }
}
</pre>
@stop