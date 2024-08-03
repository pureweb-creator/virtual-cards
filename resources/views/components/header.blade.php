@props(['class'=>'', 'mode'=>'light'])

<header class="{{$class}}">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-{{$mode}} rounded" aria-label="Eleventh navbar example">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{route('welcome')}}">QRcards</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler" aria-controls="navbarsExample09" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarToggler">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link @if(Route::currentRouteName()=='welcome') active @endif" aria-current="page" href="{{route('welcome')}}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(Route::currentRouteName()=='pricing') active @endif" href="{{route('pricing')}}">Pricing</a>
                        </li>
                    </ul>
                    <div class="d-flex align-items-center justify-content-center">
                        @auth()

                            <div class="dropdown text-end">
                                <a href="#" class="d-block nav-link text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{Auth::user()->avatar ?? 'https://via.placeholder.com/160'}}" alt="mdo" width="32" height="32" class="rounded-circle">
                                </a>
                                <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1" style="">
                                    <li><a class="dropdown-item" href="{{route('profile.dashboard')}}">Profile</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{route('logout')}}">Sign out</a></li>
                                </ul>
                            </div>
                        @endauth

                        @guest()
                            <a href="{{route('login')}}" class="btn btn-outline-primary me-2">Login</a>
                            <a href="{{route('register')}}" class="btn btn-primary">Sign-up</a>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>
