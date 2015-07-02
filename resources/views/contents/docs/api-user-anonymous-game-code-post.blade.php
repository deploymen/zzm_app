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

<div class="row">
    <div class="col-lg-8">
        <h3>POST   api/game-code/anonymous</h3>
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
                <p>INPUT</p>
                <table class="table table-striped table-bordered table-hover">
                    <tr>
                        <th style="width:175px;">Key</th>
                        <th style="width:500px;">Description</th>
                        <th style="width:360px;">Example</th>
                    </tr>
                    <tr>
                        <td>device_id</td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
                <div style="margin-top:50px; height:500px; overflow:auto; font-size:12px">
<pre class="prettyprint">POST http://staging.zapzapmath.com/api/game-code/anonymous HTTP/1.1
Host: staging.zapzapmath.com
Cookie: __utmx=208893977.kkr4s3aaRwa7IjcDX5IuXg$99127049-2:0; __utmxx=208893977.kkr4s3aaRwa7IjcDX5IuXg$99127049-2:1432609909:15552000; __utmx=204351314.kkr4s3aaRwa7IjcDX5IuXg$99127049-2:0; __utmxx=204351314.kkr4s3aaRwa7IjcDX5IuXg$99127049-2:1432610057:15552000; viewedOuibounceModal=true; _ga=GA1.2.238970283.1430284975; laravel_session=eyJpdiI6ImN6cGN5Tkk5OU02WGM2YXM5UzVBelE9PSIsInZhbHVlIjoiYzFkR3BWREVGSzg5U0p3bTNyZ051aWwzdGdUNHl4S2d3SnF1bWF6eUxQbHY5RVp6R3Z3XC85bXp3cDg5MGVTREk2RXZNM1wvaHBha05qTVwveFE1SlZoSEE9PSIsIm1hYyI6ImYzYTQ0YzliOTAzMDIzOTkzNThkMDMxYWQ1ZDFlNTc0YWMxZjQ0MDVjMjI5ZmVkMTgzNDM3N2RlZmQ4YTQyZTkifQ%3D%3D

device_id=ak55a4w78vx4a12c
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
    "game-code": "000002sm"
  }
}
</pre>
            </div>

        </div>
    </div>
    <!--END ROW -->
</div>

@stop
