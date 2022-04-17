@extends('layouts.unsigned')

@section('title', 'Sign up - MemoWri')

@push('scripts')
    <script src="{{ url('/js/utilities.js') }}"></script>
    <script src="{{ url('/js/signup.js') }}"></script>
@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-3"></div>

            <div class="col-6">
                <form id="signup-form" class="form-container" action="{{ route('user.store') }}" method="POST" autocomplete="off" >

                    <fieldset>
                        @csrf
                        <legend class="mb-3">Create a new account!</legend>

                        <div class="field mb-3">
                            <label for="signup-username" class="form-label">Username:</label>
                            <input type="text" class="form-control" id="username" name="username">
                        </div>
                        <div class="message-container"></div>

                        <div class="field mb-3">
                            <label for="signup-password" class="form-label">Password:</label>
                            <input type="password" class="form-control" id="password" name="password">
                            <span toggle="#signup-password" id="signup-togglePassword" class="fa fa-fw fa-eye field-icon toggle-password fa-eye-slash"></span>
                        </div>
                        <div class="message-container"></div>

                        <div class="d-grid">
                            <button type="button" class="btn btn-primary mt-4" id="signup-submit">Create account</button>
                        </div>
                    </fieldset>
                </form>
            </div>

            <div class="col-3"></div>
        </div>
    </div>
@endsection
