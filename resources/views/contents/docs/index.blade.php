@extends('layouts.master-docs', ['sidebar_item' => '']) 

@section('breadcrumb')
<!--BEGIN TITLE & BREADCRUMB PAGE-->
<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left">
        <div class="page-title"> </div>
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

<dl>
    <dt>Development Default Game Code:</dt>
    <dd>-devanm01</dd>
    <dd>-devanm02</dd>
    <dd>-devanm03</dd>

    <dt>Development version's planets </dt>
    <dd>id: 1 for P01</dd>
    <dd>id: 2 for P02</dd>
    <dd>id: 3 for P03</dd>
    <dd>id: 4 for P04</dd>
    <dd>id: 6 for P06</dd>

    <dt>SECRET KEY</dt>
    <dd>d60dK53A40I6HBTBNVoC</dd>

    <dt>URL - ENCODE - DECODE</dt>
    <dd><a href="http://www.url-encode-decode.com/" target="_blank"> http://www.url-encode-decode.com/</a></dd>

    <dt>SHA1</dt>
    <dd><a href="http://www.sha1-online.com/" target="_blank"> http://www.sha1-online.com/</a></dd>

    <dt>ONLINE JSON VIEWER</dt>
    <dd><a href="http://jsonviewer.stack.hu/" target="_blank">http://jsonviewer.stack.hu/</a></dd>
</dl>

@stop
