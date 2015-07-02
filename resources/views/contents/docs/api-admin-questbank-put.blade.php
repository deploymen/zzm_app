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
        <h3>PUT   /api/question-bank/{id}</h3>
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
                        <td>id(URL)</td>
                        <td></td>
                        <td></td>
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
                    <tr>
                        <td>question</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>answer</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>enable</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>answer_option_1</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>answer_option_2</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>answer_option_3</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>answer_option_4</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>answer_option_5</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>answer_option_6</td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
                <div style="margin-top:50px; height:500px; overflow:auto; font-size:12px">
                    Raw denim you probably haven't
                    heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth
                    master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica.
                    Reprehenderit butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh
                    mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone.
                    Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui. Wolf
                    salvia freegan, sartorial keffiyeh echo park vegan. Raw denim you probably haven't
                    heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth
                    master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica.
                    Reprehenderit butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh
                    mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone.
                    Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui. Wolf
                    salvia freegan, sartorial keffiyeh echo park vegan. Raw denim you probably haven't
                    heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth
                    master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica.
                    Reprehenderit butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh
                    mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone.
                    Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui. Wolf
                    salvia freegan, sartorial keffiyeh echo park vegan. Raw denim you probably haven't
                    heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth
                    master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica.
                    Re synth. Cosby sweater eu banh
                    mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone.
                    Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui. Wolf
                    salvia freegan, sartorial keffiyeh echo park vegan. Raw denim you probably haven't
                    heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth
                    master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica.
                    Reprehenderit butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh
                    mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone.
                    Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui. Wolf
                    salvia freegan, sartorial keffiyeh echo park vegan. Raw denim you probably haven't
                    heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth
                    master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica.
                    Repsweater eu banh
                    mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone.
                    Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui. Wolf
                    salvia freegan, sartorial keffiyeh echo park vegan.Raw denim you probably haven't
                    heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth
                    master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica.
                    Reprehenderit butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh
                    mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone.
                    Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui. Wolf
                    salvia freegan, sartorial keffiyeh echo park vegan.
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