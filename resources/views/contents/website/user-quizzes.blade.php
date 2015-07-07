@extends('layouts.master')
@extends('components.main-header')
@extends('components.menu-user', ['sidebar_item' => 'view_quiz'])
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

<div class="row">
	<div class="small-12 columns">
		<form action="">
			<table width="100%">
				<thead>
					<tr>
						<th colspan="5">Edit Information</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td width="50">
							<input id="checkbox1" type="checkbox"><label for="checkbox1"></label>
						</td>
						<td>Quiz1</td>
						<td width="150">
							<a href="javascript:void(0)" class="button tiny">Edit General</a>
						</td>
						<td width="150">
							<a href="javascript:void(0)" class="button tiny">Edit Questions</a>
						</td>
						<td width="150">
							<a href="javascript:void(0)" class="button tiny">Edit Participants</a>
						</td>
					</tr>
					<tr>
						<td width="50">
							<input id="checkbox1" type="checkbox"><label for="checkbox1"></label>
						</td>
						<td>Quiz2</td>
						<td width="150">
							<a href="javascript:void(0)" class="button tiny">Edit General</a>
						</td>
						<td width="150">
							<a href="javascript:void(0)" class="button tiny">Edit Questions</a>
						</td>
						<td width="150">
							<a href="javascript:void(0)" class="button tiny">Edit Participants</a>
						</td>
					</tr>
					<tr>
						<td width="50">
							<input id="checkbox1" type="checkbox"><label for="checkbox1"></label>
						</td>
						<td>Quiz3</td>
						<td width="150">
							<a href="javascript:void(0)" class="button tiny">Edit General</a>
						</td>
						<td width="150">
							<a href="javascript:void(0)" class="button tiny">Edit Questions</a>
						</td>
						<td width="150">
							<a href="javascript:void(0)" class="button tiny">Edit Participants</a>
						</td>
					</tr>
					<tr>
						<td width="50">
							<input id="checkbox1" type="checkbox"><label for="checkbox1"></label>
						</td>
						<td>Quiz4</td>
						<td width="150">
							<a href="javascript:void(0)" class="button tiny">Edit General</a>
						</td>
						<td width="150">
							<a href="javascript:void(0)" class="button tiny">Edit Questions</a>
						</td>
						<td width="150">
							<a href="javascript:void(0)" class="button tiny">Edit Participants</a>
						</td>
					</tr>
					<tr>
						<td width="50">
							<input id="checkbox1" type="checkbox"><label for="checkbox1"></label>
						</td>
						<td>Quiz5</td>
						<td width="150">
							<a href="javascript:void(0)" class="button tiny">Edit General</a>
						</td>
						<td width="150">
							<a href="javascript:void(0)" class="button tiny">Edit Questions</a>
						</td>
						<td width="150">
							<a href="javascript:void(0)" class="button tiny">Edit Participants</a>
						</td>
					</tr>
				</tbody>
			</table>
			<div class="small-12 columns">
				<div class="small-6 columns">
					<button class="alert">Delete</button>
				</div>
				<div class="small-6 columns">
					<button class="">Enable</button>
				</div>
			</div>
		</form>
	</div><!--content-group-inner-->
</div>

@stop