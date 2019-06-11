<?php $__env->startSection('content'); ?>

<ul>
	<li>
		<a href="<?php echo e(route('Some:accounts')); ?>">Accounts</a>
	</li>
</ul>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>