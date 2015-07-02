@extends('layouts.master')
@extends('components.main-header')
@extends('components.menu-user', ['sidebar_item' => 'setting'])
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
       <a href="#">My Account Settings</a>
   </li>
</nav>
@stop -->

@section('content')

<section class="row">
	<div class="content-group small-12 columns">
		<h3 class="content-group--heading">Edit Information</h3>
		<div class="content-group--content">
			<label>Username</label>
			<p>Mathling1414</p>

			<label>Email</label>
			<p>hello@mathlingmail.com</p>

			<form action="">
				<div class="row">
					<div class="small-9 columns">
						<label for="" class="">
							<input type="text" placeholder="Full Name (Optional)">
						</label>
					</div>
				</div>

				<div class="row">
					<div class="small-9 columns">
						<label for="" class="">
							<input type="text" placeholder="Mobile Phone Number">
						</label>
					</div>
				</div>

				<div class="row">
					<div class="small-9 columns">
						<label for="" class="">
							<textarea placeholder="Address" name="" id="" cols="30" rows="10"></textarea>
						</label>
					</div>
				</div>

				<div class="row">
					<div class="small-9 columns">
						<input class="button radius green" type="submit">
						<button class="radius green right">Reset</button>
					</div>
				</div>
			</form>
		</div>
	</div><!--content-group-->
</section>

@stop