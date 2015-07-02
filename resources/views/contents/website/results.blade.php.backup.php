@extends('layouts.master')
@extends('components.main-header')
@extends('components.menu-user', ['sidebar_item' => 'game_profiles'])
@extends('components.main-footer')

@section('css_include')
<style type="text/css">
table { width: 970px; }
.hide { display: none; }
ul.pagination > li > a { color: #333 }
.pagination .active a { background-color: #2B91D6; color: #fff; font-weight: bold;}
.breadcrumb {
	margin-left: 0px;
  	padding: 8px 15px;
  	margin-bottom: 20px;
  	list-style: none;
  	background-color: #f5f5f5;
  	border-radius: 4px;
}
.pull-left, .pull-left > li { float: left !important; }
</style>
@stop

@section('js_include')
<!-- <script type="text/javascript" src="/bower_components/angular/angular.min.js"></script> -->
<script type="text/javascript" src="/js/main/result.js"></script>
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
	nickname1     : '{{$profile->nickname1}}',
	nickname2     : '{{$profile->nickname2}}',
	game_code     : '{{$profile->gameCode}}'
};
</script>
@stop

@section('content')

<section class="row" ng-app="zapzapApp" ng-controller="MainController" data-ng-init="init()">
	<div class="small-12 columns">
		<div class="small-4 columns avatar-holder">
			<img src="/assets/main/img/avatars/{{$profile->avatar->filename}}" alt="">
		</div>
		<div class="small-8 columns result-detail-holder">
			<p class="profile-code">User ID: <span class="user-id">{{$profile->id}}</span></p>
			<p class="profile-code">Nickname: <span class="user-id"></span></p>
			<p class="detail-last-online">Last Online:<br/><span>01 May, 2015</span></p>
			<p class="detail-total-complete">Total Completed:<br/><span>12</p>
			<a href="/user/profiles" class="button radius green">Back to Profiles Page</a>
		</div>
	</div>

	<div class="content-group has-table small-12 columns">
		<h3>Results</h3>

		<ol class="breadcrumb pull-left">
	        <li ng-repeat="b in breadcumbs"><span ng-if="$first"><a href="javascript:;" ng-click="showResult(b.mode, b.name);">All Result</a></span>&nbsp;
	        <a href="javascript:;" ng-click="showResult(b.mode, b.name);">@{{b.name}}</a>&nbsp;&nbsp;<i class="fa fa-angle-right" ng-if="$first || $middle"></i>&nbsp;&nbsp;</li>
	    </ol>

		<div class="content-group--table">
			<div class="result system">
				<table id="results-table-systems" class="results-table plays wide-table">
					<thead>
						<tr>
							<th>Id</th>
							<th>System Name</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="s in systems">
							<td width="10%">@{{s.id}}</td>
							<td width="90%"><a ng-click="renderPlanets(s.planets, s.system_name)">@{{s.system_name}}</a></td>
						</tr>
					</tbody>
				</table>
				<nav>
				  <ul class="pagination pagination-sm">
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
				<table id="results-table-systems" class="results-table plays wide-table">
					<thead>
						<tr>
							<th>Id</th>
							<th>Planet Name</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="p in planets">
							<td width="10%">@{{p.id}}</td>
							<td width="90%"><a><a ng-click="fetchPlayResult(1, pageSize, p.id, p.planet_name)">@{{p.planet_name}}</a></a></td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="result play hide">
				<table id="results-table-systems" class="results-table plays wide-table">
					<thead>
						<tr>
							<th>Id</th>
							<th>Play Time</th>
							<th>Score</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="pl in plays">
							<td width="10%">@{{pl.id}}</td>
							<td width="30%"><a ng-click="renderQuestions(pl.result, pl.result[$index].answer, pl.id)">@{{pl.play_time}}</a></td>
							<td width="30%">@{{pl.score}}</td>
							<td width="30%">@{{pl.status}}</td>
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
					<thead>
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

</section>

@stop
