@extends('layouts.app')

@section('title', 'Edit account')

@push('scripts')
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css"
        integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <script src="{{ url('/js/utilities.js') }}"></script>
    <script src="{{ url('/js/editaccount.js') }}"></script>
@endpush

@section('content')
    <div class="container">
        <div class="row">
            <form id="editaccount-form" class="form-container" action="{{ route('user.update') }}" method="POST" autocomplete="off">
                <fieldset>
                    @csrf
                    @method('PATCH')
                    <legend>Edit your user account</legend>

                    <div class="field mb-3">
                        <label for="edit-username" class="form-label">Username:</label>
                        <input type="text" class="form-control" id="edit-username" disabled placeholder="{{$user->id}}">
                    </div>

                    <div class="field mb-3">
                        <label for="edit-oldpassword" class="form-label">Old password:</label>
                        <input type="password" class="form-control" id="edit-oldpassword">
                        <span toggle="#edit-oldpassword" id="edit-toggleOldPassword"
                            class="fa fa-fw fa-eye field-icon toggle-password fa-eye-slash"></span>
                    </div>
                    <div class="message-container"></div>

                    <div class="field mb-3">
                        <label for="edit-password" class="form-label">New password:</label>
                        <input type="password" class="form-control" id="edit-password">
                        <span toggle="#edit-password" id="edit-togglePassword"
                            class="fa fa-fw fa-eye field-icon toggle-password fa-eye-slash"></span>
                    </div>
                    <div class="message-container"></div>

                    <div class="d-grid mt-4">
                        <button type="button" class="btn btn-primary" id="editaccount-submit">Update user</button>
                    </div>

                </fieldset>
            </form>

        </div>
    </div>
@endsection
