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

<h3>POST  /api/system</h3>
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
        <p>INPUT</p>
        <table class="table table-striped table-bordered table-hover">
            <tr>
                <th style="width:175px;">Key</th>
                <th style="width:500px;">Description</th>
                <th style="width:360px;">Example</th>
            </tr>
            <tr>
                <td>name</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>sequence</td>
                <td></td>
                <td>Default: 999999</td>
            </tr>
            <tr>
                <td>topic_main_id</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>enable</td>
                <td></td>
                <td>default = 1</td>
            </tr>
        </table>
        <div style="margin-top:50px; height:500px; overflow:auto; font-size:12px">
            <pre class="prettyprint">POST http://local.zapzapmath.com/api/system HTTP/1.1
Host: local.zapzapmath.com
X-access-token: 12
Cookie: __utmx=208893977.e5U6QuyaSKqesLvm_jKPxw$99127049-0:1; __utmxx=208893977.e5U6QuyaSKqesLvm_jKPxw$99127049-0:1428307792:15552000; access_token=12; _ga=GA1.2.1098556987.1429157607; laravel_session=eyJpdiI6ImZmODdFcWJOcnZucjEyak4rWEhOS3c9PSIsInZhbHVlIjoiZmdwVFdkYk8yWW9rdVBZbmQ2azJ6UUlrbzdrSTZrcjRYMSt4OHA0QmZhcHZkbTdRMHpYa3VyXC9iOG1XcEVZdmVjMk9SU1NHaTBYSVhveEZpYk1seDZ3PT0iLCJtYWMiOiI3YTkwNzA1M2UyNzk4ZjA2ZDJhYmY4MTE0NWUyYjM2ZTE0NTdhNDZmM2JiYjcyNTdiNGYyM2FhNTE0ZjhmZDhjIn0=

name=system 12&topic_main_id=3
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
  "status": "success"
}
        </pre>
    </div>

</div>

@stop