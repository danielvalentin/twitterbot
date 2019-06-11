<?php $__env->startSection('content'); ?>

	<h1><?php echo e($account->nickname); ?></h1>
	<?php echo view('partials.alerts'); ?>
	<tweets url="<?php echo e(route('Ajax:twitter:timeline', ['id' => $id])); ?>"></tweets>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>