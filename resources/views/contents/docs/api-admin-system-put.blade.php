@extends('layouts.docs-page', ['sidebar_item' => 'list-admin'])

@section('title', 'PUT   /api/system/{id}')

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
    <tr>
        <td>name</td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>sequence</td>
        <td></td>
        <td>Default: 999999</td>
    </tr>
    <tr>
        <td>topic_main_id</td>
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
    <pre class="prettyprint">PUT http://local.zapzapmath.com/api/system/3 HTTP/1.1
Host: local.zapzapmath.com
X-access-token: 12
Cookie: __utmx=208893977.e5U6QuyaSKqesLvm_jKPxw$99127049-0:1; __utmxx=208893977.e5U6QuyaSKqesLvm_jKPxw$99127049-0:1428307792:15552000; access_token=12; _ga=GA1.2.1098556987.1429157607; laravel_session=eyJpdiI6IlZjZE9yK2FUbkJPcHJLK0s2TGVOUnc9PSIsInZhbHVlIjoiaFhNQkMrcHc0N1dtZGxmY1Z5UWtUVHJIRFdjb1B4aExlM0diV1dSN2NCeStTcmp6a3JleDdMdmtjUFNMQ0FLZ1NBMFRcL2NxNUhldXNPeUwxYzlsV2VBPT0iLCJtYWMiOiJlZWVlOGE4OTNhMDRjYTQ0M2JjMmNiNTkzYTI2M2RhM2UzYTZkZjYwZDVjMDVkOGRhOGY2MjJjMWU0MTcxMTRkIn0%3D

name=system+100&topic_main_id=1
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
    "id": 3,
    "topic_main_id": "1",
    "name": "system 100",
    "sequence": 999999,
    "enable": 1,
    "created_at": "2015-04-16 16:35:07",
    "updated_at": "2015-04-20 12:53:31",
    "deleted_at": null
  }
}
</pre>
@stop