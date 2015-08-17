@extends('layouts.master')
@extends('components.main-header')
@extends('components.menu-user', ['sidebar_item' => 'game_profiles'])
@extends('components.main-footer')

@section('css_include')

@stop

@section('js_include')
<script type="text/javascript" src="/js/main/result.js"></script>
<script type="text/javascript">
var VARS = VARS || {};

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
	// nick_name1     : '{{$profile["nick_name1"][0]["name"]}}',
	// nick_name2     : '{{$profile->nick_name2}}'
};
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
				<li class="indicator-list-item active">
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
	<div class="row">
		<ol class="breadcrumb pull-left">
	        <li ng-repeat="b in breadcumbs"><span ng-if="$first"><a href="javascript:;" ng-click="showResult(b.mode, b.name);">All Result</a></span>&nbsp;
	        <a href="javascript:;" ng-click="showResult(b.mode, b.name);">@{{b.name}}</a>&nbsp;&nbsp;<i class="fa fa-angle-right" ng-if="$first || $middle"></i>&nbsp;&nbsp;</li>
	    </ol>
	</div>
    <div class="results-container cf">
    	<div class="profile-bar cf">
			<div class="small-12 medium-8 columns cf">
				<div class="avatar-holder">
					<img src="/assets/main/img/avatars/{{$profile->avatar->filename}}" alt="">
					<!-- <img src="/assets/img/global/logo-icon.png" alt=" "> -->
				</div>
				<div class="nickname">
					<p class="profile-name">{{$profile->first_name}} {{$profile->last_name}}</p>
					<p class="profile-nickname">Nickname</p>
					<p class="profile-school-name truncate">{{$profile->school}}</p>
				</div>
			</div>
			<div class="small-12 medium-4 columns text-right">
				<p class="profile-code bold"><span class="blue-text">Class ID:</span> <span class="user-id">{{$profile->class_id}}</span></p>
				<p class="profile-code bold"><span class="blue-text">Player ID:</span> <span class="user-id">{{$profile->gameCode->code}}</span></p>
			</div>
		</div><!--row-->

    	<div class="content-group has-table">
		<div class="content-group--table">
			<div class="result system">
				<div class="result-table-desc">
					<h2>Systems</h2>
					<p>In Zap Zap Math, the system represents the <span class="bold">individual modules</span> taught in schools following the <span class="bold">New York Common Core</span> syllabus.</p>
				</div>
				<table id="results-table-systems" class="results-table plays wide-table">
					<thead class="hide-for-small">
						<tr>
							<th>&nbsp;</th>
							<th class="table-label-cell">
								<p class="table-label">Progress</p>
								<span class="info-icon">i</span>
							</th>
							<th>&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="s in systems">
							<!-- <td width="10%">@{{s.id}}</td> -->
							<td width="70%"><p class="results-table-name">@{{s.system_name}}</p></td>
							<td width="10%" class="results-progress-column">
								<div class="progress">
									<span class="meter" style="width: 80%"></span>
									<span class="meter-percentage">80%</span>
								</div>
							</td>
							<td width="20%">
								<a ng-click="renderPlanets(s.planets, s.system_name)" class="button round btn-more-results">
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
					<li ng-repeat="p in system_pagination" ng-class="{active:p.active}"><a ng-click="fetchSystemResult($index + 1)">@{{$index + 1}}</a></li>
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
					<p>In Zap Zap Math planets represent individual <span class="bold">subtopics</span> within a module taught according to the New York Common Core syllabus.</p>
				</div>
				<table id="results-table-systems" class="results-table plays wide-table">
					<thead class="hide-for-small">
						<tr>
							<th><p class="table-label">Code</p></th>
							<th><p class="table-label">Topic</p></th>
							<th><p class="table-label">Progress</p></th>
							<th>&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="p in planets">
							<td class="hide-for-small"><p class="results-table-name">@{{p.id}}</p></td>
							<td><p class="results-table-name">@{{p.planet_name}}</p></td>
							<td>
								<div class="progress">
									<span class="meter" style="width: 80%"></span>
									<span class="meter-percentage">80%</span>
								</div>
							</td>
							<td>
								<a ng-click="fetchPlayResult(1, pageSize, p.id, p.planet_name)" class="button round btn-more-results">
									<span>More</span>
									<i class="fa fa-chevron-right"></i>
								</a>
							</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="result play hide">
				<div class="result-table-desc">
					<h2>Questions</h2>
					<p>Here we take a more detailed look at the questions that have been asked and how well your child has performed in answering these questions.</p>
				</div>
				<table id="results-table-systems" class="results-table plays wide-table">
					<thead class="hide-for-small">
						<tr>
							<th><p class="table-label">Id</p></th>
							<th><p class="table-label">Play Time</p></th>
							<th><p class="table-label">Score</p></th>
							<th><p class="table-label">Status</p></th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="pl in plays">
							<td>@{{pl.id}}</td>
							<td><a ng-click="renderQuestions(pl.result, pl.result[$index].answer, pl.id)">@{{pl.play_time}}</a></td>
							<td>@{{pl.score}}</td>
							<td>@{{pl.status}}</td>
						</tr>
					</tbody>
				</table>
				<nav>
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
				</nav>
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
							<td width="10%">@{{q.id}}</td>
							<td width="80%">@{{q.question}}</td>
							<td width="20%">@{{answer.correct}}</td>
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
