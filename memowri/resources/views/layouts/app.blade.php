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
    <!--Bootstrap JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css"
        integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ url('/css/style.css') }}">


    @stack('scripts')
    <style>
        body{
           height: 100%;
           background: linear-gradient(
               rgba(
                   {{$background->color->rgb['r']}},
                   {{$background->color->rgb['g']}},
                   {{$background->color->rgb['b']}},
                   {{ $background->image!=NULL? 1.0 - $background->image->opacity: 1}}
                ),
                rgba(
                    {{$background->color->rgb['r']}},
                    {{$background->color->rgb['g']}},
                    {{$background->color->rgb['b']}},
                    {{ $background->image!=NULL? 1.0 - $background->image->opacity: 1}}
                )
            ),
            url({{ ($background->image!=NULL ? asset($background->image->route) : "") }})
            no-repeat center center fixed;
           background-size: cover;
        }
    </style>
</head>
<body>
    <div class="modal" tabindex="-1" id="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header primary">
                    <h5 class="modal-title" id="modal-title">Title</h5>
                    <button type="button" class="btn-close" id="modal-cross" data-bs-dismiss="modal" aria-label="Close"></button>
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

    <header>
        <button class="btn btn-secondary burger-button position-fixed" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasLeft" aria-controls="offcanvasLeft">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-menu-2" width="32" height="32"
                viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round"
                stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <line x1="4" y1="6" x2="20" y2="6" />
                <line x1="4" y1="12" x2="20" y2="12" />
                <line x1="4" y1="18" x2="20" y2="18" />
            </svg>
        </button>

        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasLeft" aria-labelledby="offcanvasLeftLabel">
            <div class="offcanvas-header">
                <h5 id="offcanvasLeftLabel" class="mt-3 mb-3">Menu</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul id="burger-menu">
                    <li class="mb-3">
                        <a class="list-group-item" href="{{ route('user.index') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-home-2" width="36"
                                height="36" viewBox="0 0 24 24" stroke-width="1.5" stroke="#1A496C" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <polyline points="5 12 3 12 12 3 21 12 19 12" />
                                <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                <rect x="10" y="12" width="4" height="4" />
                            </svg>
                            Home
                        </a>
                    </li>
                    <li class="mt-4 mb-3 ">
                        <a class="list-group-item" href="{{ route('note.create')}}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-plus" width="36"
                                height="36" viewBox="0 0 24 24" stroke-width="1.5" stroke="#1A496C" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                <line x1="12" y1="11" x2="12" y2="17" />
                                <line x1="9" y1="14" x2="15" y2="14" />
                            </svg>
                            Create new note
                        </a>
                    </li>
                    <li class="mt-4 mb-3">
                        <a class="list-group-item" href="{{ route('category.create') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-layout-grid-add"
                                width="36" height="36" viewBox="0 0 24 24" stroke-width="1.5" stroke="#1A496C" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <rect x="4" y="4" width="6" height="6" rx="1" />
                                <rect x="14" y="4" width="6" height="6" rx="1" />
                                <rect x="4" y="14" width="6" height="6" rx="1" />
                                <path d="M14 17h6m-3 -3v6" />
                            </svg>
                            Create new category
                        </a>
                    </li>
                    <li class="mt-4 mb-3">
                        <a class="list-group-item" href="{{ route('user.edit') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="36"
                                height="36" viewBox="0 0 24 24" stroke-width="1.5" stroke="#1A496C" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <circle cx="12" cy="7" r="4" />
                                <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                            </svg>
                            Edit account
                        </a>
                    </li>
                    <li class="mt-4 mb-3">
                        <a class="list-group-item" href="{{ route('background.edit') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-photo" width="36"
                                height="36" viewBox="0 0 24 24" stroke-width="1.5" stroke="#1A496C" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <line x1="15" y1="8" x2="15.01" y2="8" />
                                <rect x="4" y="4" width="16" height="16" rx="3" />
                                <path d="M4 15l4 -4a3 5 0 0 1 3 0l5 5" />
                                <path d="M14 14l1 -1a3 5 0 0 1 3 0l2 2" />
                            </svg>
                            Change background
                        </a>
                    </li>
                    <li class="mt-4">
                        <a class="list-group-item" href="{{ route('user.logout') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-logout" width="36"
                                height="36" viewBox="0 0 24 24" stroke-width="1.5" stroke="#1A496C" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                                <path d="M7 12h14l-3 -3m0 6l3 -3" />
                            </svg>
                            Log out
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    @yield('content')
</body>
</html>
