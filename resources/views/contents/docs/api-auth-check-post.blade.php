@extends('layouts.docs-page', ['sidebar_item' => 'list-general'])

@section('title', 'POST  /api/auth/check')

@section('desc')
<p>
    For client side to check an access token's status. Normally only web client use it.
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
        <td>user_id</td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>user_name</td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>user_role</td>
        <td></td>
        <td></td>
    </tr>
</table>
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