<nav class="navbar navbar-expand-lg bg-body-tertiary mb-lg-0 mb-3 border-bottom">
    <div class="container-fluid">
        <span class="navbar-brand d-lg-none d-block mb-0 h1 p-0">Dashboard</span>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div
                class="w-100 d-flex flex-column flex-lg-row justify-content-lg-between justify-content-start align-items-lg-center mt-2 mt-lg-0 mb-lg-0">
                <div class="">
                    <ul class="navbar-nav">
                        <li class="nav-item d-flex align-items-center">
                            <span class="navbar-brand d-none d-lg-block mb-0 h1 p-0">Dashboard</span>
                        </li>
                        <li class="nav-item">
                            <a class="link" href="{{ route('index') }}">
                                Go to home page
                            </a>
                        </li>
                        <li class="d-block d-lg-none nav-item dropdown me-0">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                               aria-expanded="false">
                                <i class="bi bi-person"></i>
                                {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item text-start"
                                       href="{{ route('dashboard.index') }}">Dashboard</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form action="{{ route('logout.action') }}" method="post">
                                        @csrf
                                        <input type="submit" class="dropdown-item text-start" value="Logout"/>
                                    </form>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item d-block d-lg-none nav-item dropdown me-0">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                               aria-expanded="false">
                                <i class="bi bi-speedometer2"></i>
                                Dashboard menu
                            </a>
                            <ul class="dropdown-menu">
                                @hasanyrole('Administrator|Moderator|Uploader')
                                @can(['add user', 'edit user', 'delete user'])
                                    <li class="nav-item">
                                        <a href="{{ route('dashboard.user.index') }}"
                                           class="dropdown-item text-start py-2">
                                            Users
                                        </a>
                                    </li>
                                @endcan
                                @can(['add role', 'edit role', 'delete role'])
                                    <li class="nav-item">
                                        <a href="{{ route('dashboard.role.index') }}"
                                           class="dropdown-item text-start py-2">
                                            Roles
                                        </a>
                                    </li>
                                @endcan
                                @can(['add profile', 'edit profile', 'delete profile'])
                                    <li class="nav-item">
                                        <a href="{{ route('dashboard.profile.index') }}"
                                           class="dropdown-item text-start py-2">
                                            Profiles
                                        </a>
                                    </li>
                                @endcan
                                @can(['add movie', 'edit movie', 'delete movie'])
                                    <li class="nav-item">
                                        <a href="{{ route('dashboard.movie.index') }}"
                                           class="dropdown-item text-start py-2">
                                            Movies
                                        </a>
                                    </li>
                                @endcan
                                @can(['add genre', 'edit genre', 'delete genre'])
                                    <li class="nav-item">
                                        <a href="{{ route('dashboard.genres.index') }}"
                                           class="dropdown-item text-start py-2">
                                            Genres
                                        </a>
                                    </li>
                                @endcan
                                @can(['add person', 'edit person', 'delete person'])
                                    <li class="nav-item">
                                        <a href="{{ route('dashboard.person.index') }}"
                                           class="dropdown-item text-start py-2">
                                            Persons
                                        </a>
                                    </li>
                                @endcan
                                @can(['add person role', 'edit person role', 'delete person role'])
                                    <li class="nav-item">
                                        <a href="{{ route('dashboard.person.role.index') }}"
                                           class="dropdown-item text-start py-2">
                                            Person roles
                                        </a>
                                    </li>
                                @endcan
                                @can(['add review', 'delete review', 'edit review'])
                                    <li class="nav-item">
                                        <a href="{{ route('dashboard.review.index') }}"
                                           class="dropdown-item text-start py-2">
                                            Reviews
                                        </a>
                                    </li>
                                @endcan
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                @endhasanyrole
                                <li class="nav-item">
                                    <a href="{{ route('dashboard.user') }}"
                                       class="dropdown-item text-start py-2">
                                        Your account
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('dashboard.profile') }}"
                                       class="dropdown-item text-start py-2 {{ auth()->user()->hasVerifiedEmail() ? '' : 'disabled' }}">
                                        Your profile
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('dashboard.reviews') }}"
                                       class="dropdown-item text-start py-2 {{ auth()->user()->hasVerifiedEmail() ? '' : 'disabled' }}">
                                        Your reviews
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('dashboard.ratings') }}"
                                       class="dropdown-item text-start py-2 {{ auth()->user()->hasVerifiedEmail() ? '' : 'disabled' }}">
                                        Your ratings
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="d-none d-lg-flex flex-lg-row flex-column mb-lg-0">
                    @if(auth()->check())
                        <div class="dropdown">
                            <button class="btn btn-outline-light dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person"></i>
                                {{ auth()->user()->name }}
                            </button>
                            <ul class="dropdown-menu-end dropdown-menu">
                                <li><a class="dropdown-item text-end"
                                       href="{{ route('dashboard.index') }}">Dashboard</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
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
<div class="d-none d-lg-block bg-body-secondary mb-3 py-3 border-bottom">
    <div class="container-fluid">
        @hasanyrole('Administrator|Moderator|Uploader')
        <div class="mb-2">
            <ul class="nav nav-pills flex-row mb-auto justify-content-center">
                @can(['add user', 'edit user', 'delete user'])
                    <li class="nav-item">
                        <a href="{{ route('dashboard.user.index') }}"
                           class="nav-link {{ Route::currentRouteName() == 'dashboard.user.index' ? 'active' : '' }} text-light">
                            Users
                        </a>
                    </li>
                @endcan
                @can(['add role', 'edit role', 'delete role'])
                    <li class="nav-item">
                        <a href="{{ route('dashboard.role.index') }}"
                           class="nav-link {{ Route::currentRouteName() == 'dashboard.role.index' ? 'active' : '' }} text-light">
                            Roles
                        </a>
                    </li>
                @endcan
                @can(['add profile', 'edit profile', 'delete profile'])
                    <li class="nav-item">
                        <a href="{{ route('dashboard.profile.index') }}"
                           class="nav-link {{ Route::currentRouteName() == 'dashboard.profile.index' ? 'active' : '' }} text-light">
                            Profiles
                        </a>
                    </li>
                @endcan
                @can(['add movie', 'edit movie', 'delete movie'])
                    <li class="nav-item">
                        <a href="{{ route('dashboard.movie.index') }}"
                           class="nav-link {{ Route::currentRouteName() == 'dashboard.movie.index' ? 'active' : '' }} text-light">
                            Movies
                        </a>
                    </li>
                @endcan
                @can(['add genre', 'edit genre', 'delete genre'])
                    <li class="nav-item">
                        <a href="{{ route('dashboard.genres.index') }}"
                           class="nav-link {{ Route::currentRouteName() == 'dashboard.genres.index' ? 'active' : '' }} text-light">
                            Genres
                        </a>
                    </li>
                @endcan
                @can(['add person', 'edit person', 'delete person'])
                    <li class="nav-item">
                        <a href="{{ route('dashboard.person.index') }}"
                           class="nav-link {{ Route::currentRouteName() == 'dashboard.person.index' ? 'active' : '' }} text-light">
                            Persons
                        </a>
                    </li>
                @endcan
                @can(['add person role', 'edit person role', 'delete person role'])
                    <li class="nav-item">
                        <a href="{{ route('dashboard.person.role.index') }}"
                           class="nav-link {{ Route::currentRouteName() == 'dashboard.person.role.index' ? 'active' : '' }} text-light">
                            Person roles
                        </a>
                    </li>
                @endcan
                @can(['add review', 'delete review', 'edit review'])
                    <li class="nav-item">
                        <a href="{{ route('dashboard.review.index') }}"
                           class="nav-link {{ Route::currentRouteName() == 'dashboard.review.index' ? 'active' : 'text-light' }}">
                            Reviews
                        </a>
                    </li>
                @endcan
            </ul>
        </div>
        @endrole
        <div>
            <ul class="nav nav-pills flex-row mb-auto justify-content-center">
                <li class="nav-item">
                    <a href="{{ route('dashboard.user') }}"
                       class="nav-link {{ Route::currentRouteName() == 'dashboard.user' ? 'active' : '' }} text-light">
                        Your account
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dashboard.profile') }}"
                       class="nav-link {{ Route::currentRouteName() == 'dashboard.profile' ? 'active' : '' }} {{ auth()->user()->hasVerifiedEmail() ? 'text-light' : 'disabled' }}">
                        Your profile
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dashboard.reviews') }}"
                       class="nav-link {{ Route::currentRouteName() == 'dashboard.reviews' ? 'active' : '' }} {{ auth()->user()->hasVerifiedEmail() ? 'text-light' : 'disabled' }}">
                        Your reviews
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dashboard.ratings') }}"
                       class="nav-link {{ Route::currentRouteName() == 'dashboard.ratings' ? 'active' : '' }} {{ auth()->user()->hasVerifiedEmail() ? 'text-light' : 'disabled' }}">
                        Your ratings
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
