<?php
return [
    [
        'title' => 'SEO',
        'icon' => 'magnifier',
        'children' => [
            [
                'title' => 'robot.txt',
                'route' => 'admin.seo.robot.edit',
            ],
            [
                'title' => 'sitemap',
                'route' => 'admin.seo.sitemap.index',
            ],
            [
                'title' => 'website',
                'route' => 'admin.seo.site.edit',
            ],
        ],
    ],
];
