<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        @if (Auth()->user()->role == 'admin')
        <li class="nav-heading">Data Jukir</li>

        <li class="nav-item">
            <a class="nav-link {{ Route::is('data-jukir.index') ? 'active' : '' }}" href="{{ route('data-jukir.index') }}">
                <i class="ri-account-pin-circle-fill"></i>
                <span>Data Jukir</span>
            </a>
        </li>

        <li class="nav-heading">Data Jenis Kendaraan</li>
         <li class="nav-item">
            <a class="nav-link {{ Route::is('data-kendaraan.index') ? 'active' : '' }}" href="{{ route('data-kendaraan.index') }}">
                <i class="ri-account-pin-circle-fill"></i>
                <span>Data Jenis Kendaraan</span>
            </a>
        </li>
        @endif

        @if (Auth()->user()->role == 'jukir')
        <li class="nav-item">
            <a class="nav-link {{ Route::is('data-parkir.index') ? 'active' : '' }}" href="{{ route('data-parkir.index') }}">
                <i class="ri-account-pin-circle-fill"></i>
                <span>Data Parkir</span>
            </a>
        </li>
        @endif

    </ul>

</aside>
