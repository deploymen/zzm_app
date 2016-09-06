@extends('layouts.master')

@section('extra_scripts')
<script src="/js/pages/auth.js"></script>
@stop

@section('body')

<div class="site-wrapper sign-in-up auth">
    <div class="row">
        <section class="signup-holder clearfix">
            <section class="signup-holder-inner small-12 medium-5 large-4 small-centered columns">
                <div class="logo">
                    <a href="/">
                        <img src="{{ config('zzm.cdn_static') }}/images/global/logo-main-white.png" alt=" ">
                    </a>
                </div>

                <div id="form-response-messages"></div>

                <div class="loading">
                    <i class="fa fa-spinner fa-spin"></i>
                </div>

                @yield('content')
            </section>
        </section>
    </div>
    <div class="blue-bg-overlay"></div>
</div><!--site-wrapper-->
@stop