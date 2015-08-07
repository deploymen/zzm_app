@extends('layouts.master')
@extends('components.main-header')
@extends('components.menu-user', ['sidebar_item' => 'game_profiles'])
@extends('components.main-footer')

@section('css_include')
<style type="text/css">
/* ng-cloak */
[ng\:cloak], [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-ng-cloak {
  display: none !important;
}
</style>
@stop

@section('js_include')
<script type="text/javascript" src="/js/main/profile-results.js"></script>
<script type="text/javascript">
/*var VARS = VARS || {};

VARS = {
	id             : '{{$profile->id}}',
	first_name     : '{{$profile->first_name}}',
	last_name      : '{{$profile->last_name}}',
	school         : '{{$profile->school}}',
	city           : '{{$profile->city}}',
	email          : '{{$profile->email}}',
	avatar         : '{{$profile->avatar}}',
	nickname1      : '{{$profile->nickname1}}',
	nickname2      : '{{$profile->nickname2}}',
	game_code      : '{{$profile->gameCode}}'
};*/

var ZZM = ZZM || {};

ZZM.profileId  = '{{$profile->id}}';
ZZM.systemId  = '{{Request::input('system_id')}}';
ZZM.planetId = '{{Request::input('planet_id')}}';
ZZM.playId = '{{Request::input('play_id')}}';

</script>
@stop

@section('content')

<section ng-app="zapzapApp" ng-controller="MainController" data-ng-init="init()">
	<div class="row">
		<div class="indicator-holder">
			<span class="indicator-bar"></span>
			<ul class="indicator-list">
				<li class="indicator-list-item">
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
	<div class="clearfix">&nbsp;</div>
	<div class="row ng-cloak">
	    <ol class="breadcrumb pull-left">
	        <li><span><a href="/user/profiles/{{$profile->id}}/results">All Result</a></span>&nbsp;</li>
	        <li ng-if="breadcumbs.system_id = breadcumbs.system_id">&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;<a href="/user/profiles/{{$profile->id}}/results?system_id=@{{breadcumbs.system_id}}">@{{breadcumbs.system_name}}</a></li>
	        <li ng-if="breadcumbs.planet_id = breadcumbs.planet_id">&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;<a href="/user/profiles/{{$profile->id}}/results?planet_id=@{{breadcumbs.planet_id}}">@{{breadcumbs.planet_subtitle}}</a></li>
	        <li ng-if="breadcumbs.play_id = breadcumbs.play_id">&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;<a href="/user/profiles/{{$profile->id}}/results?play_id=@{{breadcumbs.play_id}}">@{{breadcumbs.play_id}}</a></li>
	    </ol>
	</div>
    <div class="results-container cf">
    	<div class="profile-bar cf">
			<div class="small-12 columns cf">
				<div class="small-12 medium-2 columns">
					<div class="avatar-holder">
						<img src="/assets/main/img/avatars/{{$profile->avatar->filename}}" alt="">
					</div>
				</div>

				<div class="small-12 medium-10 columns">
					<div class="nickname">
						<p class="profile-name">{{$profile->first_name}} {{$profile->last_name}}</p>
						<p class="profile-nickname">{{$profile->nickName1->name}} {{$profile->nickName2->name}}</p>
						<p class="profile-code bold"><span class="profile-label">Player ID:</span> <span class="user-id">{{$profile->gameCode->code}}</span></p>
					</div>
				</div>
			</div>
		</div><!--row-->

		<div class="profile-bar cf">
			<div class="small-12 columns">
				<div class="medium-7 columns">
					<p class="profile-school-name truncate">School name</p>
					<p class="profile-school-grade truncate">Grade @{{gameprofile.grade}}</p>
				</div>
				<div class="medium-5 columns text-right">
					<p class="profile-label">Last Played</p>
					<p class="profile-last-seen">@{{gameprofile.last_played}}</p>
				</div>
			</div>
		</div>

    	<div class="content-group has-table">
		<div class="content-group--table">
			<div class="result system">
				<div class="result-table-desc">
					<h2>Systems</h2>
					<p>In Zap Zap Math, the system represents the overarching topics encompassing multiple subjects. The bar shows how much of the topic has been covered by the player as they complete the planets in each system.</p>
				</div>
				<table id="results-table-systems" class="results-table plays wide-table">
					<!-- <thead class="hide-for-small">
						<tr>
							<th>&nbsp;</th>
							<th class="table-label-cell">
								<p class="table-label">Progress</p>
							</th>
							<th>&nbsp;</th>
						</tr>
					</thead> -->
					<tbody>
						<tr ng-repeat="s in systems">
							<!-- <td width="10%">@{{s.id}}</td> -->
							<td width="70%"><p class="results-table-name">@{{s.system_name}}</p></td>
							<td width="20%" class="results-progress-column">
								<div class="progress">
									<span class="meter" style="width: 80%"></span>
									<span class="meter-percentage">80%</span>
								</div>
							</td>
							<td width="10%">
								<a href="/user/profiles/{{$profile->id}}/results?system_id=@{{s.id}}" class="button round btn-more-results">
									<span>More</span>
									<i class="fa fa-chevron-right"></i>
								</a>	
							</td>
						</tr>
					</tbody>
				</table>
				<nav class="text-center">
				  <ul class="pagination">
					<li>
					  <a href="javascript:;" aria-label="Previous" ng-click="fetchSystemResult(page - 1)">
						<span aria-hidden="true">&laquo;</span>
					  </a>
					</li>
					<li ng-repeat="p in pagination" ng-class="{active:p.active}"><a ng-click="fetchSystemResult($index + 1)">@{{$index + 1}}</a></li>
					<li>
					  <a href="javascript:;" aria-label="Next" ng-click="fetchSystemResult(page + 1)">
						<span aria-hidden="true">&raquo;</span>
					  </a>
					</li>
				  </ul>
				</nav>
			</div>

			<div class="result planet hide">
				<div class="result-table-desc">
					<h2>Planets</h2>
					<p>In Zap Zap Math, planets represent individual subjects within a larger topic.</p>
					<div class="difficuly-meter-box">
						<ul class="difficuly-label-list">
							<li>Beginner</li>
							<li>Developing</li>
							<li>Average</li>
							<li>Good</li>
							<li>Beyond Expectations</li>
						</ul>
						<ul class="difficuly-meter cf">
							<li></li>
							<li></li>
							<li></li>
							<li></li>
							<li></li>
						</ul>
					</div>
				</div>
				<table id="results-table-systems" class="results-table plays wide-table">
					<tbody>
						<tr ng-repeat="p in planets">
							<td width="70%"><p class="results-table-name">@{{p.subtitle}}</p></td>
							<td width="20%">
								<div class="progress">
									<span class="meter" style="width: 80%"></span>
									<span class="meter-percentage">80%</span>
								</div>
							</td>
							<td width="10%">
								<a href="/user/profiles/{{$profile->id}}/results?planet_id=@{{p.id}}" class="button round btn-more-results">
									<span>More</span>
									<i class="fa fa-chevron-right"></i>
								</a>
							</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="result play hide">
				<!-- <div class="result-table-desc">
					<h2>Questions</h2>
					<p>Here we take a more detailed look at the questions that have been asked and how well your child has performed in answering these questions.</p>
				</div> -->
				<table id="results-table-systems" class="results-table plays wide-table">
					<thead class="hide-for-small">
						<tr>
							<th><p class="table-label">Question</p></th>
							<th><p class="table-label">{{$profile->first_name}}'s Answer</p></th>
							<th><p class="table-label">&nbsp;</p></th>
							<th><p class="table-label">&nbsp;</p></th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="pl in plays">
							<td>@{{pl.id}}</td>
							<td><a href="/user/profiles/{{$profile->id}}/results?play_id=@{{pl.id}}">@{{pl.play_time}}</a></td>
							<td>@{{pl.status}}</td>
							<td>@{{pl.score}}</td>
							
						</tr>
					</tbody>
				</table>
				<!-- <nav>
				  <ul class="pagination pagination-sm">
					<li>
					  <a href="javascript:;" aria-label="Previous" ng-click="fetchPlayResult(page - 1, pageSize, planetid, planetname)">
						<span aria-hidden="true">&laquo;</span>
					  </a>
					</li>
					<li ng-repeat="pp in play_pagination" ng-class="{active:pp.active}"><a ng-click="fetchPlayResult($index + 1, pageSize, planetid, planetname)">@{{$index + 1}}</a></li>
					<li>
					  <a href="javascript:;" aria-label="Next" ng-click="fetchPlayResult(page + 1, pageSize, planetid, planetname)">
						<span aria-hidden="true">&raquo;</span>
					  </a>
					</li>
				  </ul>
				</nav> -->
			</div>

			<div class="result question hide">
				<table id="results-table-systems" class="results-table plays wide-table">
					<thead class="hide-for-small">
						<tr>
							<th>Id</th>
							<th>Question</th>
							<th>Correct</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="q in questions">
							<td width="10%">@{{q.question_id}}</td>
							<td width="80%">@{{q.question}}</td>
							<td width="20%">@{{answer}}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div><!--content-group-->
    </div>
	<div class="row results-btn-holder text-center">
		<a href="/user/profiles" class="">Go Back to Profiles</a>
	</div>

	

</section>

@stop
