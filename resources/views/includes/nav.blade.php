<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="http://media.maximilian-mewes.de/project/bl/blubber_lounge_rebrand_try.svg" alt="Dart a Web-App Logo" width="100px" style="transform:rotate(-2deg);">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            @auth
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('game.*') ? 'active' : '' }}"  href="#" data-bs-toggle="dropdown"> Game Management</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('game.create') }}">
                                    <i class="fa-solid fa-play me-2"></i>
                                    Start Game
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('game.index') }}">
                                    <i class="fa-solid fa-list me-2"></i>
                                    List All Games
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fa-solid fa-play me-2"></i>
                                    Started Games
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item disabled" href="#">
                                    <i class="fa-solid fa-stop me-2"></i>
                                    Stoped Games
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item disabled" href="#">
                                    <i class="fa-solid fa-pause me-2"></i>
                                    Paused Games
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fa-solid fa-list-check me-2"></i>
                                    Game history
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#"> Stats </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#"> History </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('utillity.*') ? 'active' : '' }}" href="#" data-bs-toggle="dropdown"> Checkout Calculator </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('utillity.viewCheckouts') }}"> Calculator </a></li>
                            <li><a class="dropdown-item disabled" href="#"> Checkout Table </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('utillity.viewDartboard') }}"> behind the scenes </a></li>
                        </ul>
                    </li>
                    @can('viewAny', App\Models\User::class)
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('user.*') ? 'active' : '' }}" href="{{ route('user.index') }}"> User Management </a>
                        </li>
                    @endcan
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#"> Settings </a>
                    </li>
                </ul>
            @endauth

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <img src="{{ asset('img/user/bl_placeholder.png') }}" class="rounded me-1" alt="user profile image" width="33px">
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>