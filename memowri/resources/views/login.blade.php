@extends('layouts.unsigned')

@section('title', 'Log in')

@push('scripts')
    <script src="{{ url('/js/utilities.js') }}"></script>
    <script src="{{ url('/js/login.js') }}"></script>
@endpush



@section('content')
    <div class="row">
        <form id="login-form" class="form-container" action="{{ route('user.login') }}" method="POST" autocomplete="off">
            <fieldset>
                @csrf
                <legend>Log in with your username!</legend>
                <div class="field mb-3">
                    <label for="login-username" class="form-label">Username:</label>
                    <input type="text" class="form-control" id="username" name="username">
                </div>
                <div class="field mb-3">
                  <label for="login-password" class="form-label">Password:</label>
                  <input type="password" class="form-control" id="password" name="password">
                  <span toggle="#login-password" id="login-togglePassword"
                    class="fa fa-fw fa-eye field-icon toggle-password fa-eye-slash"></span>
                </div>
                <div class="d-grid">
                    <button type="button" class="btn btn-primary mt-4" id="login-submit">Log in</button>
                </div>
            </fieldset>
            <a href="{{ route('user.create') }}" class="mt-3 custom-a">Don't have an account? Sign in!</a>
        </form>
    </div>
@endsection
