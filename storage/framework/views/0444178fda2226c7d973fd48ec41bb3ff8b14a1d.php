<?php $__env->startSection('title', translate('My Files', 'files')); ?>
<?php $__env->startSection('content'); ?>
    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('files.files-table', [])->html();
} elseif ($_instance->childHasBeenRendered('DpQsiRC')) {
    $componentId = $_instance->getRenderedChildComponentId('DpQsiRC');
    $componentTag = $_instance->getRenderedChildComponentTagName('DpQsiRC');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('DpQsiRC');
} else {
    $response = \Livewire\Livewire::mount('files.files-table', []);
    $html = $response->html();
    $_instance->logRenderedChild('DpQsiRC', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('files.folder-modal', [])->html();
} elseif ($_instance->childHasBeenRendered('szarGNB')) {
    $componentId = $_instance->getRenderedChildComponentId('szarGNB');
    $componentTag = $_instance->getRenderedChildComponentTagName('szarGNB');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('szarGNB');
} else {
    $response = \Livewire\Livewire::mount('files.folder-modal', []);
    $html = $response->html();
    $_instance->logRenderedChild('szarGNB', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('files.share-modal', [])->html();
} elseif ($_instance->childHasBeenRendered('hDI648Y')) {
    $componentId = $_instance->getRenderedChildComponentId('hDI648Y');
    $componentTag = $_instance->getRenderedChildComponentTagName('hDI648Y');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('hDI648Y');
} else {
    $response = \Livewire\Livewire::mount('files.share-modal', []);
    $html = $response->html();
    $_instance->logRenderedChild('hDI648Y', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('files.edit-modal', [])->html();
} elseif ($_instance->childHasBeenRendered('eJFYG7U')) {
    $componentId = $_instance->getRenderedChildComponentId('eJFYG7U');
    $componentTag = $_instance->getRenderedChildComponentTagName('eJFYG7U');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('eJFYG7U');
} else {
    $response = \Livewire\Livewire::mount('files.edit-modal', []);
    $html = $response->html();
    $_instance->logRenderedChild('eJFYG7U', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('files.move-modal', [])->html();
} elseif ($_instance->childHasBeenRendered('fBf0QPr')) {
    $componentId = $_instance->getRenderedChildComponentId('fBf0QPr');
    $componentTag = $_instance->getRenderedChildComponentTagName('fBf0QPr');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('fBf0QPr');
} else {
    $response = \Livewire\Livewire::mount('files.move-modal', []);
    $html = $response->html();
    $_instance->logRenderedChild('fBf0QPr', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
    <?php $__env->startPush('head_codes'); ?>
        <?php echo \Livewire\Livewire::styles(); ?>

    <?php $__env->stopPush(); ?>
    <?php $__env->startPush('scripts'); ?>
        <?php echo \Livewire\Livewire::scripts(); ?>

        <script src="<?php echo e(theme_asset('assets/js/filemanager.js')); ?>"></script>
        <script src="<?php echo e(asset('vendor/libs/clipboard/clipboard.min.js')); ?>"></script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.basic.user.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/arahcloud/resources/views/themes/basic/user/files/index.blade.php ENDPATH**/ ?>