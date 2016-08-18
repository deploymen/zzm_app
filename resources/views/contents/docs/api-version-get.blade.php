@extends('layouts.docs-page', ['sidebar_item' => 'list-general'])

@section('title', 'GET  /api/version')

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
        <td>device</td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>version</td>
        <td></td>
        <td></td>
    </tr>
</table>
<div style="margin-top:50px; height:500px; overflow:auto; font-size:12px">
    <pre class="prettyprint">
                        POST http://staging.zapzapmath.com/api/version HTTP/1.1
                        Host: staging.zapzapmath.com

                        device_os=ios-1&zzm_version=1.0
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
        "version": 1.0
        "end_point": "http://staging.zapzapmath.com/api/1.0"
    }
}
</pre>
@stop