<div class="col-12 col-xl-4">
    <div class="blog-side mb-4">
        <div class="card-v">
            <form action="{{ route('blog.index') }}" method="GET">
                <div class="form-search">
                    <input type="text" name="search" class="form-control form-control-md"
                        placeholder="{{ translate('Search…', 'blog') }}" value="{{ request('search') ?? '' }}" required>
                    <button class="icon">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <x-ad alias="blog_sidebar" @class('ad-300x250 mb-4') />
    <div class="blog-side mb-4">
        <div class="card-v">
            <h4 class="card-v-title mb-4">{{ translate('Categories', 'blog') }}</h4>
            <div class="categories">
                @forelse ($blogCategories as $blogCategory)
                    <a href="{{ route('blog.category', $blogCategory->slug) }}" class="category link link-secondary">
                        <span class="category-title">{{ $blogCategory->name }}</span>
                        <i class="fa fa-angle-right"></i>
                    </a>
                @empty
                    <span class="text-muted">{{ translate('No categories found', 'blog') }}</span>
                @endforelse
            </div>
        </div>
    </div>
    <div class="blog-side">
        <div class="card-v">
            <h5 class="card-v-title mb-4">{{ translate('Popular Articles', 'blog') }}</h5>
            <div class="posts">
                @forelse ($popularBlogArticles as $popularBlogArticle)
                    <div class="post">
                        <a href="{{ route('blog.article', $popularBlogArticle->slug) }}">
                            <img class="post-img" src="{{ asset($popularBlogArticle->image) }}"
                                alt="{{ $popularBlogArticle->title }}">
                        </a>
                        <div class="post-info">
                            <h6 class="post-title">
                                <a href="{{ route('blog.article', $popularBlogArticle->slug) }}"
                                    class="link link-secondary">{{ $popularBlogArticle->title }}</a>
                            </h6>
                            <div class="post-meta">
                                <div class="post-meta-item">
                                    <i class="fa-regular fa-calendar"></i>
                                    <time>{{ dateFormat($popularBlogArticle->created_at) }}</time>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <span class="text-muted text-center">{{ translate('No articles found', 'blog') }}</span>
                @endforelse
            </div>
        </div>
    </div>
</div>
