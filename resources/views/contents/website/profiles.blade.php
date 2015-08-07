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
<script src="/../js/main/profiles-ng.js"></script>

<script type="text/javascript">

</script>

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
	<a href="javascript:void(0);" data-reveal-id="addProfileModal" class="btn-show-profile-form button radius green" id="btn-show-profile-form">Add New Profile</a>
</div> -->


<section ng-app="zapzapProfile" ng-controller="ProfileController" data-ng-init="init()">
<!-- <section> -->
	<div class="row">
		<div class="indicator-holder">
			<span class="indicator-bar"></span>
			<ul class="indicator-list">
				<li class="indicator-list-item active">
					<img src="/assets/main/img/profiles/icon-profiles-1.png" alt="Icon Profiles">
				</li>
				<li class="indicator-list-item">
					<img src="/assets/main/img/profiles/icon-profiles-2.png" alt="Icon Systems">
				</li>
				<li class="indicator-list-item">
					<img src="/assets/main/img/profiles/icon-profiles-3.png" alt="Icon Planets">
				</li>
				<li class="indicator-list-item">
					<img src="/assets/main/img/profiles/icon-profiles-4.png" alt="Icon Questions">
				</li>
			</ul>
		</div>
	</div>

	<div id="addProfileModal" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog" data-options="close_on_background_click:false">
		<h3 id="modalTitle" class="modalTitle">Create a new Profile</h3>
		<p class="subline-desc">Profiles allow you to follow the progress of each individual child</p>
		<form data-abide="ajax" id="new-profile-form" class="new-profile-form">
			<div class="row">
				<div class="small-12 medium-6 columns">
					<label for="first-name">First Name
						<input id="new-first-name" type="text" placeholder="Adam" name="first-name" required />
					</label>
				</div>
				<div class="small-12 medium-6 columns">
					<label>Last Name
						<input id="new-last-name" type="text" placeholder="Lim" />
					</label>
				</div>
			</div>

			<div class="row">
				<div class="small-12 medium-12 columns">
					
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
					<label>Grade
						<select id="profile-grade-edit">
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
		<div id="profile-list" class="cf">
			<!-- <div ng-repeat=""></div> -->
			<div class="profile-item" ng-repeat="gameprofile in gameprofiles">
				<section class="profile-info">
					<div class="profile-item-group small-12 columns">
						<div class="small-5 columns">
							<div class="profile-pic-holder">
								<img ng-src="/assets/main/img/avatars/@{{gameprofile.avatar.filename}}" alt="Avatar">
							</div>
						</div>
						<div class="small-7 columns">
							<div class="cf">
								<p class="profile-name">
									<span class="first-name">@{{gameprofile.first_name}} </span>
									<span class="first-name">@{{gameprofile.last_name}}</span>
								</p>
								<p class="profile-nickname">
									<span class="first-name">@{{gameprofile.nick_name1.name}} </span>
									<span class="last-name">@{{gameprofile.nick_name2.name}}</span>
								</p>
								<p class="profile-code bold"><span class="profile-label">Player ID:</span> <span class="user-id">@{{gameprofile.game_code.code}}</span></p>
							</div>
						</div>
					</div>

					<div class="profile-item-group cf">
						<p class="profile-school-name truncate">@{{gameprofile.school}}</p>
						<p class="profile-school-grade truncate">Grade @{{gameprofile.grade}}</p>
					</div>

					<div class="profile-item-group cf">
						<div class="small-12 columns text-center">
							<p class="profile-proficiency">
								<span class="profile-label bold">Last Played</span>
							</p>
							<p class="profile-last-seen">@{{gameprofile.last_played}}</p>
						</div>
					</div>

					<div class="profile-item-group cf">
						<div class="small-12 columns text-center">
							<p class="profile-attempts">
								<span class="profile-label bold">Total Attempts</span>
							</p>
							<p class="profile-attempt-number">545</p>
							<a href="javascript:void(0);" title="Proficiency is based on the average score of all games played." class="info-icon">i<span class="profile-tooltip"><p>Last Played shows the last time this child played Zap Zap Math.</p></span></a>
						</div>
					</div>

					<p class="profile-upgrade-cta"><a ng-href="/user/profiles/@{{gameprofile.id}}/results" class="button round">Detailed report</a></p>
					<a ng-href="/user/profiles/@{{gameprofile.id}}/edit" class="btn-profile-edit">Edit</a>
				</section>
			</div>

			<div class="profile-item add-button">
				<section class="profile-info">
					<p class="">Add Profile</p>
					<div class="add-plus-box"><i class="fa fa-plus"></i></div>
					<a href="javascript:void(0);" data-reveal-id="addProfileModal" id="btn-show-profile-form" class="btn-show-profile-form"></a>
				</section>
			</div>
		</div>
	</div>
</section>

@stop