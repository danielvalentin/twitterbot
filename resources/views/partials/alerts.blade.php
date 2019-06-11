<?php
	if($errors->any())
	{
?>
		<div class="alert alert-danger" role="alert">
			<h4 class="alert-heading">Error</h4>
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
<?php
	}
	if(session()->has('error'))
	{
?>
		<div class="alert alert-danger" role="alert">
			<h4 class="alert-heading">Error</h4>
			{{ session('error') }}
		</div>
<?php
	}
	if(session()->has('success'))
	{
?>
		<div class="alert alert-success" role="alert">
			<h4 class="alert-heading">Success</h4>
			{{ session('success') }}
		</div>
<?php
	}
	if(session()->has('info'))
	{
?>
		<div class="alert alert-info" role="alert">
			<h4 class="alert-heading">Info</h4>
			{{ session('info') }}
		</div>
<?php
	}
	if(session()->has('warning'))
	{
?>
		<div class="alert alert-warning" role="alert">
			<h4 class="alert-heading">Warning</h4>
			{{ session('warning') }}
		</div>
<?php
	}
	if(session()->has('text'))
	{
?>
		<div class="alert alert-light" role="alert">
			{{ session('text') }}
		</div>
<?php
	}
?>
