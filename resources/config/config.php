<?php

return [
    'zoom'   => [
        'type'   => 'anomaly.field_type.slider',
        'config' => [
            'min'           => 0,
            'max'           => 21,
            'default_value' => 13,
        ],
    ],
    'height' => [
        'type'   => 'anomaly.field_type.integer',
        'config' => [
            'max'           => 1000,
            'min'           => 50,
            'step'          => 1,
            'default_value' => 200,
        ],
    ],
];
