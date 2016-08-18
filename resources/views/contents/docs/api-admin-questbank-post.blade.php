@extends('layouts.docs-page', ['sidebar_item' => 'list-admin'])

@section('title', 'POST  /api/question-bank')

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
        <td>topic_main_id</td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>topic_sub_id</td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>question</td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>answer</td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>enable</td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>answer_option_1</td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>answer_option_2</td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>answer_option_3</td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>answer_option_4</td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>answer_option_5</td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>answer_option_6</td>
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