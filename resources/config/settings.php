<?php

return [
    'api_key' => [
        'required' => true,
        'env'      => 'GEOCODER_KEY',
        'type'     => 'anomaly.field_type.encrypted',
        'bind'     => 'anomaly.field_type.geocoder::google.key',
    ],
    'server_api_key' => [
        'env'  => 'GEOCODER_SERVER_KEY',
        'type' => 'anomaly.field_type.encrypted',
        'bind' => 'anomaly.field_type.geocoder::google.server_key',
    ],
];
