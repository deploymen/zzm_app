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

<h3>DELETE /api/system/{id}</h3>
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
        </table>
        <pre class="prettyprint">DELETE http://local.zapzapmath.com/api/system/1 HTTP/1.1
Host: local.zapzapmath.com
X-access-token: 12
Cookie: __utmx=208893977.e5U6QuyaSKqesLvm_jKPxw$99127049-0:1; __utmxx=208893977.e5U6QuyaSKqesLvm_jKPxw$99127049-0:1428307792:15552000; access_token=12; laravel_session=eyJpdiI6IkVTY0RIMXQrQ0pPN2o1alE0NE92TGc9PSIsInZhbHVlIjoiUzhXVksrZDhOa1BxM0w3clNwOXpcLzZBSWpRTVR5YWhtdFRTcFl1WmI2UTNJQTg0eXMzRlhoK2hNSDJPU1R0MEJuTW9IdTVmWmFyVHdVOHl2UEtWV25BPT0iLCJtYWMiOiJkZmQzMmU5NTI4MGQ1ODA0OTE3OGZlZTA4NjNjM2VmNWU3YTJmMDhjNDY2ZTkxMGZjYjNkNzVlZjNjMTZkMTVkIn0%3D; _gat=1; _ga=GA1.2.1098556987.1429157607
        </pre>
        <div style="margin-top:50px; height:500px; overflow:auto; font-size:12px">
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