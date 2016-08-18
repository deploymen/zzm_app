@extends('layouts.docs-page', ['sidebar_item' => 'list-user'])

@section('title', 'POST  /api/class/{id}/profile')

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
<p>INPUT</p>
<table class="hover">
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
        <td>profile_id</td>
        <td></td>
        <td></td>
    </tr>
</table>
<div style="margin-top:50px; height:500px; overflow:auto; font-size:12px">
    <pre class="prettyprint">POST http://local.zapzapmath.com/api/class/4/profile HTTP/1.1
Host: local.zapzapmath.com
X-access-token: 123
Cookie: __utmx=208893977.e5U6QuyaSKqesLvm_jKPxw$99127049-0:1; __utmxx=208893977.e5U6QuyaSKqesLvm_jKPxw$99127049-0:1428307792:15552000; access_token=4%7Ca212e19d35b8e08b429ac1a3b9a61ee71edb8065; _gat=1; _ga=GA1.2.1098556987.1429157607; laravel_session=eyJpdiI6IjNNV2FBdVNFXC9PSTJwMjF5RHVvRDRBPT0iLCJ2YWx1ZSI6ImhuT3htYTZmNTJ0Ukg2cW5vSUk4UXdON2lYUDVPY20zdzNpSTRHczFoYWFCZXpMTEx0T05jaktydkdQNmhPVmZPdHZ3OVpCS3NScnRhZ1NJTmdGdFFnPT0iLCJtYWMiOiI5NDAwZjlkYjI3ODliZDdmMjE5NDNjZDdkZWViZDEwOTRhOTI3ZjE5OTkxODRjN2NjMTk3YzRkOWQxYzIyZTM3In0%3D

profile_id=11
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
  "status": "success"
}
</pre>
@stop