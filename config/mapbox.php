<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Google Maps API Key
    |--------------------------------------------------------------------------
    |
    | This value is the API key for Google Maps JavaScript API. This key is used
    | for rendering maps and accessing Google Maps services. You can generate a
    | key from the Google Cloud Console.
    |
    */
    'api_key' => env('GOOGLE_MAPS_API_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | Default Map Settings
    |--------------------------------------------------------------------------
    |
    | These are the default map settings to use across the application.
    |
    */
    'defaults' => [
        'center' => [
            'lat' => env('GOOGLE_MAPS_DEFAULT_LAT', 6.5244),
            'lng' => env('GOOGLE_MAPS_DEFAULT_LNG', 3.3792),
        ],
        'zoom' => env('GOOGLE_MAPS_DEFAULT_ZOOM', 12),
    ],

    /*
    |--------------------------------------------------------------------------
    | Map Options
    |--------------------------------------------------------------------------
    |
    | Additional options for the Google Maps instance.
    |
    */
    'options' => [
        'mapTypeId' => 'roadmap', // Options: roadmap, satellite, hybrid, terrain
        'mapTypeControl' => true,
        'streetViewControl' => true,
        'fullscreenControl' => true,
    ],
];
