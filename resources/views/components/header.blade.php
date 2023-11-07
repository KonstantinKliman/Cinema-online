<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('home.page') }}">Cinema-online</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse mt-3 mt-md-0" id="navbarNavDropdown">
            <div class="d-flex justify-content-between align-items-center w-100">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('home.page') }}">Home</a>
                    </li>
                </ul>
                @if(auth()->check())
                    <div class="dropdown">
                        <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ auth()->user()->name }}
                        </button>
                        <ul class="dropdown-menu-end dropdown-menu" >
                            <li><a class="dropdown-item text-end" href="{{ route('profile.page', ['user_id' => auth()->user()->id]) }}">Your profile</a></li>
                            <li><a class="dropdown-item text-end" href="{{ route('edit-profile-form.page', ['user_id' => auth()->user()->id]) }}">Edit profile</a></li>
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
                    <div class="mt-3 mt-lg-0">
                        <a href="{{ route('login.page') }}" class="text-decoration-none">
                            <button type="button" class="btn btn-outline-light me-2">Login</button>
                        </a>
                        <a href="{{ route('register.page') }}" class="text-decoration-none">
                            <button type="button" class="btn btn-light">Register</button>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</nav>
