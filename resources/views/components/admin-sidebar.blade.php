<div class="d-flex flex-column flex-shrink-0 p-3 bg-body-tertiary" style="width: 250px; height: inherit">
    <a href="{{ route('admin.index') }}" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
        <span class="fs-6"><strong>Cinema-online dashboard</strong></span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="{{ route('admin.index') }}" class="nav-link {{ Route::currentRouteName() == 'admin.index' ? 'active' : '' }} text-light">
                Home
            </a>
        </li>
        <li>
            <a href="{{ route('admin.user.index') }}" class="nav-link {{ Route::currentRouteName() == 'admin.user.index' ? 'active' : '' }} text-light">
                Users
            </a>
        </li>
        <li>
            <a href="{{ route('admin.role.index') }}" class="nav-link {{ Route::currentRouteName() == 'admin.role.index' ? 'active' : '' }} text-light">
                Roles
            </a>
        </li>
        @can(['add profile', 'edit profile', 'delete profile'])
        <li>
            <a href="{{ route('admin.profile.index') }}" class="nav-link {{ Route::currentRouteName() == 'admin.profile.index' ? 'active' : '' }} text-light">
                Profiles
            </a>
        </li>
        @endcan
        <li>
            <a href="{{ route('admin.movie.index') }}" class="nav-link {{ Route::currentRouteName() == 'admin.movie.index' ? 'active' : '' }} text-light">
                Movies
            </a>
        </li>
        <li>
            <a href="{{ route('admin.genres.index') }}" class="nav-link {{ Route::currentRouteName() == 'admin.genres.index' ? 'active' : '' }} text-light">
                Genres
            </a>
        </li>
        <li>
            <a href="{{ route('admin.person.index') }}" class="nav-link {{ Route::currentRouteName() == 'admin.person.index' ? 'active' : '' }} text-light">
                Persons
            </a>
        </li>
        <li>
            <a href="{{ route('admin.person.role.index') }}" class="nav-link {{ Route::currentRouteName() == 'admin.person.role.index' ? 'active' : '' }} text-light">
                Person roles
            </a>
        </li>
        <li>
            <a href="{{ route('admin.review.index') }}" class="nav-link {{ Route::currentRouteName() == 'admin.review.index' ? 'active' : '' }} text-light">
                Reviews
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('index') }}" class="nav-link text-light" aria-current="page">
                Cinema-online
            </a>
        </li>
    </ul>
    <hr>
    <div class="dropdown">
        <a href="#" class="d-flex align-items-center link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <strong>{{ auth()->user()->name }}</strong>
        </a>
        <ul class="dropdown-menu text-small shadow">
            <li><a class="dropdown-item" href="#">New project...</a></li>
            <li><a class="dropdown-item" href="#">Settings</a></li>
            <li><a class="dropdown-item" href="#">Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Sign out</a></li>
        </ul>
    </div>
</div>
