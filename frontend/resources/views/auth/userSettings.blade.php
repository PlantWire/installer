@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="title is-spaced">{{ __('User Settings') }}</h1>
    <form method="POST" action="{{ route('store_user', [ 'user' => $user->id]) }}">
        @csrf
        <div class="field">
            <label class="label">{{ __('User Details') }}</label>
            <p class="control has-icons-left has-icons-right">
                <input class="input @error('name') is-invalid @enderror" name="name" type="string" placeholder="{{ __('Name') }}" value="{{ old('name', $user->name) }}" required autocomplete="name" autofocus>
                <span class="icon is-small is-left">
                    <i class="fas fa-user"></i>
                </span>
            </p>
            @error('name')
                <span class="help is-danger" role="alert">
                    {{ $message }}
                </span>
            @enderror
        </div>
        <div class="field">
            <p class="control has-icons-left has-icons-right">
                <input class="input @error('email') is-invalid @enderror" name="email" type="email" placeholder="{{ __('E-Mail Address') }}" value="{{ old('email', $user->email) }}" required autocomplete="email">
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
            <label class="label">{{ __('Change Password') }}</label>
            <span class="help is-info" role="alert">
                {{ __('passwords.leave_empty') }}
            </span>
            <p class="control has-icons-left has-icons-right">
                <input class="input @error('old_password') is-invalid @enderror" name="old_password" type="password" placeholder="{{ __('passwords.old') }}" value="{{ old('old_password') }}">
                <span class="icon is-small is-left">
                    <i class="fas fa-lock"></i>
                </span>
            </p>
            @error('old:password')
                <span class="help is-danger" role="alert">
                    {{ $message }}
                </span>
            @enderror
        </div>
        <div class="field">
            <p class="control has-icons-left">
                <input name="new_password" type="password" placeholder="{{ __('passwords.new') }}"  class="input @error('new_password') is-invalid @enderror">
                <span class="icon is-small is-left">
                    <i class="fas fa-lock"></i>
                </span>
            </p>
            @error('new_password')
                <span class="help is-danger" role="alert">
                    {{ $message }}
                </span>
            @enderror
        </div>
        <div class="field">
            <p class="control has-icons-left">
                <input name="new_password_confirmation" type="password" placeholder="{{ __('passwords.new_repeat') }}"  class="input @error('new_password_confirmation') is-invalid @enderror">
                <span class="icon is-small is-left">
                    <i class="fas fa-lock"></i>
                </span>
            </p>
            @error('new_password_confirmation')
                <span class="help is-danger" role="alert">
                    {{ $message }}
                </span>
            @enderror
        </div>
        <div class="field is-grouped is-grouped-right">
            <input type="submit" value="{{ __('Save') }}" class="button is-primary"/>
        </div>
    </form>
</div>
@endsection
