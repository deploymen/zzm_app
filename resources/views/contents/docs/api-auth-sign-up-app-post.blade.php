@extends('layouts.docs-page', ['sidebar_item' => 'list-general'])

@section('title', 'POST  /api/game/sign-up')

@section('desc')
<p>For user to sign up in App(register)</p>
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
        <td>email</td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>first_name</td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>last_name</td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>deviceId</td>
        <td></td>
        <td></td>
    </tr>
</table>
<div style="margin-top:50px; height:500px; overflow:auto; font-size:12px">
    <pre class="prettyprint">
POST http://staging.zapzapmath.com/api/1.0/game/sign-up HTTP/1.1

{"status":"success","data":"000000o0"}
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
    status: "success"
    data: "000000o0"
}
</pre>
@stop