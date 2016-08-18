@extends('layouts.docs-page', ['sidebar_item' => 'list-admin'])

@section('title', 'PUT   /api/planet/{id}')

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
        <td></td>
    </tr>
    <tr>
        <td>enable</td>
        <td></td>
        <td></td>
    </tr>
</table>
<div style="margin-top:50px; height:500px; overflow:auto; font-size:12px">
    <pre class="prettyprint">PUT http://local.zapzapmath.com/api/planet/12 HTTP/1.1
Host: local.zapzapmath.com
X-access-token: 12
Cookie: __utmx=208893977.e5U6QuyaSKqesLvm_jKPxw$99127049-0:1; __utmxx=208893977.e5U6QuyaSKqesLvm_jKPxw$99127049-0:1428307792:15552000; _ga=GA1.2.1098556987.1429157607; access_token=12; laravel_session=eyJpdiI6IlU0Sm1LZ0ltWUJNeU9JemJRNzR2RHc9PSIsInZhbHVlIjoiTW9WU1RmQ24wSjIzcXNOOWZXcGRcL3ByMWtVT1Z4SlFhdUxZR1hCSTNJbnBKdm1OVmV1MTVIYlwvVmNYZGJPVzhza3BtQnZheUR1QkI4S3ZNY2pTK3lxdz09IiwibWFjIjoiMWVkNmEzOTk4ZThlNzI1MWFlMzMzYThjMjZmYjVjZGZjMGI3NGVlY2JhNDYwODgyMzI4NGE0ZWVkZjcyZGRmZiJ9

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
@stop