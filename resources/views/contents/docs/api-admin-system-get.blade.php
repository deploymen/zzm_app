@extends('layouts.docs-page', ['sidebar_item' => 'list-admin'])

@section('title', 'GET   /api/system')

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
</table>
<div style="margin-top:50px; height:500px; overflow:auto; font-size:12px">
    <pre class="prettyprint">GET http://local.zapzapmath.com/api/system HTTP/1.1
Host: local.zapzapmath.com
X-access-token: 12
Cookie: __utmx=208893977.e5U6QuyaSKqesLvm_jKPxw$99127049-0:1; __utmxx=208893977.e5U6QuyaSKqesLvm_jKPxw$99127049-0:1428307792:15552000; access_token=12; _ga=GA1.2.1098556987.1429157607; laravel_session=eyJpdiI6ImJOb2ErTUZSVkVoWjBkT2ZnaUVKN2c9PSIsInZhbHVlIjoiaVNQU1hpUlwvd3c3dWM4dDdFcCtjQzNwaE1cL3BPUDVhSFRVNUtENVJsUlNTTjd0YVwvd0NReXh3MzhpXC9kd0k3aCtiMDdrbkprR1M1R1VvMjFKYWVqMGRnPT0iLCJtYWMiOiJmZjdiZjZhNTQ2NmMzYTUwMGMzNmMxMmM5ZDAwYjdmNjA2ZmE0YmEyYmQ3YWM5Yzg0OWM5NTdhOTIyM2JkODVmIn0%3D
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
    "main": [
      {
        "topic_main_id": 2,
        "name": "system 2",
        "sequence": 999999
      },
      {
        "topic_main_id": 3,
        "name": "system 3",
        "sequence": 999999
      }
    ]
  }
}
</pre>
@stop