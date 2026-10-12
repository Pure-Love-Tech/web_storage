<?php
$description = $__env->yieldContent('description') ? $__env->yieldContent('description') : $seoConfiguration->description ?? '';
$keywords = $__env->yieldContent('keywords') ? $__env->yieldContent('keywords') : $seoConfiguration->keywords ?? '';
$ogImage = $__env->yieldContent('og_image') ? $__env->yieldContent('og_image') : asset($themeSettings->general->social_image);
?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<meta name="theme-color" content="<?php echo e($themeSettings->colors->primary_color); ?>">
<meta name="description" content="<?php echo e($description); ?>">
<meta name="keywords" content="<?php echo e($keywords); ?>">
<?php if($seoConfiguration): ?>
<meta name="robots" content="<?php echo e($seoConfiguration->robots_index . ', ' . $seoConfiguration->robots_follow_links); ?>">
<?php endif; ?>
<meta property="og:site_name" content="<?php echo e($settings->general->site_name); ?>">
<meta property="og:type" content="website">
<meta property="og:title" content="<?php echo e(pageTitle($__env)); ?>">
<meta property="og:description" content="<?php echo e($description); ?>">
<meta property="og:image:height" content="600">
<meta property="og:image:width" content="316">
<meta property="og:url" content="<?php echo e(url()->current()); ?>">
<meta property="og:image" content="<?php echo e($ogImage); ?>">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?php echo e(pageTitle($__env)); ?>">
<meta name="twitter:description" content="<?php echo e($description); ?>">
<meta name="twitter:image:src" content="<?php echo e($ogImage); ?>">
<meta name="referrer" content="no-referrer-when-downgrade" /><?php /**PATH /var/www/html/arahcloud/resources/views/themes/basic/includes/meta-tags.blade.php ENDPATH**/ ?>