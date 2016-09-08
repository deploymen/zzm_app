@extends('layouts.master')

@section('body')
@include('shared/nav')

<div class="page-wrapper">
    <div class="page-main-content">
        <header class="page-banner">
            <div class="row">
                @if (!empty($header_format) && $header_format == 'custom')
                <div class="badge-box">
                    <img src="@yield('header_badge')" alt="">
                </div>
                <div class="text-box">
                    <h2>@yield('header_title')</h2>
                    <p>@yield('header_tagline')</p>
                </div>
                @else
                <div class="page-logo">
                    <img src="{{ config('zzm.cdn_static') }}/images/global/logo-banner.png" alt="">
                </div>
                @endif
            </div>
        </header>

        @yield('content')
    </div>
    @include('shared.footer')
</div>
@stop