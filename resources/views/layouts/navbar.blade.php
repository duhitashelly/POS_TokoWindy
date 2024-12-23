<!-- Navbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <span class="badge badge-danger badge-counter">
                    {{ $lowStockCount > 0 ? $lowStockCount . '+' : '' }}
                </span>
            </a>

            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">Alerts Center</h6>
                @if(isset($lowStockItems) && $lowStockItems->count() > 0)
                    <div class="alert alert-warning">
                        <strong>Perhatian!</strong> Ada barang dengan stok kurang dari 2:
                        <ul>
                            @foreach($lowStockItems as $item)
                                <li>{{ $item->nama_barang }} (Stok: {{ $item->stok }})</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </li>
         <!-- Nav Item - User Information -->
         <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{ route('profile.index') }}">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <a class="dropdown-item" href="{{ route('profile.show') }}">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    Settings
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="dropdown-item">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Logout
                        </button>
                    </form>
                </a>
            </div>
        </li>
    </ul>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const alertsDropdown = document.getElementById('alertsDropdown');
        const dropdownMenu = alertsDropdown.nextElementSibling;

        alertsDropdown.addEventListener('click', function (e) {
            dropdownMenu.classList.toggle('show'); // Toggle dropdown
        });

        // Menutup dropdown jika area lain di luar dropdown diklik
        document.addEventListener('click', function (e) {
            if (!alertsDropdown.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.remove('show'); // Menutup dropdown
            }
        });
    });
</script>
