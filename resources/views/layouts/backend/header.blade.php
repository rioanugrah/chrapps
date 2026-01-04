<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="https://is3.cloudhost.id/eagleinformatika/Logo%20Eagle%20Media%20Informatika.webp" alt="" height="24">
                    </span>
                    <span class="logo-lg">
                        <img src="https://is3.cloudhost.id/eagleinformatika/Logo%20Eagle%20Media%20Informatika.webp" alt="" height="24"> <span
                            class="logo-txt">CHR</span>
                    </span>
                </a>

                <a class="logo logo-light">
                    <span class="logo-sm">
                        <img src="https://is3.cloudhost.id/eagleinformatika/Logo%20Eagle%20Media%20Informatika.webp" alt="" height="24">
                    </span>
                    <span class="logo-lg">
                        <img src="https://is3.cloudhost.id/eagleinformatika/Logo%20Eagle%20Media%20Informatika.webp" alt="" height="24"> <span
                            class="logo-txt">CHR</span>
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>

        </div>

        <div class="d-flex">

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item bg-light-subtle border-start border-end"
                    id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{ url('/') }}/assets/images/users/avatar-1.jpg"
                        alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1 fw-medium">{{ auth()->user()->name }}</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="apps-contacts-profile.html"><i
                            class="mdi mdi mdi-face-man font-size-16 align-middle me-1"></i> Profile</a>
                    <a class="dropdown-item" href="auth-lock-screen.html"><i
                            class="mdi mdi-lock font-size-16 align-middle me-1"></i> Lock Screen</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i
                            class="mdi mdi-logout font-size-16 align-middle me-1"></i> Logout</a>
                </div>
            </div>

        </div>
    </div>
</header>
