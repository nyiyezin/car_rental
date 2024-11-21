<header class="navbar navbar-expand-lg bd-navbar sticky-top z-3">
    <nav class="bd-gutter flex-lg-nowrap container flex-wrap" aria-label="Main navigation">

        <button class="navbar-toggler p-2" data-bs-toggle="collapse" data-bs-target="#navbarNav" type="button"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <svg class="bi" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                 viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                      d="M2.5 11.5A.5.5 0 0 1 3 11h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 7h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 3h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z">
                </path>
            </svg>
            <span class="d-none fs-6 pe-1">Browse</span>
        </button>

        <div class="navbar-collapse collapse" id="navbarNav">
            <ul class="navbar-nav ms-lg-auto flex-row flex-wrap">
                <li class="nav-item col-6 col-lg-auto">
                    <a class="nav-link px-lg-2 {{ request()->routeIs('cars.index') ? 'active' : '' }} px-0 py-2 text-white"
                       href="{{ url('/') }}">Home</a>
                </li>
                {{-- <li class="nav-item col-6 col-lg-auto">
                    <a class="nav-link py-2 px-0 px-lg-2 {{ request()->routeIs('services.index') ? 'active' : '' }}"
                        href="{{ route('services.index') }}">Services</a>
                </li> --}}
            </ul>
        </div>
    </nav>
</header>
