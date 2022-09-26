<?php

return [
    'status' => [
        'delete' => 0,
        'active' => 1,
    ],

    'role' => [
        'admin' => 1,
        'user' => 2,
    ],

    'address' => [
        'type' => [
            'company' => 1,
        ]
    ],

    'descriptionRules' => [
        'const' => 1,
        'select' => 2,
        'type' => 3,
        'text' => 4,
        'random' => 5,
        'month_day' => 6,
        'year_month_day' => 7,
        'hours_minutes' => 8,
        'fullYear_month_day' => 9,
        'value' => 10,
        'value_cut' => 11,
    ],
];