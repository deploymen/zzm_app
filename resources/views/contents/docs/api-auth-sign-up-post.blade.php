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
        <h3>POST  /api/auth/sign-up</h3>
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
                <p>For user to sign up(register)</p>
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
                        <td>password</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>name</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>country</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>device_id</td>
                        <td>(optional)</td>
                        <td></td>
                    </tr>
                </table>
                <div style="margin-top:50px; height:500px; overflow:auto; font-size:12px">
<pre class="prettyprint">
POST http://staging.zapzapmath.com/api/auth/sign-up HTTP/1.1
Host: staging.zapzapmath.com
Connection: keep-alive
Content-Length: 120
User-Agent: Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.89 Safari/537.36
Origin: chrome-extension://hgmloofddffdnphfgcellkdfbfbjeloo
Content-Type: application/x-www-form-urlencoded
Accept: */*
Accept-Encoding: gzip, deflate
Accept-Language: en-US,en;q=0.8
Cookie: laravel_session=eyJpdiI6Iitad2E5c3BXQXhzXC9tU29QaXhraExnPT0iLCJ2YWx1ZSI6IkR3dHZBWFJDTVwvcnlcL0poWTdYNmNYYWVMU3pUVnpBNCtlMkFxNEhwRTdJY21wS2JnNnV4VmNtZmJsNVVKQTdSaTBhejV0UTU0NlFzU1AwQVNiTkJ4Vmc9PSIsIm1hYyI6IjY5YmJiNWE3MTVlZTNhMDllYTJkZWJjMmZmOTk5OWFmYmQ4MzZjY2I5ZTFlMjU2MGEwZmU1ZThhYmJjZWU5N2YifQ==; _gat=1; _ga=GA1.2.706022169.1426500729

email=weizhong.lai@webuiltit.com.my&password=920403&name=WeiZhong Lai&email=weizhong.lai@webuiltit.com.my&country=MY
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
}
</pre>
            </div>

        </div>
    </div>
    <!--END ROW -->
</div>

@stop
