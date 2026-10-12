<div class="col-12 col-xl-4">
    <div class="blog-side mb-4">
        <div class="card-v">
            <form action="<?php echo e(route('blog.index')); ?>" method="GET">
                <div class="form-search">
                    <input type="text" name="search" class="form-control form-control-md"
                        placeholder="<?php echo e(translate('Search…', 'blog')); ?>" value="<?php echo e(request('search') ?? ''); ?>" required>
                    <button class="icon">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <?php if (isset($component)) { $__componentOriginal6af478c7ec7046868d2234c9526963584eafd3a9 = $component; } ?>
<?php $component = App\View\Components\Ad::resolve(['alias' => 'blog_sidebar'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('ad'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Ad::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(\Illuminate\Support\Arr::toCssClasses('ad-300x250 mb-4'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6af478c7ec7046868d2234c9526963584eafd3a9)): ?>
<?php $component = $__componentOriginal6af478c7ec7046868d2234c9526963584eafd3a9; ?>
<?php unset($__componentOriginal6af478c7ec7046868d2234c9526963584eafd3a9); ?>
<?php endif; ?>
    <div class="blog-side mb-4">
        <div class="card-v">
            <h4 class="card-v-title mb-4"><?php echo e(translate('Categories', 'blog')); ?></h4>
            <div class="categories">
                <?php $__empty_1 = true; $__currentLoopData = $blogCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blogCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <a href="<?php echo e(route('blog.category', $blogCategory->slug)); ?>" class="category link link-secondary">
                        <span class="category-title"><?php echo e($blogCategory->name); ?></span>
                        <i class="fa fa-angle-right"></i>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <span class="text-muted"><?php echo e(translate('No categories found', 'blog')); ?></span>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="blog-side">
        <div class="card-v">
            <h5 class="card-v-title mb-4"><?php echo e(translate('Popular Articles', 'blog')); ?></h5>
            <div class="posts">
                <?php $__empty_1 = true; $__currentLoopData = $popularBlogArticles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $popularBlogArticle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="post">
                        <a href="<?php echo e(route('blog.article', $popularBlogArticle->slug)); ?>">
                            <img class="post-img" src="<?php echo e(asset($popularBlogArticle->image)); ?>"
                                alt="<?php echo e($popularBlogArticle->title); ?>">
                        </a>
                        <div class="post-info">
                            <h6 class="post-title">
                                <a href="<?php echo e(route('blog.article', $popularBlogArticle->slug)); ?>"
                                    class="link link-secondary"><?php echo e($popularBlogArticle->title); ?></a>
                            </h6>
                            <div class="post-meta">
                                <div class="post-meta-item">
                                    <i class="fa-regular fa-calendar"></i>
                                    <time><?php echo e(dateFormat($popularBlogArticle->created_at)); ?></time>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <span class="text-muted text-center"><?php echo e(translate('No articles found', 'blog')); ?></span>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /var/www/html/arahcloud/resources/views/themes/basic/blog/includes/sidebar.blade.php ENDPATH**/ ?>