@extends('layouts.master')

@section('body')

@include('shared/user_topbar')

<div class="off-canvas-wrap" data-offcanvas>
    <div class="inner-wrap">
        @yield('menu')

        <div class="user-wrapper">
            <div class="user-main-content">
                @yield('content')
            </div>
        </div>
    </div>
    @include('shared.footer')
</div>
@stop