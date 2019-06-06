<?php

return [

    'keys' => [
        'order' => 'order', // ordering by parameter
        'children' => 'children', // sub menu items
        'route' => 'route', // route name
        'link' => 'link', // item link url
        'title' => 'title', // item title
        'attr' => 'attr', // additional item attributes
    ],

    //TODO: For demo, remove!
    'menu' => [
        [
            'title' => 'Menu 1',
            'link' => 'test',
            'route' => 'login',
            'order' => 2,
            'children' => [
                [
                    'title' => 'Menu 2',
                    'link' => 'test',
                    'order' => 2,
                    'route' => 'register',
                    'attr' => [
                        'link' => 'test',
                        'class' => 'some class'
                    ]
                ],[
                    'title' => 'Menu 3',
                    'link' => 'test 3',
                    'order' => 1
                ]
            ]
        ],
        [
            'title' => 'Menu 4',
            'link' => 'test',
            'order' => 1,
            'children' => [
                [
                    'title' => 'Menu 5',
                    'link' => 'test'
                ],[
                    'title' => 'Menu 6',
                    'link' => 'test',
                    'children' => [
                        [
                            'title' => 'Menu 7',
                            'link' => 'test',
                            'route' => 'unknown',
                        ],[
                            'title' => 'Menu 8',
                            'link' => 'test'
                        ]
                    ]
                ]
            ]
        ],
    ]

];
