@extends('layouts.master-docs')

@section('content')
<h2 class="docs">@yield('title')</h2>

<!--Tabs for medium and large-->
<div class="show-for-medium">
    <ul class="tabs" data-tabs id="example-tabs">
        <li class="tabs-title is-active"><a href="#desc" aria-selected="true">Description</a></li>
        <li class="tabs-title"><a href="#req">Request</a></li>
        <li class="tabs-title"><a href="#resp">Response</a></li>
    </ul>

    <div class="tabs-content" data-tabs-content="example-tabs">
        <div class="tabs-panel is-active" id="desc">
            @yield('desc')
        </div>
        <div class="tabs-panel" id="req">
            @yield('req')
        </div>
        <div class="tabs-panel" id="resp">
            @yield('resp')
        </div>
    </div>
</div>

<!--Accordion for small-->
<div class="hide-for-medium">
    <ul class="accordion" data-accordion>
        <li class="accordion-item is-active" data-accordion-item>
            <a href="#" class="accordion-title">Description</a>
            <div class="accordion-content" data-tab-content>
                @yield('desc')
            </div>
        </li>
        <li class="accordion-item" data-accordion-item>
            <a href="#" class="accordion-title">Request</a>
            <div class="accordion-content" data-tab-content>
                @yield('req')
            </div>
        </li>
        <li class="accordion-item" data-accordion-item>
            <a href="#" class="accordion-title">Response</a>
            <div class="accordion-content" data-tab-content>
                @yield('resp')
            </div>
        </li>
    </ul>
</div>
@stop