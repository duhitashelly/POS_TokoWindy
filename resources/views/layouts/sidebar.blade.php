<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Toko Windy</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Menu Admin -->
    @if(auth()->check() && auth()->user()->isAdmin())
        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('laporan.index') }}">
                <i class="fas fa-fw fa-chart-line"></i>
                <span>Laporan</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('kategori.index') }}">
                <i class="fas fa-fw fa-boxes"></i>
                <span>Kategori</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('barang.index') }}">
                <i class="fas fa-fw fa-box"></i>
                <span>Barang</span>
            </a>
        </li>
    @elseif(auth()->check() && auth()->user()->isKasir())
        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('transaksi.index') }}">
                <i class="fas fa-fw fa-cash-register"></i>
                <span>Transaksi</span>
            </a>
        </li>
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>