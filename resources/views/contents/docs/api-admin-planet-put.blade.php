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

<div class="row">
    <div class="col-lg-8">
        <h3>PUT   /api/planet/{id}</h3>
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
                        <td>game_type_id</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>type</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>name</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>question_count</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>question_random</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>enable</td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
                <div style="margin-top:50px; height:500px; overflow:auto; font-size:12px">
<pre class="prettyprint">PUT http://local.zapzapmath.com/api/planet/12 HTTP/1.1
Host: local.zapzapmath.com
X-access-token: 12
Cookie: __utmx=208893977.e5U6QuyaSKqesLvm_jKPxw$99127049-0:1; __utmxx=208893977.e5U6QuyaSKqesLvm_jKPxw$99127049-0:1428307792:15552000; _ga=GA1.2.1098556987.1429157607; access_token=12; laravel_session=eyJpdiI6IlU0Sm1LZ0ltWUJNeU9JemJRNzR2RHc9PSIsInZhbHVlIjoiTW9WU1RmQ24wSjIzcXNOOWZXcGRcL3ByMWtVT1Z4SlFhdUxZR1hCSTNJbnBKdm1OVmV1MTVIYlwvVmNYZGJPVzhza3BtQnZheUR1QkI4S3ZNY2pTK3lxdz09IiwibWFjIjoiMWVkNmEzOTk4ZThlNzI1MWFlMzMzYThjMjZmYjVjZGZjMGI3NGVlY2JhNDYwODgyMzI4NGE0ZWVkZjcyZGRmZiJ9

game_type_id=1&type=2&name=test planet 10&question_count=15&question_random=&enable= 
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

            </div>

        </div>
    </div>
    <!--END ROW -->
</div>

@stop