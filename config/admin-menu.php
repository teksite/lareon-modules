<?php
return [
    [
        'title' => 'settings',
        'can' => 'admin.settings.*',
        'children' => [
            [
                'title' => 'captcha',
                'route' => 'admin.settings.captcha.read',
            ],
        ],
    ],


];
