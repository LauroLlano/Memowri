@extends('layouts.app')

@section('title', 'My notes')

@push('scripts')
    <script src="{{ url('/js/utilities.js') }}"></script>
    <script src="{{ url('/js/dashboard.js') }}"></script>
@endpush

@section('content')
    <div class="container">
        <div class="row mt-5 mb-5 d-flex justify-content-center">

        @if($categories->isEmpty())
            <div class="col-lg-12 col-12 mb-5 ms-auto me-auto mt-5">
                <h2 class="center-text" style="{{
                    $background->color->rgb['r']<=127 && $background->color->rgb['g']<=127 && $background->color->rgb['b']<=127 ? 'color: white;' : 'color: black;'}}">No categories have been added!</h2>
            </div>
        @endif

        @foreach ($categories as $category)
            <div class="col-lg-2 col-12 category mb-5 ms-2 me-2" value="{{ $category->id }}">

                <div class="category-header mb-4">
                    <div class="category-buttons d-flex flex-row-reverse">
                        <form action="{{ route('category.destroy', [$category->id]) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="button" class="small-button deleteCategory"><svg xmlns="http://www.w3.org/2000/svg"
                                class="icon icon-tabler icon-tabler-square-x" width="20" height="20" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="#1A496C" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <rect x="4" y="4" width="16" height="16" rx="2" />
                                <path d="M10 10l4 4m0 -4l-4 4" />
                            </svg></button>
                        </form>

                        <a href="{{ route('category.edit', ['id' => $category->id])}}" class="small-button"><svg xmlns="http://www.w3.org/2000/svg"
                                class="icon icon-tabler icon-tabler-edit" width="20" height="20" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="#1A496C" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" />
                                <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" />
                                <line x1="16" y1="5" x2="19" y2="8" />
                            </svg></a>
                    </div>
                    <div class="category-title">
                        <h2>{{ $category->name }}</h2>
                    </div>
                </div>


                @foreach($category->notes as $note)
                    <div class="note" draggable="true" order="{{ $note->order }}" value="{{$note->id}}">
                        <div class="card mb-3 border-dark">
                            <div class="card-header border-success d-flex flex-row-reverse">
                                <form action="{{ route('note.destroy', [$note->id]) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button type="button" class="small-button deleteNote"><svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-square-x" width="20" height="20" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="#1A496C" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <rect x="4" y="4" width="16" height="16" rx="2" />
                                        <path d="M10 10l4 4m0 -4l-4 4" />
                                    </svg></button>
                                </form>

                                <a href="{{ route('note.edit', ['id' => $note->id])}}" class="small-button"><svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-edit" width="20" height="20" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="#1A496C" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" />
                                        <path d="M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3" />
                                        <line x1="16" y1="5" x2="19" y2="8" />
                                    </svg></a>

                                <form class="notepatch" action="{{ route('note.updateorder', [$note->id]) }}" method="POST">
                                    @method('PATCH')
                                    @csrf
                                </form>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">{{ $note->text }}</h5>
                                <!--p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p-->
                            </div>
                            <!--div class="card-footer bg-transparent border-success d-flex flex-row-reverse">
                                    <button>Open note</button>
                                </div-->
                        </div>
                    </div>
                @endforeach

            </div>

        @endforeach
        </div>
    </div>


    <a class="btn btn-success my-fixed-button position-fixed" href="{{ route('note.create') }}" style="text-align: center;">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-plus" width="28" height="28" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <path d="M14 3v4a1 1 0 0 0 1 1h4" />
            <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
            <line x1="12" y1="11" x2="12" y2="17" />
            <line x1="9" y1="14" x2="15" y2="14" />
        </svg>
    </a>

@endsection
