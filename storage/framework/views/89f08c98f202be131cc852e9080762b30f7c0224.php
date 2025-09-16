

<?php $__env->startSection('content'); ?>
<div class="container">
    <h2>Admin / Reviewer Dashboard</h2>

    <a href="<?php echo e(route('interviews.create')); ?>" class="btn btn-primary mb-3">+ Create Interview</a>

    <h4>All Interviews</h4>
    <?php $__empty_1 = true; $__currentLoopData = $interviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $iv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="card mb-2">
            <div class="card-body">
                <h5><?php echo e($iv->title); ?></h5>
                <p><?php echo e($iv->description); ?></p>
                <a href="<?php echo e(route('interviews.show', $iv)); ?>" class="btn btn-sm btn-outline-secondary">View</a>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <p>No interviews created yet.</p>
    <?php endif; ?>

    <hr>
    <a href="<?php echo e(route('reviewer.submissions')); ?>" class="btn btn-success">Review Submissions</a>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\video\resources\views/dashboard/admin.blade.php ENDPATH**/ ?>