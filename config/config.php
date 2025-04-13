<?php

return [
    'name' => 'Blog',
    'sitemap' => [
        'models' => [
            [
                'model' => \Lareon\Modules\Blog\App\Models\Post::class,
                'priority' => 0.7,
                'group' => 'blog_post',
                'changefreq' => 'monthly',
            ]
        ],
        'singles' => [
            [
                'route' => 'blog.posts.index',
                'title' => 'Blog Posts',
                'priority' => 0.6,
                'changefreq' => 'weekly',
                'group' => 'blog_post',
                'active'=>now(),
            ]
        ]
    ]
];
