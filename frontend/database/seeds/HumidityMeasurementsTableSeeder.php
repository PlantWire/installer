<?php

use Illuminate\Database\Seeder;

class HumidityMeasurementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\HumidityMeasurement::class, 30)->create();
    }
}
