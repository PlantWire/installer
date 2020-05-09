<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Redis;

class RequestMeasurement implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $sensor;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(HumiditySensor $sensor)
    {
        $this->sensor = $sensor;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $request = [
            'Type' => 'HumidityMeasurementRequest',
            'Target' => $sensor->uuid,
            'Sender' => env('LORA_UUID'),
            'Content' => []
        ];
        Redis::publish('pwire-server', $request);
    }
}
