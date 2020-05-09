<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\HumiditySensor;
use Carbon\Carbon;
use Carbon\CarbonInterval;

$factory->define(HumiditySensor::class, function (Faker $faker) {
    return [
        'uuid' => $faker->uuid,
        'name' => $faker->word,
        'alarm_threshold' => $faker->randomDigitNotNull,
        'notes' => $faker->sentence,
        'measurement_start' => new Carbon($faker->dateTime($max = 'now', $timezone = null)),
        'measurement_interval' => CarbonInterval::hours($faker->numberBetween($min = 1, $max = 24)),
    ];
});
