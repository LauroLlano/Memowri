@extends('layouts.app')

@section('title', 'Edit a note')

@push('scripts')
    <script src="{{ url('/js/utilities.js') }}"></script>
    <script src="{{ url('/js/editnote.js') }}"></script>
@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-1 col-lg-2"></div>

            <div class="col-10 col-lg-8">
                <form id="editnote-form" class="form-container" action="{{ route('note.update', ['id'=>$note->id]) }}" method="POST"
                    autocomplete="off">
                    <fieldset>
                        @csrf
                        @method('PATCH')
                        <legend>Edit your note</legend>

                        <div class="field mb-3">
                            <label for="">Category:</label>
                            <select class="form-select" id="editnote-category">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @selected($category->id == $note->id_category)>{{ $category->name}} </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="field mb-3">
                            <label for="">Text:</label>
                            <textarea class="form-control" cols="40" rows="5" id="editnote-description">{{$note->text}}</textarea>
                        </div>
                        <div class="message-container"></div>

                        <div class="d-grid mt-5">
                            <button type="button" class="btn btn-primary" id="editnote-submit">Update note</button>
                        </div>
                    </fieldset>
                </form>
            </div>

            <div class="col-1 col-lg-2"></div>
        </div>
    </div>
@endsection
