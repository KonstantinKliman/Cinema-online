<div class="d-flex flex-column flex-shrink-0 p-3 bg-body-tertiary" style="width: 250px; height: inherit">
    <a href="{{ route('admin-home.page') }}" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
        <span class="fs-6"><strong>Cinema-online dashboard</strong></span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="{{ route('admin-home.page') }}" class="nav-link {{ Route::currentRouteName() == 'admin-home.page' ? 'active' : '' }} text-light">
                Home
            </a>
        </li>
        <li>
            <a href="{{ route('admin-users.page') }}" class="nav-link {{ Route::currentRouteName() == 'admin-users.page' ? 'active' : '' }} text-light">
                Users
            </a>
        </li>
        <li>
            <a href="{{ route('admin-profiles.page') }}" class="nav-link {{ Route::currentRouteName() == 'admin-profiles.page' ? 'active' : '' }} text-light">
                Profiles
            </a>
        </li>
        <li>
            <a href="{{ route('admin-movies.page') }}" class="nav-link {{ Route::currentRouteName() == 'admin-movies.page' ? 'active' : '' }} text-light">
                Movies
            </a>
        </li>
        <li>
            <a href="{{ route('admin-genres.page') }}" class="nav-link {{ Route::currentRouteName() == 'admin-genres.page' ? 'active' : '' }} text-light">
                Genres
            </a>
        </li>
        <li>
            <a href="{{ route('admin-persons.page') }}" class="nav-link {{ Route::currentRouteName() == 'admin-persons.page' ? 'active' : '' }} text-light">
                Persons
            </a>
        </li>
        <li>
            <a href="{{ route('admin-reviews.page') }}" class="nav-link {{ Route::currentRouteName() == 'admin-reviews.page' ? 'active' : '' }} text-light">
                Reviews
            </a>
        </li>
        <li>
            <a href="#" class="nav-link link-body-emphasis text-light">
                Subscribers
            </a>
        </li>
        <li>
            <a href="#" class="nav-link link-body-emphasis text-light">
                Statistics
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('home.page') }}" class="nav-link text-light" aria-current="page">
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
