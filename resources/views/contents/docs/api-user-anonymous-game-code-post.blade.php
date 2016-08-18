@extends('layouts.docs-page', ['sidebar_item' => 'list-user'])

@section('title', 'POST   api/game-code/anonymous')

@section('desc')
<p>

</p>
@stop

@section('req')
<p>INPUT</p>
<table class="hover">
    <tr>
        <th style="width:175px;">Key</th>
        <th style="width:500px;">Description</th>
        <th style="width:360px;">Example</th>
    </tr>
    <tr>
        <td>device_id</td>
        <td></td>
        <td></td>
    </tr>
</table>
<div style="margin-top:50px; height:500px; overflow:auto; font-size:12px">
    <pre class="prettyprint">POST http://staging.zapzapmath.com/api/game-code/anonymous HTTP/1.1
Host: staging.zapzapmath.com
Cookie: __utmx=208893977.kkr4s3aaRwa7IjcDX5IuXg$99127049-2:0; __utmxx=208893977.kkr4s3aaRwa7IjcDX5IuXg$99127049-2:1432609909:15552000; __utmx=204351314.kkr4s3aaRwa7IjcDX5IuXg$99127049-2:0; __utmxx=204351314.kkr4s3aaRwa7IjcDX5IuXg$99127049-2:1432610057:15552000; viewedOuibounceModal=true; _ga=GA1.2.238970283.1430284975; laravel_session=eyJpdiI6ImN6cGN5Tkk5OU02WGM2YXM5UzVBelE9PSIsInZhbHVlIjoiYzFkR3BWREVGSzg5U0p3bTNyZ051aWwzdGdUNHl4S2d3SnF1bWF6eUxQbHY5RVp6R3Z3XC85bXp3cDg5MGVTREk2RXZNM1wvaHBha05qTVwveFE1SlZoSEE9PSIsIm1hYyI6ImYzYTQ0YzliOTAzMDIzOTkzNThkMDMxYWQ1ZDFlNTc0YWMxZjQ0MDVjMjI5ZmVkMTgzNDM3N2RlZmQ4YTQyZTkifQ%3D%3D

device_id=ak55a4w78vx4a12c
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
    "game-code": "000002sm"
  }
}
</pre>
@stop