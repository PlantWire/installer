<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content',
    ];

    /**
     * Get the sensor this event belongs to
     */
    public function sensor()
    {
        return $this->belongsTo('App\HumiditySensor');
    }
}
