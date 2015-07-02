@extends('layouts.master')
@extends('components.main-header')
@extends('components.menu-user', ['sidebar_item' => 'game_profiles'])
@extends('components.main-footer')

@section('css_include')
<style type="text/css">

</style>
@stop

@section('js_include')
<script type="text/javascript">
    
</script>
<script src="/../js/main/profiles.js"></script>
@stop

<!-- @section('breadcrumb')
<nav class="breadcrumbs" role="menubar" aria-label="breadcrumbs">
   <li role="menuitem">
       <a href="/user/home"><i class="fa fa-home"></i>&nbsp;Home</a>
   </li>
   <li role="menuitem" class="current">
       <a href="#">Game Profiles</a>
   </li>
</nav>
@stop -->

@section('content')

<!-- <div class="row">
	<a href="javascript:void(0);" data-reveal-id="addProfileModal" class="button radius green" id="btn-show-profile-form" class="btn-show-profile-form">Add New Profile</a>
</div> -->

<div id="addProfileModal" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
	<h3 id="modalTitle" class="modalTitle">Create a new Profile</h3>
	<p class="subline-desc">Profiles allow you to follow the progress of each individual child</p>
	<form id="new-profile-form">
		<div class="row">
			<div class="small-12 medium-6 columns">
				<label>First Name
					<input id="new-first-name" type="text" placeholder="Adam" />
				</label>
			</div>
			<div class="small-12 medium-6 columns">
				<label>Last Name
					<input id="new-last-name" type="text" placeholder="Lim" />
				</label>
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns">
				<label>School
					<p class="subline-desc">This will be used to connect students and teachers from the same school</p>
					<input id="new-school" type="text" />
				</label>
			</div>
		</div>
		<div class="row">
			<div class="small-12 columns">
				<label>City
					<p class="subline-desc">This will be used to compare results against other cities and places in the world</p>
					<input id="new-city" type="text" />
				</label>
			</div>
		</div>
		<div class="row">
			<div class="medium-5 box-centered text-center">
				<label>
					<input type="button" value="Create My Profile" id="btn-create-profile" class="button wide radius blue" />
				</label>
			</div>
		</div>
	</form>

	<div class="row close-reveal-modal text-center" aria-label="Close">
		<a>back to dashboard</a>
	</div>

	
</div><!--addProfileModal-->

<div class="row">
	<div id="profile-list" class="cf"></div>
</div>

@stop