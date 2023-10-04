<?php


return [
    'providers' => [
        'open-weather-map' => [
            'api_key' => 'b34a93c573a4053fd27c4cd11b044756',
            'url' => 'https://api.openweathermap.org/data/2.5/weather',
        ],
        'accu-weather' => [
            'api_key' => env('ACCU_WEATHER_API_KEY'),
            'url' => 'https://api.example.com/accu-weather',
        ],
        'dark-sky' => [
            'api_key' => env('DARK_SKY_API_KEY'),
            'url' => 'https://api.example.com/dark-sky',
        ],
    ],
];
