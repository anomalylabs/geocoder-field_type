<?php

return [
    'cache_time' => [
        'type'     => 'anomaly.field_type.integer',
        'required' => true,
        'config'   => [
            'default_value' => 60,
            'min' => 0
        ],
    ],
];
