<?php
return [
    [
        'title' => 'settings',
        'can' => 'admin.settings.*',
        'children' => [
            [
                'title' => 'OAuth',
                'route' => 'admin.settings.oauth.edit',
            ],
        ],
    ],


];
