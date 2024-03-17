<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <div class="collapse navbar-collapse mt-lg-0 mt-md-2" id="navbarNavDropdown">
            <div class="d-flex justify-content-between align-items-center w-100">
                <ul class="navbar-nav text-center">
                        <a class="navbar-brand" href="{{ route('home.page') }}">Cinema-online</a>
                    <li class="nav-item">
                        <a class="nav-link active m-0" aria-current="page" href="{{ route('home.page') }}">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Genre
                        </a>
                        <ul class="dropdown-menu">
                            @foreach($genres as $genre)
                                <li><a class="dropdown-item" href="{{ route('genre.page', ['genre' => $genre->slug]) }}">{{ ucfirst($genre->name) }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
                @if(auth()->check())
                    <div class="dropdown">
                        <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person"></i>
                            {{ auth()->user()->name }}
                        </button>
                        <ul class="dropdown-menu-end dropdown-menu" >
                            <li><a class="dropdown-item text-end" href="{{ route('user.page', ['user_id' => auth()->user()->id]) }}">Your account</a></li>
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
