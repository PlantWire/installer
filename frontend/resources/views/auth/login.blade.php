@extends('layouts.app')

@section('content')
<div class="login_container container">
    <div class="login_columns columns is-one-third is-vcentered is-centered">
        <div class="box">
            <h1 class="title">{{ __('Login') }}</h1>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="field">
                    <p class="control has-icons-left has-icons-right">
                        <input class="input @error('password') is-invalid @enderror" name="email" type="email" placeholder="{{ __('E-Mail Address') }}" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        <span class="icon is-small is-left">
                            <i class="fas fa-envelope"></i>
                        </span>
                    </p>
                    @error('email')
                        <span class="help is-danger" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="field">
                    <p class="control has-icons-left">
                        <input name="password" type="password" placeholder="{{ __('Password') }}"  class="input @error('password') is-invalid @enderror" required autocomplete="current-password">
                        <span class="icon is-small is-left">
                            <i class="fas fa-lock"></i>
                        </span>
                    </p>
                    @error('password')
                        <span class="help is-danger" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="field is-grouped is-grouped-right">
                    <input type="submit" value="{{ __('Login') }}" class="button is-primary"/>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
