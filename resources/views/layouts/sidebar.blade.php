<ul class="navbar-nav sidebar sidebar-dark accordion" style="background-color: #FF8C00; width: 260px;" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center py-4" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('assets/img/download.png') }}" alt="Logo" style="max-height: 50px; width: 100px; object-fit: contain;" onerror="this.style.display='none'">
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Log Persetujuan -->
    <li class="nav-item {{ request()->routeIs('admin.bookings.index') ? 'active' : '' }}">
        <a class="nav-link py-3 px-4" href="{{ route('admin.bookings.index') }}" style="font-size: 1rem;">
            <i class="fas fa-fw fa-clipboard-check mr-2"></i>
            <span class="font-weight-bold">Log Persetujuan</span>
        </a>
    </li>
    
    <!-- Nav Item - Kelola Booking -->
    <li class="nav-item {{ request()->routeIs('admin.bookings.manage*') ? 'active' : '' }}">
        <a class="nav-link py-3 px-4" href="{{ route('admin.bookings.index') }}" style="font-size: 1rem;">
            <i class="fas fa-fw fa-calendar-check mr-2"></i>
            <span class="font-weight-bold">Kelola Booking</span>
        </a>
    </li>

    <!-- Nav Item - Data Ruangan -->
    <li class="nav-item {{ request()->routeIs('admin.rooms.*') ? 'active' : '' }}">
        <a class="nav-link py-3 px-4" href="{{ route('admin.rooms.index') }}" style="font-size: 1rem;">
            <i class="fas fa-fw fa-door-open mr-2"></i>
            <span class="font-weight-bold">Data Ruangan</span>
        </a>
    </li>

    <!-- Nav Item - Data User -->
    <li class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
        <a class="nav-link py-3 px-4" href="{{ route('admin.users.index') }}" style="font-size: 1rem;">
            <i class="fas fa-fw fa-users mr-2"></i>
            <span class="font-weight-bold">Data User</span>
        </a>
    </li>

    <!-- Nav Item - Data Role -->
    <li class="nav-item {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
        <a class="nav-link py-3 px-4" href="{{ route('admin.roles.index') }}" style="font-size: 1rem;">
            <i class="fas fa-fw fa-user-tag mr-2"></i>
            <span class="font-weight-bold">Data Role</span>
        </a>
    </li>

    <!-- Nav Item - Permission -->
    <li class="nav-item {{ request()->routeIs('admin.permissions.*') ? 'active' : '' }}">
        <a class="nav-link py-3 px-4" href="{{ route('admin.permissions.index') }}" style="font-size: 1rem;">
            <i class="fas fa-fw fa-key mr-2"></i>
            <span class="font-weight-bold">Permission</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline pb-3">
        <button class="rounded-circle border-0 shadow-sm" id="sidebarToggle" style="width: 40px; height: 40px; background-color: rgba(255, 255, 255, 0.3); color: white;"></button>
    </div>
</ul>