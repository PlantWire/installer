<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

use App\HumidityMeasurement;
use App\HumiditySensor;

$factory->define(HumidityMeasurement::class, function (Faker $faker) {
    return [
        'value' => $faker->numberBetween($min = 100, $max = 1700) ,
        'humidity_sensor_id' => HumiditySensor::All()->random()->id,
    ];
});
