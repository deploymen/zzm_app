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

<h3>GET   api/set/nick</h3>
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
            Allow game client to retrieve a set of predefine nicknames and avatars.
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
        </table>
        <p>INPUT</p>
        <table class="table table-striped table-bordered table-hover">
            <tr>
                <th style="width:175px;">Key</th>
                <th style="width:500px;">Description</th>
                <th style="width:360px;">Example</th>
            </tr>

        </table>
        <div style="margin-top:50px; height:500px; overflow:auto; font-size:12px">
            <pre class="prettyprint">GET http://staging.zapzapmath.com/api/set/nick HTTP/1.1
Host: staging.zapzapmath.com
Cookie: __utmx=208893977.kkr4s3aaRwa7IjcDX5IuXg$99127049-2:0; __utmxx=208893977.kkr4s3aaRwa7IjcDX5IuXg$99127049-2:1431580824:15552000; __utmx=204351314.kkr4s3aaRwa7IjcDX5IuXg$99127049-2:0; __utmxx=204351314.kkr4s3aaRwa7IjcDX5IuXg$99127049-2:1431584530:15552000; _ga=GA1.2.238970283.1430284975; laravel_session=eyJpdiI6InlyczVJWGpZSDZUYlhXbG53WXJmV2c9PSIsInZhbHVlIjoic0VnelJkOXo1TmQ3T2RCd1JBdDdZZjA3bGRsOUJqQ0o4ZGZla3NYRmRVa211V0NaYldTYTRXVW1qTXlBNk16Q0IrWUJzc1l3TzFzRmFDMjRRYW1PRkE9PSIsIm1hYyI6IjczM2U5NDNiNWVkNzUyOGY2YzdkZjg4NGE1NmQzMmUxNzE5YmY4NjZiZGM2Yjc5OTFhZDFhYWUzN2U3NjU1ZTAifQ%3D%3D
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
    "nickname1": [
      {
        "id": 22,
        "name": "Audurod"
      },
      {
        "id": 9,
        "name": "Azeelin"
      },
      {
        "id": 2,
        "name": "Azoil"
      },
      {
        "id": 20,
        "name": "Beiik"
      },
      {
        "id": 10,
        "name": "Clalwixx"
      },
      {
        "id": 3,
        "name": "Ejun"
      },
      {
        "id": 23,
        "name": "Erirctar"
      },
      {
        "id": 5,
        "name": "Fregus"
      },
      {
        "id": 15,
        "name": "Hoozok"
      },
      {
        "id": 16,
        "name": "Hosmik"
      },
      {
        "id": 7,
        "name": "Ialmuktan"
      },
      {
        "id": 24,
        "name": "Iardrara"
      },
      {
        "id": 4,
        "name": "Imell-A"
      },
      {
        "id": 21,
        "name": "Irlix"
      },
      {
        "id": 8,
        "name": "Jeexon"
      },
      {
        "id": 19,
        "name": "Kliod"
      },
      {
        "id": 6,
        "name": "Kubron"
      },
      {
        "id": 1,
        "name": "Mozviss"
      },
      {
        "id": 14,
        "name": "Reyena"
      },
      {
        "id": 17,
        "name": "Thooktia"
      },
      {
        "id": 12,
        "name": "Thruana"
      },
      {
        "id": 11,
        "name": "Uslin"
      },
      {
        "id": 18,
        "name": "Xaathee"
      },
      {
        "id": 13,
        "name": "Zeyari"
      }
    ],
    "nickname2": [
      {
        "id": 7,
        "name": "Blox"
      },
      {
        "id": 22,
        "name": "Blua"
      },
      {
        "id": 12,
        "name": "Broz"
      },
      {
        "id": 19,
        "name": "Crax"
      },
      {
        "id": 17,
        "name": "Flooxxoo"
      },
      {
        "id": 8,
        "name": "Fruuoo"
      },
      {
        "id": 11,
        "name": "Greth"
      },
      {
        "id": 18,
        "name": "Iler"
      },
      {
        "id": 20,
        "name": "Leklok"
      },
      {
        "id": 21,
        "name": "Naaon"
      },
      {
        "id": 16,
        "name": "Nuoz"
      },
      {
        "id": 1,
        "name": "Oznin"
      },
      {
        "id": 14,
        "name": "Pher"
      },
      {
        "id": 13,
        "name": "Preik"
      },
      {
        "id": 5,
        "name": "Quun"
      },
      {
        "id": 23,
        "name": "Rin"
      },
      {
        "id": 15,
        "name": "Siis"
      },
      {
        "id": 4,
        "name": "Smishis"
      },
      {
        "id": 3,
        "name": "Unzath"
      },
      {
        "id": 2,
        "name": "Vaais"
      },
      {
        "id": 9,
        "name": "Vaglax"
      },
      {
        "id": 24,
        "name": "Xik"
      },
      {
        "id": 6,
        "name": "Yestik"
      },
      {
        "id": 10,
        "name": "Yoix"
      }
    ],
    "avatars": [
      {
        "id": 1,
        "name": "default",
        "filename": "default.jpg"
      },
      {
        "id": 2,
        "name": "avatar1",
        "filename": "avatar1.jpg"
      }
    ]
  }
}
        </pre>
    </div>

</div>

@stop