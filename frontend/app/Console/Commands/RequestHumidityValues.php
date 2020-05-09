<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\HumiditySensor;
use Carbon\Carbon;

class RequestHumidityValues extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'humiditySensor:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Processes all Humidity Sensors and checks if they are due for a refresh.';

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
     * @return mixed
     */
    public function handle()
    {
        HumiditySensor::all()->each(function($sensor) {
            $elapsed_seconds = now()->diff($sensor->measurement_start)->totalSeconds();
            $interval_seconds = $sensor->measurement_interval->seconds;
            if($elapsed_time % $interval_seconds > -60 || $elapsed_time % $interval_seconds < 60) {
                RequestMeasurement::dispatch($sensor);
            }
        });
    }
}
