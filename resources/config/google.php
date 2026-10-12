<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Google Maps API Key
    |--------------------------------------------------------------------------
    |
    | Specify your Google Maps API key: https://console.developers.google.com/
    |
    */
    'key' => env('GEOCODER_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Google Geocoding API Server Key
    |--------------------------------------------------------------------------
    |
    | Specify the key used for geocoding requests made by the server.
    | When not specified the Google Maps API key above is used.
    |
    */
    'server_key' => env('GEOCODER_SERVER_KEY'),

];
