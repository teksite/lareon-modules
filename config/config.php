<?php

return [
    'name' => 'Page',
    'sitemap' => [
        'models' => [
            'page'=>[
                'model' => \Lareon\Modules\Page\App\Models\Page::class,
                'priority' => 0.6,
                'group' => 'page',
                'changefreq' => 'yearly',

            ]
        ]
    ]
];
