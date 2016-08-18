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

<h3>PUT   /api/class/{id}</h3>
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
                <td>id(URL)</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>class_name</td>
                <td></td>
                <td></td>
            </tr>
        </table>
        <div style="margin-top:50px; height:500px; overflow:auto; font-size:12px">
            <pre class="prettyprint">PUT http://local.zapzapmath.com/api/class/3 HTTP/1.1
Host: local.zapzapmath.com
X-access-token: 1234
Cookie: __utmx=208893977.e5U6QuyaSKqesLvm_jKPxw$99127049-0:1; __utmxx=208893977.e5U6QuyaSKqesLvm_jKPxw$99127049-0:1428307792:15552000; access_token=4%7Ca212e19d35b8e08b429ac1a3b9a61ee71edb8065; _gat=1; _ga=GA1.2.1098556987.1429157607; laravel_session=eyJpdiI6ImZzQmpOVlA4VWI3NU1kMVBNT0gza2c9PSIsInZhbHVlIjoiN1A2UUdvS3hFTmcxWnlITFpqQW9QU0hiOGJaRzJJckhVY1pJbGpralB6ZFR6dFFhdVpqYWZKZHJXN245eHhCWWRqRE5remRvM3NvbmJIM1lOUTErXC93PT0iLCJtYWMiOiJhOTY3M2FiZmEzNGRhMzNiNzUzZDk0MGQxODY2YzgwYzBmZDhiZjBmNjQyZGNiNmNlZDAzODI0NDY5MDk2MTY4In0%3D

class_name=Class+4
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
    "id": 3,
    "user_id": 3,
    "name": "Class 4",
    "created_at": "2015-04-07 18:45:59",
    "updated_at": "2015-04-16 12:56:05",
    "deleted_at": null
  }
}
        </pre>
    </div>

</div>

@stop