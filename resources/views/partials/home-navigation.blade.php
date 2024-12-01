<header class="header" data-header>
    <div class="container">
        <div class="overlay" data-overlay></div>
        <a href="#" class="logo">
            <p>Hello</p>
        </a>
        <nav class="navbar" data-navbar>
            <ul class="navbar-list">
                <li>
                    <a data-nav-link class="navbar-link {{ request()->routeIs('cars.index') ? 'active' : '' }} "
                        href="{{ url('/') }}">Home</a>
                </li>
            </ul>
        </nav>
        <div class="header-actions">
            <button class="nav-toggle-btn" data-nav-toggle-btn aria-label="Toggle Menu">
                <span class="one"></span>
                <span class="two"></span>
                <span class="three"></span>
            </button>
        </div>
    </div>
</header>
