<aside id="sidebar">
    <div class="d-flex">
        <button class="toggle-btn" type="button">
            <i class="fa-solid fa-car"></i>
        </button>
        <div class="sidebar-logo">
            <a href="#">Car Rental</a>
        </div>
    </div>
    <ul class="sidebar-nav">
        <li class="sidebar-item">
            <a class="sidebar-link" href="#">
                <i class="fa-solid fa-user"></i>
                <span>Profile</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a class="sidebar-link" href="#">
                <i class="fa-regular fa-credit-card"></i>
                <span>Bookings</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse" data-bs-target="#auth"
               href="#" aria-expanded="false" aria-controls="auth">
                <i class="fa-solid fa-car-side"></i>
                <span>Cars</span>
            </a>
            <ul class="sidebar-dropdown list-unstyled collapse" id="auth" data-bs-parent="#sidebar">
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#">Available</a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="#">Unavailable</a>
                </li>
            </ul>
        </li>
    </ul>
</aside>
