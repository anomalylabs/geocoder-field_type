<?php

return [
    'zoom'   => [
        'type'   => 'anomaly.field_type.slider',
        'config' => [
            'min' => 0,
            'max' => 21,
        ],
    ],
    'height' => [
        'type'   => 'anomaly.field_type.integer',
        'config' => [
            'min'  => 200,
            'step' => 10,
        ],
    ],
];
