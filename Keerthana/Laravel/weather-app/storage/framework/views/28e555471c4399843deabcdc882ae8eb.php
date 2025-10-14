<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($data['name']); ?>'s Resume</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
        }
        h1 {
            text-align: center;
            text-decoration: underline;
        }
        .section-title {
            font-weight: bold;
            margin-top: 20px;
            font-size: 18px;
        }
        .content {
            margin-left: 20px;
        }
    </style>
</head>
<body>

    <h1><?php echo e($data['name']); ?>'s Resume</h1>
    
    <p><strong>Email:</strong> <?php echo e($data['email']); ?></p>
    <p><strong>Date:</strong> <?php echo e($data['date']); ?></p>

    <!-- Skills Section -->
    <div class="section-title">Skills:</div>
    <div class="content">
        <ul>
            <?php $__currentLoopData = explode(',', $data['skills']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($skill); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>

    <!-- Education Section -->
    <div class="section-title">Education:</div>
    <div class="content">
        <ul>
            <?php $__currentLoopData = explode(',', $data['education']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $edu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($edu); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>

    <!-- Certificates Section -->
    <div class="section-title">Certificates:</div>
    <div class="content">
        <ul>
            <?php $__currentLoopData = explode(',', $data['certificates']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($cert); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>

    <!-- Projects Section -->
    <div class="section-title">Projects:</div>
    <div class="content">
        <ul>
            <?php $__currentLoopData = explode(',', $data['projects']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($project); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>

    <!-- Hobbies Section -->
    <div class="section-title">Hobbies:</div>
    <div class="content">
        <ul>
            <?php $__currentLoopData = explode(',', $data['hobbies']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hobby): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($hobby); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>

    <!-- Experiences Section -->
    <div class="section-title">Work Experience:</div>
    <div class="content">
        <ul>
            <?php $__currentLoopData = explode(',', $data['experiences']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $experience): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($experience); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>

</body>
</html>
<?php /**PATH C:\Users\LENOVO\Desktop\LARAVEL\laravel-training\Keerthana\Laravel\weather-app\resources\views/Pdf/pdf.blade.php ENDPATH**/ ?>