<?php
return [
    [
        'title' => 'settings',
        'can' => 'admin.settings.*',
        'children' => [
            [
                'title' => 'ip',
                'route' => 'admin.settings.ips.index',
            ],
        ],
    ],


];
