@extends('layouts.master')

@section('body')
@include('shared/nav')

<div class="site-wrapper">
    @yield('content')

    @include('shared.footer')
</div><!--site-wrapper-->
@stop