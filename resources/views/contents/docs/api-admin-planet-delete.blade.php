@extends('layouts.docs-page', ['sidebar_item' => 'list-admin'])

@section('title', 'DELETE /api/planet/{id}')

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
<pre class="prettyprint">DELETE http://local.zapzapmath.com/api/planet/9 HTTP/1.1
Host: local.zapzapmath.com
X-access-token: 12
Cookie: __utmx=208893977.e5U6QuyaSKqesLvm_jKPxw$99127049-0:1; __utmxx=208893977.e5U6QuyaSKqesLvm_jKPxw$99127049-0:1428307792:15552000; _ga=GA1.2.1098556987.1429157607; access_token=12; laravel_session=eyJpdiI6ImdIZnpcL2htTFQxUXpJdVZVXC9uc2F2Zz09IiwidmFsdWUiOiJMbW16QWF2T0g4NFhoQXJMcUY4ZmNQZmRORHAwTjM1QzdJUlJKem5JalR1eGphRFJQa0V6aFR0SkcrcU83Y2JlQUZQTmtCVXZDa2ZiTnBJTjNzMFwvZVE9PSIsIm1hYyI6IjNhODRkZjhjNjdlNjA5NTY0OGM1OWQyOGZlOTFjMmQ2NjdmZjdhZjY1MzA0MzA4OWI0NTgxMDI5Mjc4YWFiMGEifQ%3D%3D
</pre>
<div style="margin-top:50px; height:500px; overflow:auto; font-size:12px">
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