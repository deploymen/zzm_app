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
@stop

@section('content')

<section class="row">
	<div class="small-12 columns">
		<div class="small-4 columns avatar-holder">
			<img src="/assets/main/img/avatars/avatar1.png" alt="">
		</div>
		<div class="small-8 columns result-detail-holder">
			<p class="profile-code">User ID: <span class="user-id"></span></p>
			<p class="profile-code">Nickname: <span class="user-id"></span></p>
			<p class="detail-last-online">Last Online:<br/><span>01 May, 2015</span></p>
			<p class="detail-total-complete">Total Completed:<br/><span>12</p>
			<a href="/user/profiles" class="button radius green">Back to Profiles Page</a>
		</div>
	</div>
	<div class="content-group has-table small-6 columns">
		<h3>Play (Round) Results</h3>
		<p>Results from every round played.</p>
		<div class="content-group--table">
			<table id="results-table-systems" class="results-table plays wide-table">
				<thead>
					<tr>
						<th width="200">Play</th>
						<th>Date Played</th>
						<th width="150">XX/YY</th>
						<th width="150">%</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Understanding Subtraction as an Unknown-Addend Problem</td>
						<td>01 May, 2015</td>
						<td>10/50</td>
						<td>20%</td>
					</tr>
					<tr>
						<td>Fluently add and subtract fluently within 20 using mental strategies. Know From memory all sums of two one-digit numbers</td>
						<td>01 May, 2015</td>
						<td>20/50</td>
						<td>40%</td>
					</tr>
					<tr>
						<td>Use multiplication and division within 100 to solve word problems</td>
						<td>01 May, 2015</td>
						<td>30/50</td>
						<td>60%</td>
					</tr>
					<tr>
						<td>Understanding Subtraction as an Unknown-Addend Problem</td>
						<td>01 May, 2015</td>
						<td>10/50</td>
						<td>20%</td>
					</tr>
					<tr>
						<td>Fluently add and subtract fluently within 20 using mental strategies. Know From memory all sums of two one-digit numbers</td>
						<td>01 May, 2015</td>
						<td>20/50</td>
						<td>40%</td>
					</tr>
					<tr>
						<td>Use multiplication and division within 100 to solve word problems</td>
						<td>01 May, 2015</td>
						<td>30/50</td>
						<td>60%</td>
					</tr>
				</tbody>
			</table>

			<div class="pagination-centered">
				<ul class="pagination">
					<li class="arrow unavailable"><a href="">&laquo;</a></li>
					<li class="current"><a href="">1</a></li>
					<li><a href="">2</a></li>
					<li><a href="">3</a></li>
					<li><a href="">4</a></li>
					<li class="unavailable"><a href="">&hellip;</a></li>
					<li><a href="">12</a></li>
					<li><a href="">13</a></li>
					<li class="arrow"><a href="">&raquo;</a></li>
				</ul>
			</div>
		</div>
	</div><!--content-group-->

	<div class="content-group has-table small-6 columns">
		<h3>Question Breakdown</h3>
		<p>A breakdown of  each question</p>
		<div class="content-group--table">
			<table id="results-table-question-breakdown" class="results-table question-breakdown wide-table">
				<thead>
					<tr>
						<th width="200">Subtopic</th>
						<th>Date Played</th>
						<th width="150">XX/YY</th>
						<th width="150">%</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Understanding Subtraction as an Unknown-Addend Problem</td>
						<td>01 May, 2015</td>
						<td>10/50</td>
						<td>20%</td>
					</tr>
					<tr>
						<td>Fluently add and subtract fluently within 20 using mental strategies. Know From memory all sums of two one-digit numbers</td>
						<td>01 May, 2015</td>
						<td>20/50</td>
						<td>40%</td>
					</tr>
					<tr>
						<td>Use multiplication and division within 100 to solve word problems</td>
						<td>01 May, 2015</td>
						<td>30/50</td>
						<td>60%</td>
					</tr>
					<tr>
						<td>Understanding Subtraction as an Unknown-Addend Problem</td>
						<td>01 May, 2015</td>
						<td>10/50</td>
						<td>20%</td>
					</tr>
					<tr>
						<td>Fluently add and subtract fluently within 20 using mental strategies. Know From memory all sums of two one-digit numbers</td>
						<td>01 May, 2015</td>
						<td>20/50</td>
						<td>40%</td>
					</tr>
					<tr>
						<td>Use multiplication and division within 100 to solve word problems</td>
						<td>01 May, 2015</td>
						<td>30/50</td>
						<td>60%</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div><!--content-group-->

</section>

<div class="row">
	
</div>

@stop