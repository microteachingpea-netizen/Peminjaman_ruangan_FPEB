@extends('layouts.master')

@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap4.min.css">

<style>
    /* Mengatur tombol export agar berada di bawah dan rata tengah */
    .dt-buttons {
        text-align: center !important;
        margin-top: 15px;
        margin-bottom: 15px;
        display: block;
    }
</style>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h2 mb-0 font-weight-bold text-gray-950"><i class="fas fa-clipboard-check mr-2"></i> Log Persetujuan / Kelola Booking</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        
        <div class="d-flex justify-content-end mb-3">
            <div style="width: 150px;">
                <select id="filterTahun" class="form-control form-control-sm">
                    <option value="">Semua Tahun</option>
                    <option value="2026">2026</option>
                    <option value="2027">2027</option>
                    <option value="2028">2028</option>
                    <option value="2029">2029</option>
                    <option value="2030">2030</option>
                </select>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0" style="font-size: 1.05rem;">
                <thead class="bg-light text-dark font-weight-bold">
                    <tr>
                        <th class="py-3">Kode</th>
                        <th class="py-3">Peminjam & Prodi</th>
                        <th class="py-3">Ruangan dan Waktu</th>
                        <th class="py-3">Catatan</th>
                        <th class="py-3">Status</th>
                        <th class="py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                    <tr>
                        <td class="align-middle font-weight-bold">#{{ $booking->id }}</td>
                        <td class="align-middle">
                            <strong class="text-dark" style="font-size: 1.1rem;">{{ $booking->applicant }}</strong><br>
                            <span class="text-muted" style="font-size: 0.95rem;">{{ $booking->prodi }}</span>
                        </td>
                        <td class="align-middle">
                            <span class="font-weight-bold text-dark">{{ $booking->room->name ?? '-' }}</span><br>
                            <span class="text-secondary" style="font-size: 0.95rem;">{{ $booking->date }} | {{ \Carbon\Carbon::parse($booking->start_time)->format('H.i') }}-{{ \Carbon\Carbon::parse($booking->end_time)->format('H.i') }}</span>
                        </td>
                        <td class="align-middle text-secondary">{{ Str::limit($booking->reason, 50) }}</td>
                        <td class="align-middle">
                            @if($booking->status === 'pending')
                                <span class="badge badge-warning p-2 font-weight-bold" style="font-size: 0.9rem;">Pending</span>
                            @elseif($booking->status === 'approved')
                                <span class="badge badge-success p-2 font-weight-bold" style="font-size: 0.9rem;">Disetujui</span>
                            @else
                                <span class="badge badge-danger p-2 font-weight-bold" style="font-size: 0.9rem;">Ditolak</span>
                            @endif
                        </td>
                        <td class="align-middle">
                            @if($booking->status === 'pending')
                            <form action="{{ route('admin.bookings.approve', $booking) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-success font-weight-bold px-3 py-2 mr-1" style="font-size: 0.95rem;">Approve</button>
                            </form>
                            <button class="btn btn-danger font-weight-bold px-3 py-2" style="font-size: 0.95rem;" data-toggle="modal" data-target="#rejectModal{{ $booking->id }}">Reject</button>
                            @else
                                <span class="text-muted font-weight-bold" style="font-size: 0.95rem;">Selesai</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted py-5 font-weight-bold" style="font-size: 1.1rem;">Belum ada pengajuan booking.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@foreach($bookings as $booking)
    @if($booking->status === 'pending')
    <div class="modal fade" id="rejectModal{{ $booking->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('admin.bookings.reject', $booking) }}" method="POST">
                    @csrf
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title font-weight-bold">Alasan Ditolak?</h5>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <label class="font-weight-bold text-dark">Tuliskan Alasan Penolakan:</label>
                        <textarea name="rejection_reason" class="form-control" rows="4" style="font-size: 1rem;" required placeholder="Tuliskan alasan penolakan..."></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary px-4 py-2 font-weight-bold" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger px-4 py-2 font-weight-bold">Kirim Penolakan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
@endforeach

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (typeof jQuery !== 'undefined') {
            var table = $('#dataTable').DataTable({
                // Mengubah posisi tombol agar berada di bawah ('B' ditaruh di bawah atau diatur terpisah)
                dom: '<"row"<"col-md-6"l><"col-md-6"f>>rt<"row"<"col-md-12 text-center"B>><"row"<"col-md-5"i><"col-md-7"p>>',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    }
                }
            });

            // Fungsi filter tahun
            $('#filterTahun').on('change', function() {
                var tahun = $(this).val();
                table.column(2).search(tahun).draw();
            });
        }
    });
</script>
@endsection