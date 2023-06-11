<div class="leftside-menu">
    <!-- LOGO -->
    <a href="{{ url('/') }}" class="logo text-center logo-light">
        <span class="logo-lg">
            <img src="{{ asset('') }}assets/images/logo.png" alt="" height="16">
        </span>
        <span class="logo-sm">
            <img src="{{ asset('') }}assets/images/logo_sm.png" alt="" height="16">
        </span>
    </a>

    <!-- LOGO -->
    <a href="{{ url('/') }}" class="logo text-center logo-dark">
        <span class="logo-lg">
            <img src="{{ asset('') }}assets/images/logo-dark.png" alt="" height="16">
        </span>
        <span class="logo-sm">
            <img src="{{ asset('') }}assets/images/logo_sm_dark.png" alt="" height="16">
        </span>
    </a>

    <div class="h-100" id="leftside-menu-container" data-simplebar="">
        <ul class="side-nav">
            <li class="side-nav-item">
                <a href="{{ route('dashboard.index') }}" class="side-nav-link">
                    <i class="uil-home-alt"></i>
                    <span> Dashboard </span>
                </a>
            </li>
            <li class="side-nav-title side-nav-item">Navigation</li>

            @can('admin')
            <li class="side-nav-item">
                <a href="{{ route('admin.users.index') }}" class="side-nav-link">
                    <i class="uil-user"></i>
                    <span> Users </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ url('admin/rooms') }}" class="side-nav-link">
                    <i class="uil-window"></i>
                    <span> Ruangan </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ url('admin/items') }}" class="side-nav-link">
                    <i class="uil-clipboard-alt"></i>
                    <span> Barang </span>
                </a>
            </li>

            @endcan

            @can('operator')
            <li class="side-nav-item">
                <a href="{{ url('operator/rooms') }}" class="side-nav-link">
                    <i class="uil-window"></i>
                    <span> Ruangan </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ url('operator/items') }}" class="side-nav-link">
                    <i class="uil-clipboard-alt"></i>
                    <span> Barang </span>
                </a>
            </li>

            @endcan


            <li class="side-nav-title side-nav-item">Main System</li>
            @can('admin')
            <li class="side-nav-item">
                <a href="{{ url('admin/borrows') }}" class="side-nav-link">
                    <i class="uil-shopping-cart-alt"></i>
                    <span> Peminjaman </span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="{{ url('/borrow-report') }}" class="side-nav-link">
                    <i class="uil-chart"></i>
                    <span> Laporan Peminjaman</span>
                </a>
            </li>
            @endcan
            @can('operator')
            <li class="side-nav-item">
                <a href="{{ url('operator/borrows') }}" class="side-nav-link">
                    <i class="uil-shopping-cart-alt"></i>
                    <span> Peminjaman </span>
                </a>
            </li>
            @endcan
            @can('borrower')
            <li class="side-nav-item">
                <a href="{{ url('borrower/borrows') }}" class="side-nav-link">
                    <i class="uil-shopping-cart-alt"></i>
                    <span> Peminjaman </span>
                </a>
            </li>
            @endcan
        </ul>

        <div class="help-box text-white text-center">
            <a href="javascript: void(0);" class="float-end close-btn text-white">
                <i class="mdi mdi-close"></i>
            </a>
            <img src="assets/images/help-icon.svg" height="90" alt="Helper Icon Image">
            <h5 class="mt-3">Unlimited Access</h5>
            <p class="mb-3">Upgrade to plan to get access to unlimited reports</p>
            <a href="javascript: void(0);" class="btn btn-outline-light btn-sm">Upgrade</a>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
