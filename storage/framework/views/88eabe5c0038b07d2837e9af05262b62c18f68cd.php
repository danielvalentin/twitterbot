<?php $__env->startSection('content'); ?>

	<h1>some.accounts</h1>
	<?php echo view('partials.alerts'); ?>


	<?php if(count($accounts) > 0): ?>
		<ul>
			<?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<li>
					<?php if($account->media == 'twitter'): ?>
						<a href="<?php echo e(route('Twitter:switchaccount', ['media_id' => $account->media_id])); ?>">
							<icon type="<?php echo e($account->media); ?>" /></icon>
							<?php echo e($account->name()); ?>

						</a>
					<?php endif; ?>
					<?php if($account->media == 'facebook'): ?>
						<a href="<?php echo e(route('Facebook:switchaccount', ['media_id' => $account->media_id])); ?>">
							<icon type="<?php echo e($account->media); ?>" /></icon>
							<?php echo e($account->name()); ?>

						</a>
					<?php endif; ?>
				</li>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</ul>
	<?php else: ?>
		<p><em>Du har ikke tilføjet nogle kontoer endnu.</em></p>
	<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>