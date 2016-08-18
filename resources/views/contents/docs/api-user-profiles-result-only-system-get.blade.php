@extends('layouts.docs-page', ['sidebar_item' => 'list-user'])

@section('title', 'GET   /api/profiles/result/only-system')

@section('desc')
<p>

</p>
@stop

@section('req')
<p>Header</p>
<table class="hover">
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
<table class="hover">
    <tr>
        <th style="width:175px;">Key</th>
        <th style="width:500px;">Description</th>
        <th style="width:360px;">Example</th>
    </tr>
    <tr>
        <td>profile_id</td>
        <td></td>
        <td></td> 
    </tr>
</table>
<div style="margin-top:50px; height:500px; overflow:auto; font-size:12px">
    <pre class="prettyprint">
GET http://dev.zapzapmath.com/api/profiles/result/only-system HTTP/1.1
Host: dev.zapzapmath.com
X-access-token: 1|4db2af27acb0da7dd5fce6e45c54416a59b7ddcc
    </pre>
</div>
@stop

@section('resp')
<table class="hover">
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
    "system": [
      {
        "id": 101,
        "system_name": " Addition & Subtraction to 10",
        "played": "1"
      },
      {
        "id": 102,
        "system_name": " Place Values to 20",
        "played": "1"
      },
      {
        "id": 103,
        "system_name": " Measurement",
        "played": "1"
      },
      {
        "id": 104,
        "system_name": " Place Values to 40",
        "played": "1"
      },
      {
        "id": 105,
        "system_name": " Shape and Time",
        "played": "1"
      },
      {
        "id": 106,
        "system_name": " Place Values to 100",
        "played": "1"
      },
      {
        "id": 107,
        "system_name": " Addition & Subtraction to 20",
        "played": "1"
      },
      {
        "id": 108,
        "system_name": " Lengths",
        "played": "1"
      },
      {
        "id": 109,
        "system_name": " Place Values to 1000",
        "played": "1"
      },
      {
        "id": 110,
        "system_name": " Addition & Subtraction to 200",
        "played": "1"
      },
      {
        "id": 111,
        "system_name": " Addition & Subtraction to 1000",
        "played": "1"
      },
      {
        "id": 112,
        "system_name": " Foundation for Multiplication & Division",
        "played": "1"
      },
      {
        "id": 113,
        "system_name": " Graphs",
        "played": "1"
      },
      {
        "id": 114,
        "system_name": " Time and Geometry",
        "played": "1"
      },
      {
        "id": 115,
        "system_name": " Multiplication & Division of 2-5, and 10",
        "played": "1"
      },
      {
        "id": 116,
        "system_name": " Time and Mass",
        "played": "1"
      },
      {
        "id": 117,
        "system_name": " Multiplication & Division of 0, 1, 6-9, and Multiples of 10",
        "played": "1"
      },
      {
        "id": 118,
        "system_name": " Area",
        "played": "1"
      },
      {
        "id": 119,
        "system_name": " Line Fractions",
        "played": "1"
      },
      {
        "id": 120,
        "system_name": " Data",
        "played": "1"
      },
      {
        "id": 121,
        "system_name": " Geometry and Measurement",
        "played": "1"
      },
      {
        "id": 122,
        "system_name": " The Four Operations and Place Value",
        "played": "1"
      },
      {
        "id": 123,
        "system_name": " Conversions",
        "played": "1"
      },
      {
        "id": 124,
        "system_name": " Multiply and Divide",
        "played": "1"
      },
      {
        "id": 125,
        "system_name": " Angles and Planes",
        "played": "1"
      },
      {
        "id": 126,
        "system_name": " Zap Zap Fractions",
        "played": "1"
      },
      {
        "id": 127,
        "system_name": " Decimal Fractions",
        "played": "1"
      },
      {
        "id": 128,
        "system_name": " Multiply \u00d7 Multiply",
        "played": "1"
      },
      {
        "id": 129,
        "system_name": " Place Value and Decimal Fraction",
        "played": "1"
      },
      {
        "id": 130,
        "system_name": " Whole Numbers vs Decimal Fractions",
        "played": "1"
      }
    ],
    "page": "1",
    "page_size": "30",
    "pageTotal": 2
  }
}
</pre>
@stop