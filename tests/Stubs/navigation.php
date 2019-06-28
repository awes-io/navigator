<?php

return [

    'menu' => [
        [
            'name' => 'Menu 1',
            'link' => 'test',
            'route' => 'login',
            'order' => 2,
            'children' => 
            [
                [
                    'name' => 'Menu 2',
                    'link' => 'test',
                    'order' => 2,
                    'attr' => 
                    [
                        'link' => 'test',
                        'class' => 'some class'
                    ]
                ],[
                    'name' => 'Menu 3',
                    'link' => 'test 3',
                    'order' => 1,
                    'route' => 'test'
                ]
            ]
        ],
        [
            'name' => 'Menu 4',
            'link' => 'test',
            'order' => 1,
            'depth' => 1,
            'children' => 
            [
                [
                    'name' => 'Menu 5',
                    'link' => 'test'
                ],
                [
                    'name' => 'Menu 6',
                    'link' => 'test',
                    'route' => 'test',
                    'children' => 
                    [
                        [
                            'name' => 'Menu 7',
                            'link' => 'test',
                            'route' => 'unknown',
                        ],
                        [
                            'name' => 'Menu 8',
                            'link' => 'test',
                            'route' => 'register',
                        ]
                    ]
                ]
            ]
        ],
    ]

];
