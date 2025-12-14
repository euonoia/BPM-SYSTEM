<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <!-- Link external CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('css/landing.css')); ?>">
</head>
<body>
    <h1>Welcome to the Landing Page</h1>

    <h2>Core Modules</h2>
    <ul>
        <li><a href="<?php echo e(route('core.core1.index')); ?>">Go to Core1 Index</a></li>
        <li><a href="<?php echo e(route('core.core2.index')); ?>">Go to Core2 Index</a></li>
    </ul>

    <h2>Logistics Modules</h2>
    <ul>
        <li><a href="<?php echo e(route('logistics.logistics1.index')); ?>">Go to Logistics1 Index</a></li>
        <li><a href="<?php echo e(route('logistics.logistics2.index')); ?>">Go to Logistics2 Index</a></li>
    </ul>

    <h2>HR Modules</h2>
    <ul>
        <li><a href="<?php echo e(route('hr.hr1.index')); ?>">Go to HR1 Index</a></li>
        <li><a href="<?php echo e(route('hr.hr2.index')); ?>">Go to HR2 Index</a></li>
        <li><a href="<?php echo e(route('hr.hr3.index')); ?>">Go to HR3 Index</a></li>
        <li><a href="<?php echo e(route('hr.hr4.index')); ?>">Go to HR4 Index</a></li>
    </ul>

    <h2>Financial Module</h2>
    <ul>
        <li><a href="<?php echo e(route('financials.index')); ?>">Go to Financials Index</a></li>
    </ul>

    <h2>Other Modules</h2>
    <ul>
        <li><a href="<?php echo e(route('patients.index')); ?>">Go to Patients</a></li>
        <li><a href="<?php echo e(url('/')); ?>">Back to Home</a></li>
    </ul>
</body>
</html>
<?php /**PATH /var/www/resources/views/index.blade.php ENDPATH**/ ?>