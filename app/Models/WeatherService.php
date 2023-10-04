<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class WeatherService extends Model
{
    use HasFactory;

    public function getCurrentWeather($provider, $city)
    {
        $apiKey = config("weather.providers.$provider.api_key");
        $url = config("weather.providers.$provider.url");
        $response = Http::get($url, [
            'q' => $city,
            'appid' => $apiKey,
        ]);

        return $response->json();
    }
}
