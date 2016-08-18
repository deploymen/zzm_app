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

<h3>POST   /api/game/verify-code</h3>
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
            This api is for game landing screen. It trigger when user key in game code to proceed. Api will return profile_transfer=1 if there's anonymous game history, expect game client will prompt user to do profile transfer(PT) or not.
        </p>
    </div>
    <div id="request" class="tab-pane fade">
        <p>INPUT</p>
        <table class="table table-striped table-bordered table-hover">
            <tr>
                <th style="width:175px;">Key</th>
                <th style="width:500px;">Description</th>
                <th style="width:360px;">Example</th>
            </tr>
            <tr>
                <td>game_code</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>game_code_anonymous</td>
                <td></td>
                <td></td>
            </tr>
        </table>
        <div style="margin-top:50px; height:500px; overflow:auto; font-size:12px">
            <pre class="prettyprint">POST http://staging.zapzapmath.com/api/game/verify-code HTTP/1.1
Host: staging.zapzapmath.com

game_code=1&game_code_anonymous=5
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
    "profile_transfer": "0",
    "profile": {
      "id": 1,
      "user_id": 1,
      "class_id": 0,
      "first_name": "Profile",
      "last_name": "1",
      "school": "",
      "city": "",
      "email": null,
      "nickname1": 1,
      "nickname2": 1,
      "avatar_id": 1,
      "created_at": "2015-06-02 13:05:26",
      "updated_at": "2015-06-02 13:05:26",
      "deleted_at": null
    }
  }
}
        </pre>
    </div>

</div>

@stop
