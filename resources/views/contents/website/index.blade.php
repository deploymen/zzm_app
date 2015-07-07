@extends('layouts.master')
@extends('components.main-header')
@extends('components.menu-user', ['sidebar_item' => 'dashboard'])
@extends('components.main-footer')

@section('css_include')
<style type="text/css">

</style>
@stop

@section('js_include')
<script type="text/javascript">
    
</script>
@stop

<!-- @section('breadcrumb')
<nav class="breadcrumbs" role="menubar" aria-label="breadcrumbs">
   <li role="menuitem">
       <a href="/user/home"><i class="fa fa-home"></i>&nbsp;Home</a>
   </li>
   <li role="menuitem" class="current">
       <a href="#">Member Dashboard</a>
   </li>
</nav>
@stop -->


@section('content') 



<ul id="sortable" class="small-block-grid-1 medium-block-grid-3 sort-box-list cf">
	<li class="ui-state-default">1</li>
	<li class="ui-state-default">2</li>
	<li class="ui-state-default">3</li>
	<li class="ui-state-default">4</li>
	<li class="ui-state-default">5</li>
	<li class="ui-state-default">6</li>
	<li class="ui-state-default">7</li>
	<li class="ui-state-default">8</li>
	<li class="ui-state-default">9</li>
</ul>

@stop