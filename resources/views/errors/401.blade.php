@extends('layouts.error')

@section('title', 'Error 401')
@section('description', config('zzm.default_page_description'))

@section('extra_style')
@stop

@section('extra_scripts')
@stop

@section('content')
<div class="errors">
    <div class="row">
        <div class="small-12 medium-12 large-12 large-centered columns">
            <h2>Error 401</h2>

        </div>
    </div>

    <div class="img-container error-401">
        <div class="row">
            <div class="small-12 medium-12 large-12 large-centered columns">
                <img src="{{ config('zzm.cdn_static') }}/images/errors/401.png" alt="Error 401" />
            </div>
        </div>
    </div>

    <div class="row">
        <div class="small-12 medium-12 large-12 large-centered columns">
            <p>
                Hmm&hellip; you don’t seem authorised to view this page, try another. How about <a href="/">this one</a>?
            </p>
        </div>
    </div>
</div>
@stop