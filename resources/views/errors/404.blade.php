@extends('layouts.error')

@section('title', 'Error 404')
@section('description', config('zzm.default_page_description'))

@section('extra_style')
@stop

@section('extra_scripts')
@stop

@section('content')
<div class="errors">
    <div class="row">
        <div class="small-12 medium-12 large-12 large-centered columns">
            <h2>Error 404</h2>

        </div>
    </div>

    <div class="img-container error-404">
        <div class="row">
            <div class="small-12 medium-12 large-12 large-centered columns">
                <img src="{{ config('zzm.cdn_static') }}/images/errors/404.jpg" alt="Error 404" />
            </div>
        </div>
    </div>

    <div class="row">
        <div class="small-12 medium-12 large-12 large-centered columns">
            <p>
                We can't find the page you're looking for!<br />
                Let's start again from the <a href="/">homepage</a>.
            </p>
        </div>
    </div>
</div>
@stop