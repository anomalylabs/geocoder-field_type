<?php

return [
    'api_key' => [
        'name'         => 'API Key',
        'instructions' => 'You can find this information within your app at <a href="https://console.developers.google.com/" target="_blank">Google</a>.',
        'warning'      => 'The specified key must have the Maps JavaScript, Geocoding and Maps Static APIs enabled for it.',
    ],
    'server_api_key' => [
        'name'         => 'Server API Key',
        'instructions' => 'Used for geocoding requests made by the server. When left blank the API Key above is used.',
        'warning'      => 'The specified key must have the Geocoding API enabled for it.',
    ],
];
