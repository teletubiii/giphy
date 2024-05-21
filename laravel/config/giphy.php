<?php

return [

   /*
    |--------------------------------------------------------------------------
    | Giphy Configuration
    |--------------------------------------------------------------------------
    |
    | This option defines the base URL and the API key for the Giphy API.
    | You may change these values as required.
    |
    */

    'base_url' => env('GIPHY_BASE_URL', 'https://api.giphy.com/v1/'),
    'api_key' => env('GIPHY_API_KEY', 'default_api_key'),
];