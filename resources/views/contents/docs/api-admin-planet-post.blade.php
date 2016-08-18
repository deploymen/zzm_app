@extends('layouts.docs-page', ['sidebar_item' => 'list-admin'])

@section('title', 'POST  /api/planet')

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
        <td>game_type_id</td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>type</td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>name</td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>question_count</td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>question_random</td>
        <td></td>
        <td>default = 1</td>
    </tr>
    <tr>
        <td>enable</td>
        <td></td>
        <td>default = 1</td>
    </tr>
</table>
<div style="margin-top:50px; height:500px; overflow:auto; font-size:12px">
    <pre class="prettyprint">POST http://local.zapzapmath.com/api/planet HTTP/1.1
Host: local.zapzapmath.com
X-access-token: 12
Cookie: __utmx=208893977.e5U6QuyaSKqesLvm_jKPxw$99127049-0:1; __utmxx=208893977.e5U6QuyaSKqesLvm_jKPxw$99127049-0:1428307792:15552000; _ga=GA1.2.1098556987.1429157607; access_token=12; laravel_session=eyJpdiI6IktSa3ZRZFFkZytBODBZVXo5eFV6bWc9PSIsInZhbHVlIjoiT1VvUnZXb0VKZHluMjdVdnJQM0x5d0dwa3JKa2R5OG1SQ2djbGswTktCMlpzQW9EY01ROEFtUlk5WUFvM1RLWlZZOGE2aVZjMFUxbGlWbERnQTBRTmc9PSIsIm1hYyI6IjEzMDEyZGM1NjZkNjdkMmE3MzMzNWVjNzU3NjBjYTU1YzdiZGU2NTI0NTlhZDg0OTJjYmMwODFkMGQyOTM5ODQifQ==

game_type_id=1&type=2&name=test planet 10&question_count=15&question_random=&enable=
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
  "status": "success"
} 
</pre>
@stop