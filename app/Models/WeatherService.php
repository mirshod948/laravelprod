<?php

namespace App\Models;

use App\Mail\SendMail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use Illuminate\Mail\Message;
class WeatherService extends Model
{
    use HasFactory;

    public function getCurrentWeatherOpen($provider, $city)
    {
        $apiKey = config("weather.providers.$provider.api_key");
        $url = config("weather.providers.$provider.url");
        if ($provider == 'open-weather-map'){
            $response = Http::get($url, [
                'q' => $city,
                'appid' => $apiKey,
            ]);
        }
        return $response->json();
    }

    public function getCurrentWeatherAccu($provider, $city)
    {
        $apiKey = config("weather.providers.$provider.api_key");
        $url = config("weather.providers.$provider.url");
        if ($provider == 'accu-weather'){
            $response = Http::get($url, [
                'q' => $city,
                'apikey' => $apiKey,
            ]);
        }

        return $response->json();
    }
    public function getCurrentWeatherDark($provider, $city)
    {
        $apiKey = config("weather.providers.$provider.api_key");
        $url = config("weather.providers.$provider.url");
        if ($provider == 'dark-sky'){
            $response = Http::get($url, [
                'key' => $apiKey,
                'q' => $city,
                'aqi'=>'yes'
            ]);
        }

        return $response->json();
    }

    public function sendTextMessage($chatId, $message)
    {
        $botToken = env('BOT_TOKEN');
        $url = "https://api.telegram.org/bot{$botToken}/sendMessage";
        $response = Http::post($url, [
            'chat_id' => $chatId,
            'text' => $message,
        ]);

        // Handle the response as needed
        if ($response->successful()) {
            return response()->json(['status' => 'Message sent successfully']);
        } else {
            $errorResponse = json_decode($response->getBody(), true);
            return response()->json(['status' => 'Failed to send message', 'error' => $errorResponse], $response->status());
        }

    }

    public function html_email($chatId, $info) {
        $receiver = $chatId; // Jo'natuvchi pochta manzili
        $mailData = [
            'title' => 'Oba-havo malumotlari',
            'content' => $info,
        ];
        Mail::raw($mailData['content'], function (Message $message) use ($receiver, $mailData) {
            $message->to($receiver)
                ->subject($mailData['title']);
        });
    }



}
