@extends('layouts.docs-page', ['sidebar_item' => 'list-admin'])

@section('title', 'DELETE /api/system/{id}')

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
<pre class="prettyprint">DELETE http://local.zapzapmath.com/api/system/1 HTTP/1.1
Host: local.zapzapmath.com
X-access-token: 12
Cookie: __utmx=208893977.e5U6QuyaSKqesLvm_jKPxw$99127049-0:1; __utmxx=208893977.e5U6QuyaSKqesLvm_jKPxw$99127049-0:1428307792:15552000; access_token=12; laravel_session=eyJpdiI6IkVTY0RIMXQrQ0pPN2o1alE0NE92TGc9PSIsInZhbHVlIjoiUzhXVksrZDhOa1BxM0w3clNwOXpcLzZBSWpRTVR5YWhtdFRTcFl1WmI2UTNJQTg0eXMzRlhoK2hNSDJPU1R0MEJuTW9IdTVmWmFyVHdVOHl2UEtWV25BPT0iLCJtYWMiOiJkZmQzMmU5NTI4MGQ1ODA0OTE3OGZlZTA4NjNjM2VmNWU3YTJmMDhjNDY2ZTkxMGZjYjNkNzVlZjNjMTZkMTVkIn0%3D; _gat=1; _ga=GA1.2.1098556987.1429157607
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