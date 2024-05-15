<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <span class="navbar-brand d-lg-none d-block mb-0 h1 p-0">Cinema-online</span>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="w-100 d-flex flex-column flex-lg-row justify-content-lg-between justify-content-start align-items-lg-center mt-2 mt-lg-0 mb-lg-0">
                <div class="">
                    <ul class="navbar-nav mb-2 mb-lg-0">
                        <li class="nav-item d-flex align-items-center">
                            <span class="navbar-brand d-none d-lg-block mb-0 h1 p-0">Cinema-online</span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{ route('index') }}">Home</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Genres
                            </a>
                            <ul class="dropdown-menu">
                                @foreach($genres as $genre)
                                    <li><a class="dropdown-item" href="#">{{ $genre->name }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        @if(auth()->check())
                        <li class="d-block d-lg-none nav-item dropdown me-0">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person"></i>
                                {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item text-start" href="{{ route('dashboard.index') }}">Dashboard</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout.action') }}" method="post">
                                        @csrf
                                        <input type="submit" class="dropdown-item text-start" value="Logout"/>
                                    </form>
                                </li>
                            </ul>
                        </li>
                        @else
                            <li class="nav-item d-block d-lg-none ">
                                <a class="nav-link" aria-current="page" href="{{ route('login.page') }}">Login</a>
                            </li>
                            <li class="nav-item d-block d-lg-none ">
                                <a class="nav-link" aria-current="page" href="{{ route('register.page') }}">Register</a>
                            </li>
                        @endif
                    </ul>
                </div>
                <div class="mb-2 mb-lg-0">
                    <form method="get" action="{{ route('movie.search') }}">
                        <div class="d-flex justify-content-center">
                            <input class="form-control me-0 me-lg-2 p-2 w-100" placeholder="Search" aria-label="Search" name="query">
                            <button class="btn btn-outline-light d-lg-inline-flex align-items-center" type="submit">
                                <i class="bi bi-search d-none d-lg-block me-lg-2"></i>
                                Search
                            </button>
                        </div>
                    </form>
                </div>
                <div class="d-none d-lg-flex flex-lg-row flex-column mb-lg-0">
                    @if(auth()->check())
                        <div class="dropdown">
                            <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person"></i>
                                {{ auth()->user()->name }}
                            </button>
                            <ul class="dropdown-menu-end dropdown-menu" >
                                <li><a class="dropdown-item text-end" href="{{ route('dashboard.index') }}">Dashboard</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout.action') }}" method="post">
                                        @csrf
                                        <input type="submit" class="dropdown-item text-end" value="Logout"/>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a class="btn btn-outline-light me-lg-2 mb-2 mb-lg-0" href="{{ route('login.page') }}">Login</a>
                        <a class="btn btn-light mb-lg-0" href="{{ route('register.page') }}">Register</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</nav>
