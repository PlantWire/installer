<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Event;

class RedisSubscribe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'redis:subscribe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Subscribe to the Redis event channel';

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
        \Illuminate\Support\Facades\Redis::subscribe(['pwire-frontend'], function ($message) {
            $event = new Event();
            $event->content = utf8_encode($message->content);
            $event->save();
            Log::info('Handled event of type '.$message->type.' from '.$message->sender);
        });
    }
}
