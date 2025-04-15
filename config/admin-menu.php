<?php
return [
    [
        'title' => 'questionnaire',
        'icon' => 'paper-board',
        'canany' => 'admin.questionnaire.*',
        'children' => [
            [
                'title' => 'forms',
                'route' => 'admin.questionnaire.forms.index',
            ], [
                'title' => 'inboxes',
                'route' => 'admin.questionnaire.inboxes.index',
            ], [
                'title' => 'export',
                'route' => 'admin.questionnaire.inboxes.export.index',
            ], [
                'title' => 'analytics',
                'route' => 'admin.questionnaire.inboxes.analytics.show',
            ],
        ],
    ],


];
