@extends('layouts.app')

@section('title', 'Add new note')

@push('scripts')
    <script src="{{ url('/js/utilities.js') }}"></script>
    <script src="{{ url('/js/addnote.js') }}"></script>
@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-1 col-lg-2"></div>

            <div class="col-10 col-lg-8">
                <form id="addnote-form" class="form-container" action="{{ route('note.store') }}" method="POST" autocomplete="off">
                    <fieldset>
                        @csrf
                        <legend>Add a new note!</legend>

                        <div class="field mb-3">
                            <label for="">Category:</label>
                            <select class="form-select" id="addnote-category">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name}} </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="field mb-3">
                            <label for="">Text:</label>
                            <textarea class="form-control" cols="40" rows="5" id="addnote-description"></textarea>
                        </div>
                        <div class="message-container"></div>

                        <div class="d-grid mt-5">
                            <button type="button" class="btn btn-primary" id="addnote-submit">Create note</button>
                        </div>
                    </fieldset>
                </form>
            </div>

            <div class="col-1 col-lg-2"></div>
        </div>
    </div>
@endsection
