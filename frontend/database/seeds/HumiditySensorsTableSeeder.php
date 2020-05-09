<?php

use Illuminate\Database\Seeder;

class HumiditySensorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\HumiditySensor::class, 10)->create();
    }
}
