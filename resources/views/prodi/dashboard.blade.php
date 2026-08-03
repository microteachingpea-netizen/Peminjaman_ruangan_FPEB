@extends('layouts.master')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h2 mb-0 font-weight-bold text-gray-950"><i class="fas fa-tachometer-alt mr-2"></i> Dashboard Prodi</h1>
</div>

<div class="row mb-4">
    <div class="col-xl col-md-4 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1" style="font-size: 0.85rem;">Booking</div>
                <div class="h3 mb-0 font-weight-bold text-gray-900">{{ $stats['bookings'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-xl col-md-4 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1" style="font-size: 0.85rem;">Menunggu</div>
                <div class="h3 mb-0 font-weight-bold text-gray-900">{{ $stats['pending'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-xl col-md-4 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1" style="font-size: 0.85rem;">Ruangan</div>
                <div class="h3 mb-0 font-weight-bold text-gray-900">{{ $stats['rooms'] }}</div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header bg-light py-3">
        <h6 class="m-0 font-weight-bold text-dark" style="font-size: 1.1rem;"><i class="fas fa-history mr-1"></i> Booking Prodi Terbaru</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" style="font-size: 1.05rem;">
                <thead class="bg-light text-dark font-weight-bold">
                    <tr>
                        <th class="py-3">Kode</th>
                        <th class="py-3">Peminjam</th>
                        <th class="py-3">Ruangan</th>
                        <th class="py-3">Tanggal & Waktu</th>
                        <th class="py-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentBookings as $b)
                    <tr>
                        <td class="align-middle font-weight-bold">#{{ $b->id }}</td>
                        <td class="align-middle">
                            <strong class="text-dark" style="font-size: 1.1rem;">{{ $b->applicant }}</strong><br>
                            <span class="text-muted" style="font-size: 0.95rem;">{{ $b->prodi }}</span>
                        </td>
                        <td class="align-middle font-weight-bold text-dark">{{ $b->room->name ?? '-' }}</td>
                        <td class="align-middle">
                            <span class="font-weight-bold text-secondary">{{ $b->date }}</span><br>
                            <small class="text-dark font-weight-bold">{{ $b->start_time }} - {{ $b->end_time }}</small>
                        </td>
                        <td class="align-middle text-center">
                            <span class="badge badge-{{ $b->status === 'pending' ? 'warning' : ($b->status === 'approved' ? 'success' : 'danger') }} p-2 font-weight-bold" style="font-size: 0.9rem;">
                                {{ ucfirst($b->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-muted py-5 font-weight-bold" style="font-size: 1.1rem;">Belum ada data booking.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
