@extends('layouts.master')
@extends('components.main-header')
@extends('components.menu-user', ['sidebar_item' => 'change_password'])
@extends('components.main-footer')

@section('css_include')
<style type="text/css">

</style>
@stop

@section('js_include')
<script type="text/javascript">
    
</script>
@stop

<!-- @section('breadcrumb')
<nav class="breadcrumbs" role="menubar" aria-label="breadcrumbs">
   <li role="menuitem">
       <a href="/user/home"><i class="fa fa-home"></i>&nbsp;Home</a>
   </li>
   <li role="menuitem" class="current">
       <a href="#">Change Password</a>
   </li>
</nav>
@stop -->

@section('content')

<section class="row">
	<div class="content-group small-12 columns">
		<h3 class="content-group--heading">Change Password</h3>
		<div class="content-group--content">
			<form action="" id="change-password-form" class="change-password-form">
				<div class="row">
					<div class="small-12 columns">
						<label>Old Password
							<input type="text" placeholder="What is the password you use right now?" />
						</label>
						<label>New Password
							<input type="text" placeholder="Pick a secure new password" />
						</label>
						<label>Confirm New Password
							<input type="text" placeholder="Confirm your secure new password" />
						</label>
					</div>
					<div class="small-12 columns">
						<input type="submit" value="Confirm" class="button radius">
					</div>
				</div>
			</form>
		</div>
	</div><!--content-group-->
</section>

@stop