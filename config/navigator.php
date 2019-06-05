<?php

return [

    //TODO: For demo, remove!
    'menu' => [
        [
            'title' => 'Menu 1',
            'link' => 'test',
            'route' => 'index',
            'order' => 2,
            'children' => [
                [
                    'title' => 'Menu 2',
                    'link' => 'test',
                    'order' => 2,
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
        ],[
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
                            'link' => 'test'
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
