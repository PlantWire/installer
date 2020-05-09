@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <section class="section">
        <div class="container">
            <div class="columns is-multiline">
                @foreach ($sensors as $sensor)
                    <measurement-display-component :sensor="{{ $sensor }}">
                    </measurement-display-component>
                @endforeach
                <add-sensor-card-component></add-sensor-card-component>
            </div>
        </div>
    </section>
@endsection
