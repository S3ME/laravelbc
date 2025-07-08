<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold text-success" href="{{ route('home') }}">GadgetStore</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarGadgetStore" aria-controls="navbarGadgetStore" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarGadgetStore">
            <form class="d-flex mx-lg-auto my-2 my-lg-0 w-100 w-lg-50" role="search">
                <input class="form-control me-2 rounded-pill flex-grow-1" name="search" type="search" placeholder="Find Your Favorite Laptop Here" aria-label="Search" style="min-width: 0;">
            </form>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                <li class="nav-item me-3">
                    <a class="nav-link" href="{{ route('carts') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                            <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                        </svg>
                    </a>
                </li>
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Str::substr(Auth::user()->name, 0, 1) }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            @if (Auth::check() && Auth::user()->role == 'admin')
                                <li>
                                    <a href="{{ url('/dashboard') }}" class="dropdown-item">
                                        Dashboard
                                    </a>
                                </li>
                            @endif

                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a>
                            </li>

                            {{-- 
                            <li>
                                <a class="dropdown-item" href="{{ route('orders.index') }}">Orders</a>
                            </li> 
                            --}}
                            
                            <li><hr class="dropdown-divider"></li>

                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="btn btn-outline-success rounded-pill mb-2 mb-lg-0">
                            Login
                        </a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item ms-lg-2">
                            <a href="{{ route('register') }}" class="btn btn-success rounded-pill">
                                Register
                            </a>
                        </li>
                    @endif
                @endauth
            </ul>
        </div>
    </div>
</nav>