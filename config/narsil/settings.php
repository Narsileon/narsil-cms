<?php

return [
    'content' => [
        [
            'label'    => 'ui.system',
            'children' => [
                [
                    'icon'  => 'globe',
                    'label' => 'ui.sites',
                    'route' => 'sites.index',
                ],
            ],
        ],
        [
            'label'    => 'ui.content',
            'children' => [
                [
                    'icon'  => 'square-pen',
                    'label' => 'ui.fields',
                    'route' => 'sites.index',
                ],
            ],
        ],
    ],
];
