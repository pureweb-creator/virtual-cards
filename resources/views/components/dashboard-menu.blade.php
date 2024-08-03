<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
            <span>Menu</span>
        </h6>
        <ul class="nav flex-column mb-2">
            <li class="nav-item">
                <a class="nav-link d-flex align-items-center gap-2 {{request()->is('dashboard') ? 'active' : ''}}" href="{{route('profile.dashboard')}}">
                    <i class="bi bi-person-circle"></i>
                    Profile
                </a>

                <a class="nav-link d-flex align-items-center gap-2" href="{{route('logout')}}">
                    <i class="bi bi-box-arrow-in-right"></i>
                    Sign out
                </a>
            </li>
        </ul>
    </div>
</nav>
