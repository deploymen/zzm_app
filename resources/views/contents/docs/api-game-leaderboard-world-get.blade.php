@extends('layouts.master-docs', ['sidebar_item' => 'list-game'])

@section('breadcrumb')
<!--BEGIN TITLE & BREADCRUMB PAGE-->
<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left">
        <div class="page-title">GAME API</div>
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

<div class="row">
    <div class="col-lg-8">
        <h3>GET  /api/game/leaderboard/world</h3>
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
                        <td>X-game-code</td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
                <div style="margin-top:50px; height:500px; overflow:auto; font-size:12px">
<pre class="prettyprint">
GET http://www.zapzapmath.com/api/game/leaderboard/world HTTP/1.1
Host: www.zapzapmath.com
X-game-code: 0000015k
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
  "data": [
    {
      "id": "2",
      "rank": "1",
      "profile_id": "1",
      "first_name": "lai",
      "last_name": "weizhong",
      "score": "1000",
      "created_at": "2015-06-12 04:27:11",
      "updated_at": null,
      "deleted_at": null
    },
    {
      "id": "3",
      "rank": "1",
      "profile_id": "1",
      "first_name": "lai",
      "last_name": "weizhong",
      "score": "1000",
      "created_at": "2015-06-12 04:27:39",
      "updated_at": null,
      "deleted_at": null
    },
    {
      "id": "5",
      "rank": "2",
      "profile_id": "1",
      "first_name": "lai",
      "last_name": "weizhong",
      "score": "122",
      "created_at": "2015-06-12 04:28:23",
      "updated_at": null,
      "deleted_at": null
    },
    {
      "id": "1",
      "rank": "3",
      "profile_id": "1",
      "first_name": "lai",
      "last_name": "weizhong",
      "score": "108",
      "created_at": "2015-06-12 04:28:23",
      "updated_at": null,
      "deleted_at": null
    },
    {
      "id": "4",
      "rank": "3",
      "profile_id": "1",
      "first_name": "lai",
      "last_name": "weizhong",
      "score": "108",
      "created_at": "2015-06-12 04:28:23",
      "updated_at": null,
      "deleted_at": null
    },
    {
      "id": "6",
      "rank": "3",
      "profile_id": "1",
      "first_name": "lai",
      "last_name": "weizhong",
      "score": "108",
      "created_at": "2015-06-12 04:28:32",
      "updated_at": null,
      "deleted_at": null
    },
    {
      "id": "7",
      "rank": "3",
      "profile_id": "1",
      "first_name": "lai",
      "last_name": "weizhong",
      "score": "108",
      "created_at": "2015-06-12 04:30:17",
      "updated_at": null,
      "deleted_at": null
    }
  ]
}
</pre>
            </div>

        </div>
    </div>
    <!--END ROW -->
</div>

@stop