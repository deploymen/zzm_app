@extends('layouts.master')
@extends('components.main-header')
@extends('components.menu-user')
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
	<table>
		<thead>
			<tr>
				<th width="200">Table Header</th>
				<th>Table Header</th>
				<th width="150">Table Header</th>
				<th width="150">Table Header</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>Content Goes Here</td>
				<td>This is longer content Donec id elit non mi porta gravida at eget metus.</td>
				<td>Content Goes Here</td>
				<td>Content Goes Here</td>
			</tr>
			<tr>
				<td>Content Goes Here</td>
				<td>This is longer Content Goes Here Donec id elit non mi porta gravida at eget metus.</td>
				<td>Content Goes Here</td>
				<td>Content Goes Here</td>
			</tr>
			<tr>
				<td>Content Goes Here</td>
				<td>This is longer Content Goes Here Donec id elit non mi porta gravida at eget metus.</td>
				<td>Content Goes Here</td>
				<td>Content Goes Here</td>
			</tr>
		</tbody>
	</table>
</section>

@stop