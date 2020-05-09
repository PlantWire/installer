<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Events\SensorChanged;

class HumiditySensor extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'name', 'alarm_threshold' ,'notes', 'measurement_start', 'measurement_interval',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'measurement_start' => 'datetime',
        'measurement_interval' => \App\Casts\CarbonInterval::class
    ];

    /**
     * Get the measurements of this sensor
     */
    public function measurements()
    {
        return $this->hasMany('App\HumidityMeasurement');
    }

    /**
     * Get the events of this sensor
     */
    public function events()
    {
        return $this->hasMany('App\Event');
    }
}
