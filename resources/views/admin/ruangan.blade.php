<div class="modal fade" id="tambahRuanganModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title font-weight-bold text-dark" id="exampleModalLabel" style="font-size: 1.15rem;">
                    <i class="fas fa-plus-circle mr-1 text-primary"></i> Tambah Ruangan Baru
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('rooms.store') }}" method="POST">
                @csrf
                <div class="modal-body" style="font-size: 1.05rem;">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark">Nama Ruangan</label>
                        <input type="text" name="nama_ruangan" class="form-control" style="font-size: 1.05rem; padding: 12px;" required placeholder="Masukkan nama ruangan...">
                    </div>
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark">Kapasitas</label>
                        <input type="number" name="kapasitas" class="form-control" style="font-size: 1.05rem; padding: 12px;" min="1" required placeholder="Jumlah kapasitas orang...">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary px-4 py-2 font-weight-bold" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 py-2 font-weight-bold shadow-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>