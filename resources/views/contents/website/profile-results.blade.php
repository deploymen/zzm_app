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
<script type="text/javascript" src="/js/main/progress-meter.js"></script>
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
					<a href="/user/profiles"><img src="/assets/main/img/profiles/icon-profiles-1.png" alt="Icon Profiles"></a>
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
	<div class="row ng-cloak">
	    <ol class="breadcrumb">
	        <li>
	        	<a href="/user/profiles/{{$profile->id}}/results">All Result</a>
	        </li>
	        <li ng-if="breadcumbs.system_id = breadcumbs.system_id">
	        	<a href="/user/profiles/{{$profile->id}}/results?system_id=@{{breadcumbs.system_id}}">@{{breadcumbs.system_name}}</a>
	        </li>
	        <li ng-if="breadcumbs.planet_id = breadcumbs.planet_id">
	        	<a href="/user/profiles/{{$profile->id}}/results?planet_id=@{{breadcumbs.planet_id}}&planet_id=@{{breadcumbs.planet_id">{{breadcumbs.planet_subtitle}}</a>
	        </li>
	    </ol>
	</div>
    <div class="results-container cf" ng-cloak>
    	<div class="profile-bar cf">
			<div class="small-12 columns cf">
				<div class="small-12 medium-3 columns">
					<div class="avatar-holder">
						<img src="/assets/main/img/avatars/{{$profile->avatar->filename}}" alt="">
					</div>
				</div>

				<div class="small-12 medium-9 columns">
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
				<div class="medium-5 columns profile-last-seen-wrapper">
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
					<tbody>
						<tr ng-repeat="s in systems">
							<!-- <td width="10%">@{{s.id}}</td> -->
							<td width="70%"><p class="results-table-name">@{{s.system_name}}</p></td>
							<td width="20%" class="results-progress-column">
								<div class="progress">
									<span class="meter meter-@{{s.percentage}}" style="width: @{{s.percentage}}%"></span>
									<span class="meter-percentage">@{{s.percentage}}%</span>
								</div>
							</td>
							<td width="10%" class="" ng-switch on="s">
								<a ng-href="/user/profiles/{{$profile->id}}/results?system_id=@{{s.id}}" class="button round btn-more-results">
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
					<div class="difficuly-meter-box cf">
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
							<td width="20%" class="">
								<div class="progress">
									<span class="meter meter-@{{p.percentage}}" style="width: @{{p.percentage}}%"></span>
									<span class="meter-percentage">@{{p.percentage}}%</span>
								</div>
							</td>
							<td width="10%" ng-switch on="p.play_count">
								<span ng-switch-when="0">
									&nbsp;
								</span>
								<span ng-switch-default>
									<a ng-href="/user/profiles/{{$profile->id}}/results?profile_id={{$profile->id}}&planet_id=@{{p.id}}" class="button round btn-more-results">
									<span>More</span>
									<i class="fa fa-chevron-right"></i>
								</a>
								</span>
							</td>
						</tr>
					</tbody>
				</table>
			</div>

			<!-- <div class="result play hide">
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
			</div> -->

			<div class="result question hide">
				<table id="results-table-systems" class="results-table plays wide-table">
					<thead class="hide-for-small">
						<tr>
							<th>
								<span class="profile-label">Question</span>
							</th>
							<th>
								<span class="profile-label">{{$profile->first_name}}'s Answer</span>
							</th>
							<th>&nbsp;</th>
							<th>&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="q in questions">
							<td width="60%" class="results-table-name">@{{q.question}}</td>
							<td width="20%" class="results-table-name">@{{q.result.answer}}</td>
							<td width="10%" ng-switch on="q.result.correct">
								<span ng-switch-when="1"><i class="fa fa-check"></i></span>
								<span ng-switch-when="0"><i class="fa fa-times"></i></span>
							</td>
							<td width="10%" class="results-info-column"><span class="info-icon">i</span></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div><!--content-group-->
    </div>
	<div class="row results-btn-holder text-center" ng-switch on="q.result.correct">
		<a href="/user/profiles/" class="results-back-link">Go Back to Profiles</a>
	</div>

	

</section>

@stop
