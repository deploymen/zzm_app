@extends('layouts.master-docs', ['sidebar_item' => 'list-user']) 

@section('breadcrumb')
<!--BEGIN TITLE & BREADCRUMB PAGE-->
<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left">
        <div class="page-title">USER API</div>
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

<h3>GET   /api/1.0/class</h3>
<ul id="myTab" class="nav nav-tabs">
    <li class="active"><a href="#descriptions" data-toggle="tab">Explain</a>
    </li>
    <li><a href="#request" data-toggle="tab">Request</a>
    </li>
    <li><a href="#respone" data-toggle="tab">Response</a>
    </li>

</ul>
<div id="myTabContent" class="tab-content">
    <div id="descriptions" class="tab-pane fade in active">
        <p>

        </p>
    </div>
    <div id="request" class="tab-pane fade">
        <p>Header</p>
        <table class="table table-striped table-bordered table-hover">
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
        <div style="margin-top:50px; height:500px; overflow:auto; font-size:12px">
            <pre class="prettyprint">GET http://staging.zapzapmath.com/api/1.0/class HTTP/1.1
Host: staging.zapzapmath.com
X-access-token: 1234
            </pre>
        </div>
    </div>

    <div id="respone" class="tab-pane fade">
        <table class="table table-striped table-bordered table-hover">
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
    "game_class": [
      {
        "id": 1,
        "user_id": 2,
        "name": "Class 2",
        "created_at": "2015-11-26 13:19:56",
        "updated_at": "2015-11-26 13:28:42",
        "deleted_at": null
      }
    ]
  }
}
        </pre>
    </div>

</div>

@stop
