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
        //var_dump($provider, $city, $channel);
        $weatherService = new WeatherService();
        $weatherData = $weatherService->getCurrentWeather($provider, $city);

        // Handle sending weather data to the specified channel (mail, telegram, console)
        // Based on the channel, you can implement the appropriate logic here.

        $this->info('Weather data: ' . json_encode($weatherData, JSON_PRETTY_PRINT));
    }
}
