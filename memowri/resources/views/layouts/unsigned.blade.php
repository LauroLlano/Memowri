<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title') - MemoWri</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Save your notes and keep them organized with MemoWri!">
    <meta name="keywords" content="memowri, notes, cloud notes, note">
    <meta name="author" content="Lauro Llano">

    <!--Bootstrap CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!--Bootstrap JS and Popper-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css"
        integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ url('/css/style.css') }}">
    @stack('scripts')
    <style>
        body{
            background: #CEEAFF;
            background: linear-gradient(0deg, rgb(206, 234, 255, 1) 0%, rgba(255,255,255,1) 100%);

            background-position: center;
            background-repeat: no-repeat;
            background-size:cover;
            position: relative;
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar sticky-top navbar-expand-lg navbar-light main-color-background">
            <div class="container-fluid">
              <a class="navbar-brand font-main-color" href="{{ route('user.index') }}">
                <img src="{{ url('/img/memowri-logo.png') }}" alt="" width="auto" height="24" class="d-inline-block align-text-top ">
                MemoWri
              </a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>


              <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 mt-2">
                </ul>
                <div class="d-grid">
                    <a class="btn btn-primary me-lg-5 pe-lg-4 ps-lg-4" type="button" href="{{ url('/login') }}">Log in</a>
                </div>
              </div>
            </div>
          </nav>
    </header>

    <div class="modal" tabindex="-1" id="modal-window">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header primary">
              <h5 class="modal-title" id="modal-title">Title</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modal-body">
              <p id="modal-message">Message</p>
            </div>
            <div class="modal-footer" id="modal-footer">
              <button type="button" class="btn btn-primary" id="modal-close" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
    </div>

    @yield('content')

    <footer class="pt-3 pb-3">
        <p>Developed by: <span class="dev-name">Lauro Llano</span></p>
        <p>This project has been made for learning purposes</p>
    </footer>
</body>
</html>
