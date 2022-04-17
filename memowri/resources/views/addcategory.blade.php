@extends('layouts.app')

@section('title', 'Create new category')

@push('scripts')
    <script src="{{ url('/js/utilities.js') }}"></script>
    <script src="{{ url('/js/addcategory.js') }}"></script>
@endpush


@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-2 col-1"></div>

            <div class="col-10 col-lg-8">
                <form id="addcategory-form" class="form-container" action="{{ route('category.store') }}" method="POST" autocomplete="off">
                    <fieldset>
                        @csrf
                        <legend>Add a new category to your dashboard</legend>
                        <div class="field">
                            <label for="category-name" class="form-label">Category name:</label>
                            <input type="text" class="form-control" id="category-name" autocomplete="off">
                        </div>
                        <div class="message-container"></div>

                        <div class="d-grid">
                            <button type="button" class="btn btn-primary mt-4" id="addcategory-submit">Save category</button>
                        </div>
                    </fieldset>
                </form>
            </div>

            <div class="col-1 col-lg-2"></div>
        </div>

    </div>
@endsection
