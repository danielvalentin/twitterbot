<?php
	if($errors->any())
	{
?>
		<div class="alert alert-danger" role="alert">
			<h4 class="alert-heading">Error</h4>
			<ul>
				<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<li><?php echo e($error); ?></li>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</ul>
		</div>
<?php
	}
	if(session()->has('error'))
	{
?>
		<div class="alert alert-danger" role="alert">
			<h4 class="alert-heading">Error</h4>
			<?php echo e(session('error')); ?>

		</div>
<?php
	}
	if(session()->has('success'))
	{
?>
		<div class="alert alert-success" role="alert">
			<h4 class="alert-heading">Success</h4>
			<?php echo e(session('success')); ?>

		</div>
<?php
	}
	if(session()->has('info'))
	{
?>
		<div class="alert alert-info" role="alert">
			<h4 class="alert-heading">Info</h4>
			<?php echo e(session('info')); ?>

		</div>
<?php
	}
	if(session()->has('warning'))
	{
?>
		<div class="alert alert-warning" role="alert">
			<h4 class="alert-heading">Warning</h4>
			<?php echo e(session('warning')); ?>

		</div>
<?php
	}
	if(session()->has('text'))
	{
?>
		<div class="alert alert-light" role="alert">
			<?php echo e(session('text')); ?>

		</div>
<?php
	}
?>
