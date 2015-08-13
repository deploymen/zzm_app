@extends('layouts.master')
@extends('components.main-header')
@extends('components.menu-user')
@extends('components.main-footer')

@section('css_include')
<style type="text/css">

</style>
@stop

@section('js_include')
<script type="text/javascript">
    var VARS || {};

    VARS = {
    	first_name = {{$profile.first_name}},
    	last_name = {{$profile.last_name}},
    	school = {{$profile.school}},
    	city = {{$profile.city}},
    	email = {{$profile.email}},
    }
</script>
@stop

@section('content')            

<h2>Profile 1 Details | EDIT</h2>

<section class="row">
	
</section>

@stop