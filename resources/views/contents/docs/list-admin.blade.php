@extends('layouts.master-docs', ['sidebar_item' => 'list-admin'])

@section('breadcrumb')
<!--BEGIN TITLE & BREADCRUMB PAGE-->
<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left">
        <div class="page-title">ADMIN API</div>
    </div>
    <div class="clearfix"></div>
</div>
<!--END TITLE & BREADCRUMB PAGE-->
@stop

@section('css_include')

@stop

@section('js_include')

@stop

@section('content')

<table class="table table-bordered table-striped table-condensed cf">
    <thead class="cf">
        <tr>
            <th width="30">#</th>
            <th width="80">Method</th>
            <th width="370">Path</th>
            <th>Description</th>
            <th width="30">Action</th>
        </tr>
    </thead>
    <tbody>
       <!--  <tr>
            <td>1.</td>
            <td>GET</td>
            <td>/api/1.0/topics </td>
            <td>Get all Main Topics</td>
            <td align="center"><a href="api.topics-get.html"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>2.</td>
            <td>POST</td>
            <td>/api/1.0/topics </td>
            <td>Create a new Main Topic</td>
            <td align="center"><a href="api.topics-post.html"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>3.</td>
            <td>PUT</td>
            <td>/api/1.0/topics/{id} </td>
            <td>Edit a Main Topic</td>
            <td align="center"><a href="api.topics-id-put.html"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>4.</td>
            <td>DELETE</td>
            <td>/api/1.0/topics/{id} </td>
            <td>Delete a Main Topic</td>
            <td align="center"><a href="api.topics-id-delete.html"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>5.</td>
            <td>GET</td>
            <td>/api/1.0/topics/{id} </td>
            <td>Get Sub Topic that's under a particular Main Topic</td>
            <td align="center"><a href="api.topics-id-get.html"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>6.</td>
            <td>POST</td>
            <td>/api/1.0/topics/{id} </td>
            <td>Create a new Sub Topic of a Main Topic</td>
            <td align="center"><a href="api.topics-id-post.html"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>7.</td>
            <td>PUT</td>
            <td>/api/1.0/topics/{id}/{id2} </td>
            <td>Edit a Sub Topic</td>
            <td align="center"><a href="api.topics-ids-put.html"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>8.</td>
            <td>DELETE</td>
            <td>/api/1.0/topics/{id}/{id2} </td>
            <td>Delete a Sub Topic</td>
            <td align="center"><a href="api.topics-ids-delete.html"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr> -->
        <tr>
            <td>1.</td>
            <td>GET</td>
            <td>/api/1.0/system </td>
            <td></td>
            <td align="center"><a href="/api/docs/api.admin-system-get"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>2.</td>
            <td>POST</td>
            <td>/api/1.0/system </td>
            <td></td>
            <td align="center"><a href="/api/docs/api.admin-system-post"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>3.</td>
            <td>PUT</td>
            <td>/api/1.0/system/{id} </td>
            <td></td>
            <td align="center"><a href="/api/docs/api.admin-system-put"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>4.</td>
            <td>DELETE</td>
            <td>/api/1.0/system/{id} </td>
            <td></td>
            <td align="center"><a href="/api/docs/api.admin-system-delete"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>5.</td>
            <td>GET</td>
            <td>/api/1.0/planet </td>
            <td></td>
            <td align="center"><a href="/api/docs/api.admin-planet-get"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>6.</td>
            <td>POST</td>
            <td>/api/1.0/planet </td>
            <td></td>
            <td align="center"><a href="/api/docs/api.admin-planet-post"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>7.</td>
            <td>PUT</td>
            <td>/api/1.0/planet/{id} </td>
            <td></td>
            <td align="center"><a href="/api/docs/api.admin-planet-put"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>8.</td>
            <td>DELETE</td>
            <td>/api/1.0/planet/{id} </td>
            <td></td>
            <td align="center"><a href="/api/docs/api.admin-planet-delete"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>9.</td>
            <td>GET</td>
            <td>/api/1.0/question-bank </td>
            <td></td>
            <td align="center"><a href="/api/docs/api.admin-questbank-get"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>10.</td>
            <td>POST</td>
            <td>/api/1.0/question-bank </td>
            <td></td>
            <td align="center"><a href="/api/docs/api.admin-questbank-post"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>11.</td>
            <td>PUT</td>
            <td>/api/1.0/question-bank/{id} </td>
            <td></td>
            <td align="center"><a href="/api/docs/api.admin-questbank-put"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
        <tr>
            <td>12.</td>
            <td>DELETE</td>
            <td>/api/1.0/question-bank/{id} </td>
            <td></td>
            <td align="center"><a href="/api/docs/api.admin-questbank-delete"><i class="fa fa-chevron-circle-right" style="font-size: 20px;"></i></a></td>
        </tr>
    </tbody>
</table>

@stop