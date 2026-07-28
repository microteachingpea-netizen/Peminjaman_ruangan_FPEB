<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars fa-lg"></i>
    </button>

    <ul class="navbar-nav ml-auto align-items-center">
        <li class="nav-item d-flex align-items-center px-2">
            <span class="nav-link text-dark font-weight-bold" style="font-size: 1.05rem;">
                Selamat datang, <strong class="text-primary">{{ auth()->user()->name }}</strong>!
            </span>
        </li>
        
        <!-- Menu Notifikasi -->
        <li class="nav-item d-flex align-items-center px-2">
            <a class="nav-link text-primary position-relative px-3 py-2" href="{{ route('admin.notifications.index') }}" style="font-size: 1.1rem;" title="Notifikasi">
                <i class="fas fa-bell fa-lg mr-1"></i>
                @php 
                    $unread = 0;
                    try {
                        if (\Illuminate\Support\Facades\Schema::hasTable('notifs')) {
                            $unread = auth()->user()->notifs()->where('is_read', false)->count();
                        }
                    } catch (\Exception $e) {
                        $unread = 0;
                    }
                @endphp
                @if($unread > 0)
                    <span class="badge badge-danger font-weight-bold" style="font-size: 0.75rem; position: absolute; top: 5px; right: 5px;">{{ $unread }}</span>
                @endif
            </a>
        </li>

        <li class="nav-item d-flex align-items-center px-2">
            <a class="nav-link text-primary font-weight-bold py-2 px-3" href="{{ route('main') }}" style="font-size: 1.05rem;">
                <i class="fas fa-home mr-2"></i> Beranda
            </a>
        </li>
        
        <li class="nav-item d-flex align-items-center px-2">
            <form action="{{ route('logout') }}" method="POST" class="d-inline m-0">
                @csrf
                <button type="submit" class="nav-link btn btn-link text-danger font-weight-bold border-0 py-2 px-3" style="font-size: 1.05rem;" onclick="return confirm('Yakin ingin keluar aplikasi?')">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </button>
            </form>
        </li>
    </ul>
</nav>

@if(session('success'))
    <div class="container-fluid">
        <div class="alert alert-success font-weight-bold shadow-sm" style="font-size: 1.05rem;">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
    </div>
@endif

@if(session('error'))
    <div class="container-fluid">
        <div class="alert alert-danger font-weight-bold shadow-sm" style="font-size: 1.05rem;">
            <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
        </div>
    </div>
@endif

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap4.min.css">

<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>