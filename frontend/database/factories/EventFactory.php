<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

use App\Event;
use App\HumiditySensor;

$factory->define(Event::class, function (Faker $faker) {
    return [
        'content' => $faker->randomElement(
            $array = array (
                '{ "type": "log", "Sender": "'.$faker->uuid.'", "content": { "LogType": "info", "Message": "This is only a seeder event."}}',
                '{ "type": "humidity_measurement", "Sender": "'.$faker->uuid.'", "content": { "success": 1, "value": 300 }}')),
        'sensor_id' => HumiditySensor::All()->random()->id,
    ];
});
