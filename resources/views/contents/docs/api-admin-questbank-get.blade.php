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

<h3>GET   /api/question-bank</h3>
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
            Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone. Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui. Wolf salvia freegan, sartorial keffiyeh echo park vegan.
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
                <td>topic_main_id</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>topic_sub_id</td>
                <td></td>
                <td></td>
            </tr>

        </table>
        <div style="margin-top:50px; height:500px; overflow:auto; font-size:12px">
            <pre class="prettyprint">GET http://staging.zapzapmath.com/api/questbank/ HTTP/1.1
Host: staging.zapzapmath.com
Connection: keep-alive
X-access-token: 123456
User-Agent: Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.89 Safari/537.36
Accept: */*
Accept-Encoding: gzip, deflate, sdch
Accept-Language: en-US,en;q=0.8
Cookie: access_token=1%7C19d13ac1ffe13382317da9b755e08442a39c7cbd; _ga=GA1.2.706022169.1426500729; laravel_session=eyJpdiI6InhQTDNncUJMOEtkZ2NlK1ZGR3hcL1J3PT0iLCJ2YWx1ZSI6IklNdExyMnZ1d0RsdzFSYnVTTytxSHJkeHZtWnBHVmh0eU5XWHlxSzNTMWNEelpQYm5MZ0RzTUZkSFcwbUhmSkttWngxdHNJQTF3cnRBUWFHUkh3SmV3PT0iLCJtYWMiOiIzNzY0NjgyYmE0NmRjODRiNzg3OTFkNTliYjJmZGUzNTYyMmIzMDk3MzRmYjIxZDkyYzI0ZThiNWVmYmM2NzJkIn0%3D
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
	-data: {
	list: [0]
	}
}
        </pre>
    </div>

</div>

@stop