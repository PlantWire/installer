@extends('layouts.app')

@section('title', 'Add Sensor')

@section('content')
<div class="section container">
    <div class="columns is-one-third is-vcentered is-centered">
        <div class="box">
            <h1 class="title">{{ __('Add a new sensor') }}</h1>

            <form method="POST" action="{{ route('store_sensor') }}">
            @csrf
                <div class="field">
                    <p class="control has-icons-left">
                        <input name="uuid" type="text" placeholder="{{ __('Sensor UUID') }}"  class="input @error('sensor-uuid') is-invalid @enderror" value="{{ old('uuid') }}" required autocomplete="uuid">
                        <span class="icon is-small is-left">
                            <i class="fas fa-search"></i>
                        </span>
                    </p>
                    @error('uuid')
                        <span class="help is-danger" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="field">
                    <p class="control has-icons-left">
                        <input name="pin" type="number" placeholder="{{ __('Sensor PIN') }}"  class="input @error('sensor-pin') is-invalid @enderror" value="{{ old('pin') }}" required autocomplete="pin">
                        <span class="icon is-small is-left">
                            <i class="fas fa-lock"></i>
                        </span>
                    </p>
                    @error('pin')
                        <span class="help is-danger" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="field">
                    <p class="control has-icons-left">
                        <input name="name" type="text" placeholder="{{ __('Sensor Name') }}"  class="input @error('sensor-name') is-invalid @enderror" value="{{ old('name') }}" required autocomplete="name">
                        <span class="icon is-small is-left">
                            <i class="fas fa-seedling"></i>
                        </span>
                    </p>
                    @error('name')
                        <span class="help is-danger" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

               <div class="field is-grouped is-grouped-right">
                    <input type="submit" value="{{ __('Search Sensor...') }}" class="button is-primary"/>
               </div>

            </form>
        </div>
    </div>
</div>
</section>
@endsection
