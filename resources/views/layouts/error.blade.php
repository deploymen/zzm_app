@extends('layouts.master')

@section('body')
@include('shared/nav')

<div class="page-wrapper">
    <div class="page-main-content">
        @yield('content')
    </div>
    @include('shared.footer')
</div>
@stop