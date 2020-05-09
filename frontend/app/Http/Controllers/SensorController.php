<?php

namespace App\Http\Controllers;

use App\HumiditySensor;
use App\Http\Requests\StoreSensorRequest;
use Carbon;

class SensorController extends Controller
{
    public function __construct () {
        $this->middleware('auth');
    }

    public function create()
    {
        return view('create-sensor');
    }

    public function store(StoreSensorRequest $request) {

        $uuid = $request->input('uuid');
        $pin = $request->input('pin');
        $name = $request->input('name');

        $humiditySensor = new HumiditySensor();;
        $humiditySensor->uuid = $uuid;
        $humiditySensor->name = $name;
        $humiditySensor->measurement_interval = new CarbonInterval('P0Y0M0DT8H0M0S');
        $humiditySensor->alarm_threshold = 0;
        $humiditySensor->notes = '';
        $humiditySensor->save();

        return redirect()->action('Dashboard@index')->with('success', [__('New Sensor added successfully')]);
    }
}
