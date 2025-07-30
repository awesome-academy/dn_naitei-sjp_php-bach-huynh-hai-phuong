<?php
return [
    'admin_panel' => [
        [
            'groupLabel' => false,
            'menu' => [
                [
                    'href' => '/dashboard',
                    'label' => 'layout.dashboard',
                    'icon' => 'fas-square-poll-vertical',
                ]
            ]
        ],
        [
            'groupLabel' => 'course.courses',
            'menu' => [
                [
                    'href' => '/courses',
                    'label' => 'course.all_courses',
                    'icon' => 'fas-lines-leaning',
                ],
                [
                    'href' => '/courses/create',
                    'label' => 'course.create_course',
                    'icon' => 'fas-plus',
                ],
            ]
        ],
        [
            'groupLabel' => 'subject.subjects',
            'menu' => [
                [
                    'href' => '/subjects',
                    'label' => 'subject.all_subjects',
                    'icon' => 'fas-book',
                ],
                [
                    'href' => '/subjects/create',
                    'label' => 'subject.create_subject',
                    'icon' => 'fas-plus',
                ],
            ]
        ],
    ]
];
