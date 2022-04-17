@extends('layouts.unsigned')

@section('title', 'Start creating your own notes')

@push('scripts')
    <script src="{{ url('/js/utilities.js') }}"></script>
@endpush

@section('content')
    <div class="hero mb-5">
        <div class="hero-content">
            <h2 class="mt-3 mb-3">Boost your productivity!</h2>
            <p class="mt-3 mb-3">Keep your notes saved, organize them and keep track </p>
            <a href="{{ route('user.create') }}" class="btn btn-primary mt-3">Create my account</a>
            <a href="{{ route('login.show') }}" class="mt-3 custom-a">Do you already have an account? Log in!</a>
        </div>
    </div>

    <div class="container">

        <div id="description" class="landing-description mb-5">

            <div class="row mb-3">
                <div class="col-7 p-5 font-main-color">
                    <h3>Keep your notes saved</h3>
                    <p>MemoWri is a web application that allows you to create your own notes and keep them saved inside your account. You only have to log in, and you'll be able to have in your dashboard all your saved notes.</p>
                </div>
                <div class="col-5">
                    <img src="{{ url('/img/pexels-lukas-317353.jpg') }}" alt="image.png" class="img-fluid">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-5">
                    <img src="{{ url('/img/pexels-min-an-1629212.jpg') }}" alt="image.png" class="img-fluid">
                </div>
                <div class="col-7 p-5 font-main-color">
                    <h3>Organize your notes</h3>
                    <p>Have you ever wanted to organize your tasks? With MemoWri, you'll be able to categorize your notes and organize them in a way that helps in your productivity.</p>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-7 p-5 font-main-color">
                    <h3>Customize your dashboard</h3>
                    <p>You'll be able to customize your dashboard background for your best experience when looking through your notes.</p>
                </div>
                <div class="col-5">
                    <img src="{{ url('/img/pexels-startup-stock-photos-7376-cut.jpg') }}" alt="image.png" class="img-fluid">
                </div>
            </div>

        </div> <!--.landing-description-->


        <div id="why-use-memowri" class="font-main-color">
            <h3>Why use MemoWri?</h3>
            <p>MemoWri is a free app which lets you create and save your notes. If you've ever wanted to have organized notes and keep track of them, MemoWri helps you to keep organized your notes.</p>
        </div>

    </div>
@endsection
