@extends('layouts.master')
@extends('components.main-header')
@extends('components.menu-user', ['sidebar_item' => 'new_quiz'])
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
	<ul class="tabs" data-tab>
		<li class="tab-title active"><a href="#new-quiz-step-1">Quiz Settings</a></li>
		<li class="tab-title"><a href="#new-quiz-step-2">Select Questions</a></li>
		<li class="tab-title"><a href="#new-quiz-step-3">Select Class</a></li>
		<li class="tab-title"><a href="#new-quiz-step-4">Complete</a></li>
	</ul>
	<div class="tabs-content">
		<div class="content active" id="new-quiz-step-1">
			<form action="">
				<div class="row">
					<div class="small-12 columns">
						<label>Quiz Name
							<input type="text" placeholder="What would you like to call your quiz?" />
						</label>
					</div>
				</div>

				<div class="row">
					<div class="small-12 columns">
						<label>Quantity
							<input type="text" placeholder="How many questions will this quiz have?" />
						</label>
					</div>
				</div>

				<div class="row">
					<div class="small-12 columns">
						<label>Description
							<input type="text" placeholder="What's your quiz about?" />
						</label>
					</div>
				</div>

				<div class="row">
					<div class="small-12 columns">
						<label>Game Type
							<select>
								<option value="Options">Options</option>
								<option value="option1">option1</option>
								<option value="option2">option2</option>
								<option value="option3">option3</option>
							</select>
						</label>
					</div>
				</div>
				<div class="row">
					<div class="small-12 columns">
						<label>Question Mode
							<select>
								<option value="Fixed">Fixed</option>
								<option value="option1">option1</option>
								<option value="option2">option2</option>
								<option value="option3">option3</option>
							</select>
						</label>
					</div>
				</div>
				<div class="row">
					<div class="small-12
					 columns">
						<input class="button" type="submit" value="Next">
					</div>
				</div>
			</form>
		</div>
		<div class="content" id="new-quiz-step-2">
			<div class="small-3 columns">
				<article class="quiz-option-holder">
					<h3>Main Chapter</h3>
					<ul class="quiz-option-list">
						<li>One</li>
						<li>Two</li>
						<li>Three</li>
						<li>Four</li>
						<li>Five</li>
						<li>Six</li>
						<li>Seven</li>
						<li>Eight</li>
						<li>Nine</li>
						<li>Ten</li>
						<li class="future">Eleven</li>
						<li class="future">Twelve</li>
						<li class="future">Thirteen</li>
						<li class="future">Fourteen</li>
						<li class="future">Fifteen</li>
						<li class="future">Sixteen</li>
						<li class="future">Seventeen</li>
						<li class="future">Eighteen</li>
						<li class="future">Nineteen</li>
						<li class="future">Twenty</li>
						<li class="future">Twentyone</li>
						<li class="future">Twentytwo</li>
						<li class="future">Twentythree</li>
						<li class="future">Twentyfour</li>
						<li class="future">Twentyfive</li>
						<li class="future">Twentysix</li>
						<li class="future">Twentyseven</li>
						<li class="future">Twentyeight</li>
						<li class="future">Twentynine</li>
						<li class="future">Thirty</li>
					</ul>
				</article>
			</div>
			<div class="small-3 columns">
				<article class="quiz-option-holder">
					<h3>Sub Chapter</h3>
					<ul class="quiz-option-list">
						<li>Thirtyone</li>
						<li>Thirtytwo</li>
						<li>Thirtythree</li>
						<li>Thirtyfour</li>
						<li>Thirtyfive</li>
						<li>Thirtysix</li>
						<li>Thirtyseven</li>
						<li>Thirtyeight</li>
						<li>Thirtynine</li>
						<li>Forty</li>
						<li class="future">Fortyone</li>
						<li class="future">Fortytwo</li>
						<li class="future">Fortythree</li>
						<li class="future">Fortyfour</li>
						<li class="future">Fortyfive</li>
						<li class="future">Fortysix</li>
						<li class="future">Fortyseven</li>
						<li class="future">Fortyeight</li>
						<li class="future">Fortynine</li>
						<li class="future">Fifty</li>
						<li class="future">Fiftyone</li>
						<li class="future">Fiftytwo</li>
						<li class="future">Fiftythree</li>
						<li class="future">Fiftyfour</li>
						<li class="future">Fiftyfive</li>
						<li class="future">Fiftysix</li>
						<li class="future">Fiftyseven</li>
						<li class="future">Fiftyeight</li>
						<li class="future">Fiftynine</li>
						<li class="future">Sixty</li>
					</ul>
				</article>
			</div>
			<div class="small-3 columns">
				<article class="quiz-option-holder">
					<h3>Question</h3>
					<ul class="quiz-option-list">
						<li>Sixtyone</li>
						<li>Sixtytwo</li>
						<li>Sixtythree</li>
						<li>Sixtyfour</li>
						<li>Sixtyfive</li>
						<li>Sixtysix</li>
						<li>Sixtyseven</li>
						<li>Sixtyeight</li>
						<li>Sixtynine</li>
						<li>Seventy</li>
						<li class="future">Seventyone</li>
						<li class="future">Seventytwo</li>
						<li class="future">Seventythree</li>
						<li class="future">Seventyfour</li>
						<li class="future">Seventyfive</li>
						<li class="future">Seventysix</li>
						<li class="future">Seventyseven</li>
						<li class="future">Seventyeight</li>
						<li class="future">Seventynine</li>
						<li class="future">Eighty</li>
						<li class="future">Eightyone</li>
						<li class="future">Eightytwo</li>
						<li class="future">Eightythree</li>
						<li class="future">Eightyfour</li>
						<li class="future">Eightyfive</li>
						<li class="future">Eightysix</li>
						<li class="future">Eightyseven</li>
						<li class="future">Eightyeight</li>
						<li class="future">Eightynine</li>
						<li class="future">Ninety</li>
					</ul>
					<div class="large-12 columns">
						<div class="row collapse">
							<div class="small-5 columns">
								<input type="text" placeholder="Quantity">
							</div>
							<div class="small-7 columns">
								<a href="#" class="button postfix">Random</a>
							</div>
						</div>
					</div>
				</article>
			</div>
			<div class="small-3 columns">
				<article class="quiz-option-holder">
					<h3>Selected</h3>
					<ul class="quiz-option-list">
						<li>Ninetyone</li>
						<li>Ninetytwo</li>
						<li>Ninetythree</li>
						<li>Ninetyfour</li>
						<li>Ninetyfive</li>
						<li>Ninetysix</li>
						<li>Ninetyseven</li>
						<li>Ninetyeight</li>
						<li>Ninetynine</li>
						<li>OneHundred</li>
						<li class="future">OneHundredone</li>
						<li class="future">OneHundredtwo</li>
						<li class="future">OneHundredthree</li>
						<li class="future">OneHundredfour</li>
						<li class="future">OneHundredfive</li>
						<li class="future">OneHundredsix</li>
						<li class="future">OneHundredseven</li>
						<li class="future">OneHundredeight</li>
						<li class="future">OneHundrednine</li>
						<li class="future">OneHundredten</li>
						<li class="future">OneHundredeleven</li>
						<li class="future">OneHundredtwelve</li>
						<li class="future">OneHundredthirteen</li>
						<li class="future">OneHundredfourteen</li>
						<li class="future">OneHundredfifteen</li>
						<li class="future">OneHundredsixteen</li>
						<li class="future">OneHundredseventeen</li>
						<li class="future">OneHundredeighteen</li>
						<li class="future">OneHundrednineteen</li>
						<li class="future">OneHundredtwenty</li>
					</ul>
				</article>
			</div>
		</div>
		<div class="content" id="new-quiz-step-3">
			<div class="small-6 columns">1</div>
			<div class="small-6 columns">2</div>
		</div>
		<div class="content" id="new-quiz-step-4">
			<div class="small-4 columns">1</div>
			<div class="small-4 columns">2</div>
			<div class="small-4 columns">3</div>
		</div>
	</div>
</section>

<section>
	
</section>

@stop