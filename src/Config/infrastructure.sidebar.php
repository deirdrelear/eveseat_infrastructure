<?php

return [
    'infrastructure' => [
        'name'          => 'Infrastructure',
        'icon'          => 'fas fa-cat',
        'route_segment' => 'infrastructure',
        'permission' => 'infrastructure.infrastructure',
        'entries'       => [
            // Corporation
            [
                'name'  => 'Corporations Stations',
                'icon'  => 'fas fa-info',
                'route' => 'infrastructure.corporation_dockstructures',
                'permission' => 'infrastructure.corporation',
            ],
            [
                'name'  => 'Corporations Navigation Structures',
                'icon'  => 'fas fa-info',
                'route' => 'infrastructure.corporation_navstructures',
                'permission' => 'infrastructure.infrastructure',
            ],
            [
                'name'  => 'Corporations IHubs',
                'icon'  => 'fas fa-info',
                'route' => 'infrastructure.corporation_ihubs',
                'permission' => 'infrastructure.corporation',
            ],
            [
                'name'  => 'Corporations Metenoxes',
                'icon'  => 'fas fa-info',
                'route' => 'infrastructure.corporation_miningstructures',
                'permission' => 'infrastructure.corporation',
            ],

            // Alliance
            [
                'name'  => 'Alliance Corporations Stations',
                'icon'  => 'fas fa-info',
                'route' => 'infrastructure.alliance_dockstructures',
                'permission' => 'infrastructure.alliance',
            ],
            [
                'name'  => 'Alliance Navigation Structures',
                'icon'  => 'fas fa-info',
                'route' => 'infrastructure.alliance_navstructures',
                'permission' => 'infrastructure.alliance',
            ],
            [
                'name'  => 'Alliance IHubs',
                'icon'  => 'fas fa-info',
                'route' => 'infrastructure.alliance_ihubs',
                'permission' => 'infrastructure.alliance',
            ],
            [
                'name'  => 'Alliance Corporations Metenoxes',
                'icon'  => 'fas fa-info',
                'route' => 'infrastructure.alliance_miningstructures',
                'permission' => 'infrastructure.alliance',
            ],
            /*
            // Global
            [
                'name'  => 'All Stations',
                'icon'  => 'fas fa-info',
                'route' => 'infrastructure.global_dockstructures',
                'permission' => 'infrastructure.global',
            ],
            [
                'name'  => 'All Navigation Strcutures',
                'icon'  => 'fas fa-info',
                'route' => 'infrastructure.global_navstructures',
                'permission' => 'infrastructure.global',
            ],
            [
                'name'  => 'All IHubs',
                'icon'  => 'fas fa-info',
                'route' => 'infrastructure.global_ihubs',
                'permission' => 'infrastructure.global',
            ],
            [
                'name'  => 'All Metenoxes',
                'icon'  => 'fas fa-info',
                'route' => 'infrastructure.global_miningstructures',
                'permission' => 'infrastructure.global',
            ],*/
        ]
    ]
];
