<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Event;
use App\HumiditySensor;

use Carbon\CarbonInterval;

class Dashboard extends Controller
{
    public function index()
    {
        return view('dashboard', ['events' => Event::all(), 'sensors'=> HumiditySensor::with('measurements')->get()]);
    }
}
