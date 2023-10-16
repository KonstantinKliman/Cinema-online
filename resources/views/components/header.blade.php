<div class="container-fluid">
    <header
        class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
        <div class="col-md-3 mb-2 mb-md-0">
            <a href="{{ route('home.page') }}" class="d-inline-flex link-body-emphasis text-decoration-none text-light">
                Cinema-online
            </a>
        </div>
        <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
            <li><a href="{{ route('home.page') }}" class="nav-link text-light px-2">Home</a></li>
        </ul>

        <div class="col-md-3 text-end d-flex justify-content-end align-items-center">
            @if(auth()->check())
                <a href="#" class="text-decoration-none text-light fw-semibold me-2">{{ auth()->user()->name }}</a>
                <form action="{{ route('logout.action') }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-outline-light p-1 m-0">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login.page') }}" class="text-decoration-none">
                    <button type="button" class="btn btn-outline-light me-2">Login</button>
                </a>
                <a href="{{ route('register.page') }}" class="text-decoration-none">
                    <button type="button" class="btn btn-light">Register</button>
                </a>
            @endif
        </div>
    </header>
</div>
