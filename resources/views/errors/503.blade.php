@extends('layouts.error')

@section('title', 'Error 503')
@section('description', config('zzm.default_page_description'))

@section('extra_style')
@stop

@section('extra_scripts')
@stop

@section('content')
<div class="errors">
    <div class="row">
        <div class="small-12 medium-12 large-12 large-centered columns">
            <h2>Error 503</h2>

        </div>
    </div>

    <div class="img-container error-503">
        <div class="row">
            <div class="small-12 medium-12 large-12 large-centered columns">
                <img src="{{ config('zzm.cdn_static') }}/images/errors/503.png" alt="Error 503" />
            </div>
        </div>
    </div>

    <div class="row">
        <div class="small-12 medium-12 large-12 large-centered columns">
            <p>
                Hey there! This page is temporarily down for maintenance; it will be up again shortly.
            </p>
        </div>
    </div>
</div>
@stop