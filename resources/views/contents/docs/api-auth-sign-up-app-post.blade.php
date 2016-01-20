@extends('layouts.master-docs', ['sidebar_item' => 'list-general'])

@section('breadcrumb')
<!--BEGIN TITLE & BREADCRUMB PAGE-->
<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left">
        <div class="page-title">AUTH API</div>
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
        <h3>POST  /api/game/sign-up</h3>
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
                <p>For user to sign up in App(register)</p>
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
                        <td>email</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>first_name</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>last_name</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>deviceId</td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
                <div style="margin-top:50px; height:500px; overflow:auto; font-size:12px">
<pre class="prettyprint">
POST http://staging.zapzapmath.com/api/1.0/game/sign-up HTTP/1.1

{"status":"success","data":"000000o0"}
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
    status: "success"
    data: "000000o0"
}
</pre>
            </div>

        </div>
    </div>
    <!--END ROW -->
</div>

@stop
