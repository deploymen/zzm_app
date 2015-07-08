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
var VARS = VARS || {};

VARS = {
	id         : '{{$profile->id}}',
	first_name : '{{$profile->first_name}}',
	last_name  : '{{$profile->last_name}}',
	school     : '{{$profile->school}}',
	city       : '{{$profile->city}}',
	email      : '{{$profile->email}}',
	avatar     : '{{$profile->avatar}}',
	game_code  : '{{$profile->gameCode}}',
	class_id   : '{{$profile->class_id}}'
};
</script>
<script src="/../js/main/profiles.js"></script>
@stop

<!-- @section('breadcrumb')
<nav class="breadcrumbs" role="menubar" aria-label="breadcrumbs">
   <li role="menuitem">
       <a href="/user/home"><i class="fa fa-home"></i>&nbsp;Home</a>
   </li>
   <li role="menuitem">
       <a href="/user/profiles">Game Profiles</a>
   </li>
   <li role="menuitem" class="current">
       <a href="#">Edit</a>
   </li>
</nav>
@stop -->

@section('content')            

<div class="row">
	<div class="small-12 columns text-center">
		<h3 class="grey-heading">Edit Profile</h3>
	</div>
</div>

<div class="content-group--content small-12 medium-8">
	<div class="row">
		<div class="small-12 medium-8 columns">
			<div class="small-12 medium-5 columns">
				<div class="avatar-holder">
					<img src="/assets/main/img/avatars/avatar{{$profile->avatar->id}}.png" alt="">
					<!-- <img src="/assets/img/global/logo-icon.png" alt=" "> -->
				</div>

			</div>
			<div class="small-12 medium-7 columns nickname-middle">
				<p class="profile-nickname">Nickname</p>
			</div>
		</div>
		<div class="small-12 medium-4 columns text-right">
			<p class="profile-code bold"><span class="blue-text">Class ID:</span> <span class="user-id">{{$profile->class_id}}</span></p>
			<p class="profile-code bold"><span class="blue-text">Player ID:</span> <span class="user-id">{{$profile->gameCode->code}}</span></p>
		</div>
	</div><!--row-->

	<form id="edit-profile-form" class="edit-profile-form">
		<div class="row">
			<div class="small-12 medium-6 columns">
				<label>First Name
					<input id="profile-first-name" class="profile-first-name" type="text" value="{{$profile->first_name}}" />
				</label>
			</div>
			<div class="small-12 medium-6 columns">
				<label>Last Name
					<input id="profile-last-initial" class="profile-last-initial" type="text" value="{{$profile->last_name}}" />
				</label>
			</div>
		</div>

		<div class="row">
			<div class="small-12 columns">
				<label>School
					<p class="subline-desc">This will be used to connect students and teachers from the same school</p>
					<input id="profile-school" class="profile-school" type="text" placeholder="What school does your child attend?" value="{{$profile->school}}" />
				</label>
			</div>
		</div>
		
		<div class="row">
			<div class="small-12 columns">
				<label>City
					<p class="subline-desc">This will be used to compare results againts other cities and places in the world</p>
					<input id="profile-city" class="profile-city" type="text" placeholder="What city do you live in?" value="{{$profile->city}}"/>
				</label>
			</div>
		</div>

		<div class="row">
			<div class="small-12 columns text-center">
				<div class="small-12 medium-6 columns">
					<a href="/user/profiles" class="button wide radius grey">Back</a>
				</div>
				<div class="small-12 medium-6 columns">
					<input type="button" value="Save Changes" id="btn-save-profile" class="button wide radius blue">
				</div>
			</div>
		</div>
	</form><!--end of form-->
</div>

<div class="row">
	<div class="box-centered small-12 medium-7 text-center">
		<p class="subline-desc">Your child's name is kept strictly confidential and is only visible to you.<br/>We do not use it for any purpose, it is just to associate your child with their profile.</p>
	</div>
</div>

<div class="content-group--content red small-12 medium-8">
	<div class="row text-center">
		<h3>Delete Profile</h3>
		<p class="red-text">Please be careful, this action is irreversible. Once you delete this profile, all the results and content associated with it will be gone for good.</p>
	</div>

	<form action="">
		<div class="row">
			<div class="small-12 medium-5 box-centered text-center">
				<input type="button" class="button wide radius alert" id="btn-delete-profile" class="btn-delete-profile" value="Delete" />
			</div>
		</div>
	</form>
</div>


<!-- <div id="ssmodal" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
	<h2 id="modalTitle">Awesome. I have it.</h2>
	<p class="lead">Your couch.  It is mine.</p>
	<p>I'm a cool paragraph that lives inside of an even cooler modal. Wins!</p>
	<a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div> -->

@stop