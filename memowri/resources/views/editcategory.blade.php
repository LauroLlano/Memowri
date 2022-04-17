@extends('layouts.app')

@section('title', 'Edit category')

@push('scripts')
    <script src="{{ url('/js/utilities.js') }}"></script>
    <script src="{{ url('/js/editcategory.js') }}"></script>
@endpush

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-2 col-1"></div>

            <div class="col-10 col-lg-8">
                <form id="editcategory-form" class="form-container" action="{{ route('category.update', ['id'=>$category->id]) }}" method="POST"
                    autocomplete="off">
                    <fieldset>
                        @csrf
                        @method('PATCH')
                        <legend>Edit your category</legend>

                        <div class="field">
                            <label for="category-name" class="form-label">Category name:</label>
                            <input type="text" class="form-control" id="category-name" autocomplete="off" value="{{ $category->name }}">
                        </div>
                        <div class="message-container"></div>

                        <div class="d-grid">
                            <button type="button" class="btn btn-primary mt-4" id="editcategory-submit">Update category</button>
                        </div>
                    </fieldset>
                </form>
            </div>

            <div class="col-1 col-lg-2"></div>
        </div>
    </div>
@endsection
