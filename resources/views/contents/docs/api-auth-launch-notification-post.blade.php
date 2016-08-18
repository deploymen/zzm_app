@extends('layouts.docs-page', ['sidebar_item' => 'list-general'])

@section('title', 'POST  /api/launch-notification')

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
        <td>email</td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>news_letter</td>
        <td></td>
        <td>1/0</td>
    </tr>
    <tr>
        <td>launch_notified</td>
        <td></td>
        <td>1/0</td>
    </tr>
</table>
<div style="margin-top:50px; height:500px; overflow:auto; font-size:12px">
    <pre class="prettyprint">
        POST http://staging.zapzapmath.com/api/1.0/launch-notification?news_letter=1&launch_notified=1 HTTP/1.1
        Host: staging.zapzapmath.com

        email=weizhonglai0108%40gmail.com
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