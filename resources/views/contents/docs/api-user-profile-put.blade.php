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
        <h3>PUT   /api/profiles/{profile_id}/edit</h3>
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
                        <td>email</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>city</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>school</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>class_id</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>nickname1</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>nickname2</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>avatar_id</td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
                <div style="margin-top:50px; height:500px; overflow:auto; font-size:12px">
<pre class="prettyprint">PUT http://staging.zapzapmath.com/api/profiles/1/edit HTTP/1.1
Host: staging.zapzapmath.com
X-access-token: 1|92b943b0ff3ffe4ff943f448d30eb5a0ff7ef7e9
Cookie: __utmx=208893977.kkr4s3aaRwa7IjcDX5IuXg$99127049-2:0; __utmxx=208893977.kkr4s3aaRwa7IjcDX5IuXg$99127049-2:1431580824:15552000; __utmx=204351314.kkr4s3aaRwa7IjcDX5IuXg$99127049-2:0; __utmxx=204351314.kkr4s3aaRwa7IjcDX5IuXg$99127049-2:1431584530:15552000; _ga=GA1.2.238970283.1430284975; laravel_session=eyJpdiI6IjJNb3BCWXVRb0U4NGh3am14cVp5V0E9PSIsInZhbHVlIjoiUStzT0lxNitcL2c4d01hcG94S0FpWW9iN3Y3M3pwOW1MaEhaN0JMdUlLZXV6MzJMK0k5UzhYK2txVVpzSGhvVFRZbzVYaWhrOGtZNXV4Mk02NTdJUitnPT0iLCJtYWMiOiJjNjE4MGUzNjhhNzVkMWQzODZkYjhkN2MyNWJiOTI2OGMyN2M3M2RkYTI4ZTQyZDk2Y2UyODU2MDQ0YmZlNjVlIn0%3D

first_name=lai&last_name=weizhong&email=weizhong%40gmail.com&city=BM&school=berapit&nickname1=1&nickname2=1&class_id=3
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
    "id": 1,
    "user_id": 1,
    "class_id": "3",
    "first_name": "lai",
    "last_name": "weizhong",
    "school": "berapit",
    "city": "BM",
    "email": "weizhong@gmail.com",
    "nickname1": "1",
    "nickname2": "1",
    "avatar_id": 1,
    "created_at": "2015-04-22 13:40:03",
    "updated_at": "2015-05-19 10:47:41",
    "deleted_at": null
  }
}
</pre>
            </div>

        </div>
    </div>
    <!--END ROW -->
</div>

@stop
