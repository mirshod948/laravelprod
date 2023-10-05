<?php

namespace App\Console\Commands;

use App\Models\WeatherService;
use Illuminate\Console\Command;

class GetWeather extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather {provider} {city} {channel?}';
    protected $description = 'Get the current weather for a given city using a weather provider';

    /**
     * The console command description.
     *
     * @var string
     */

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $provider = $this->argument('provider');
        $city = $this->argument('city');
        $channel = $this->argument('channel');
        $weatherService = new WeatherService();
        $parsedChannel = strtok($channel, ':');
        $chatId = strtok(':');

        if ($parsedChannel === 'telegram' && $chatId) {
            $info = $weatherService->getCurrentWeatherAccu($provider, $city);
            $res = $weatherService->sendTextMessage($chatId, $info);
            $this->info("Sending weather data to Telegram chat_id: {$res}");
        } else if ($parsedChannel === 'mail') {
            // Handle Mail channel
            // Send the weather data to the provided email address
        //    $res = $weatherService->getCurrentWeatherDark($provider, $city);
            $info = $weatherService->getCurrentWeatherDark($provider, $city);
            $mail = $weatherService->html_email($chatId, $info);

            $this->info("Sending weather data to email: {$mail}");
        } else {
            $weatherData = $weatherService->getCurrentWeatherOpen($provider, $city);
            $this->info('Weather data: ' . json_encode($weatherData, JSON_PRETTY_PRINT));
        }

    }
}
