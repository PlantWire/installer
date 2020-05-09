<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HumidityMeasurement extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'value',
    ];

    /**
     * Get the sensor this measurement belongs to
     */
    public function sensor()
    {
        return $this->belongsTo('App\HumiditySensor');
    }
}
