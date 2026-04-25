<!-- partial:partials/_navbar.html -->
<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
        <a class="navbar-brand brand-logo" href="#"><img src="{{ asset('purple/src/assets/images/logo/agt.png') }}"
                style="width: 70%; height: auto;" alt="logo" /></a>
        {{-- <h1 class="navbar-brand brand-logo">GP Margin</h1> --}}
        <a class="navbar-brand brand-logo-mini" href="#"><img
                src="{{ asset('purple/src/assets/images/elearning-mini.svg') }}"
                style="width: 100%; height: auto; align: center;" alt="logo" /></a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-stretch">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
        </button>

        <div class="navbar-nav  text-center navbar-toggler align-self-center">
            {{-- <img src="{{ asset('purple/src/assets/images/Logo Arbe.png') }}" style="width: 7%; height: auto;" alt=""> --}}
            <p class="mb-1 text-black">PT. Arbe Global Trading</p>
        </div>

        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item d-none d-lg-block full-screen-link">
                <a class="nav-link">
                    <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
                </a>
            </li>
            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <div class="nav-profile-img">
                        <img src="{{ asset('purple/src/assets/images/faces/face1.jpg') }}" alt="image">
                        <span class="availability-status online"></span>
                    </div>
                    <div class="nav-profile-text">
                        <p class="mb-1 text-black">{{ auth()->user()->name }}</p>
                    </div>
                </a>
                <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                    {{-- <a class="dropdown-item" href="#">
                        <i class="mdi mdi-cached me-2 text-success"></i> Activity Log </a>
                    <div class="dropdown-divider"></div> --}}
                    <a class="dropdown-item" href="{{ route('logout') }}" style="cursor: pointer"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit()">
                        <i class="mdi mdi-logout me-2 text-primary"></i> Signout </a>
                    <form action="{{ route('logout') }}" method="POST" style="display: none" id="logout-form">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
            data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
        </button>
    </div>
</nav>
