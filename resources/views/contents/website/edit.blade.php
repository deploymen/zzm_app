@extends('layouts.master')
@extends('components.main-header')
@extends('components.menu-user', ['sidebar_item' => 'game_profiles'])
@extends('components.main-footer')

@section('css_include')
<style type="text/css">

</style>
@stop

@section('js_include')

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
					<img src="/assets/main/img/avatars/{{$profile->avatar->filename}}" alt="">
					<!-- <img src="/assets/img/global/logo-icon.png" alt=" "> -->
				</div>

			</div>
			<div class="small-12 medium-7 columns nickname-middle">
				<p class="profile-nickname">{{$profile->nickName1->name}} {{$profile->nickName2->name}}</p>
			</div>
		</div>
		<div class="small-12 medium-4 columns text-right">
			<p class="profile-code bold"><span class="blue-text">Class ID:</span> <span class="user-id">{{$profile->class_id}}</span></p>
			<p class="profile-code bold"><span class="blue-text">Player ID:</span> <span class="user-id">{{$profile->gameCode->code}}</span></p>
			<input type="hidden" id="profile-id" value="{{$profile->id}}" />
			<input type="hidden" id="profile-email" value="{{$profile->email}}" />
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
			<div class="small-12 medium-6 columns">
				<label>Age
					<select id="profile-age-edit">
						<option value="5">5 or younger</option>
						<option value="6">6</option>
						<option value="7">7</option>
						<option value="8">8</option>
						<option value="9">9</option>
						<option value="10">10</option>
						<option value="11">11</option>
						<option value="12">12</option>
						<option value="13">13</option>
						<option value="14">14</option>
						<option value="15">15</option>
						<option value="16">16</option>
						<option value="17">17</option>
						<option value="18">18 +</option>
					</select>
				</label>
			</div>
			<div class="small-12 medium-6 columns">
				<!-- <label>Grade
					<select>
						<option value="prekindergarten">Pre-Kindergarten</option>
						<option value="kindergarten">Kindergarten</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="6">6</option>
						<option value="7">7</option>
						<option value="8">8</option>
						<option value="9">9</option>
						<option value="10">10</option>
						<option value="11">11</option>
						<option value="12">12</option>
						<option value="continuous">Continuous Learner</option>
					</select>
				</label> -->
				<label>Grade
					<select>
						@foreach ([1,2,3,4,5,6,7,8,9,10,11,12] as $grade)
							@if ($grade->id == $userGradeId)
							    <option selected="selected">{{$grade->name}}</option>
							@else
							    <option>{{$grade->name}}</option>
							@endif
						@endforeach
					</select>
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
					<a href="javascript:void(0)" id="btn-save-profile" class="button wide radius blue">Save Changes</a>
				</div>
			</div>
		</div>
	</form><!--end of form-->
</div>

<div class="row">
	<div class="box-centered small-12 medium-7 text-center">
		<p class="privacydisclaimer">Your child's name is kept strictly confidential and is only visible to you.<br/>We do not use it for any purpose, it is just to associate your child with their profile.</p>
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

<div id="profiledelete" class="reveal-modal text-center" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog" data-options="close_on_background_click:false">
	<h3 id="modalTitle">Be Careful!</h3>
	<p class="lead">You are about to delete this profile. Are you sure?</p>
	<div class="row">
		<div class="small-12 columns">
			<div class="small-6 columns text-center">
				<label>
					<input type="button" value="Cancel" id="btn-delete-cancel" class="button wide radius blue" />
				</label>
			</div>
			<div class="small-6 columns text-center">
				<label>
					<input type="button" value="Delete" id="btn-delete-ok" class="button wide radius alert" />
				</label>
			</div>
		</div>
	</div>
</div>


<div id="profilesaved" class="reveal-modal text-center" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
	<h3 id="modalTitle">Beautiful</h3>
	<p class="lead">Your changes have been saved.</p>
	<div class="row">
		<div class="medium-5 box-centered text-center">
			<label>
				<input type="button" value="OK" id="btn-changes-ok" class="button wide radius blue" />
			</label>
		</div>
	</div>
	<!-- <a href="javascript:void(0)" class="close-reveal-modal" aria-label="Close">OK</a> -->
</div>

@stop