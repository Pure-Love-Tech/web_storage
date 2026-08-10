<div class="blog-post h-100">
    <div class="blog-post-header">
        <a href="{{ route('blog.article', $post->slug) }}">
            <img src="{{ asset($post->image) }}" alt="{{ $post->title }}" class="blog-post-img">
        </a>
    </div>
    <div class="blog-post-body">
        <div class="blog-post-time">
            <time>{{ dateFormat($post->created_at) }}</time>
        </div>
        <a href="{{ route('blog.article', $post->slug) }}" class="blog-post-title">
            <h5>{{ $post->title }}</h5>
        </a>
        <p class="blog-post-text">{{ $post->short_description }}</p>
        <div class="mt-auto">
            <a href="{{ route('blog.article', $post->slug) }}" class="link link-secondary">
                {{ translate('Read More', 'blog') }} <i class="fa fa-arrow-right fa-sm ms-1"></i>
            </a>
        </div>
    </div>
</div>
