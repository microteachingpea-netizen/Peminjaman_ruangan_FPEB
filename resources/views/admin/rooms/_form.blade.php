<div class="form-group">
    <label class="font-weight-bold text-dark" style="font-size: 1.1rem;">Nama Ruangan</label>
    <input type="text" name="name" class="form-control" style="font-size: 1.1rem; padding: 14px;" value="{{ old('name', $room->name ?? '') }}" required>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="font-weight-bold text-dark" style="font-size: 1.1rem;">Kapasitas</label>
            <input type="number" name="capacity" class="form-control" style="font-size: 1.1rem; padding: 14px;" value="{{ old('capacity', $room->capacity ?? '') }}" min="1" required>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="form-group">
            <label class="font-weight-bold text-dark" style="font-size: 1.1rem;">Foto Ruangan (Opsional)</label>
            <div class="custom-file" style="height: 48px;">
                <input type="file" name="image" class="custom-file-input" id="roomImage{{ isset($room) ? $room->id : 'new' }}" accept="image/*" onchange="updateFileName(this)">
                <label class="custom-file-label text-truncate" for="roomImage{{ isset($room) ? $room->id : 'new' }}" style="font-size: 1.05rem; padding-top: 10px; height: 48px;">Pilih file foto...</label>
            </div>
            @if(isset($room) && $room->image)
                <small class="text-muted d-block mt-2 font-weight-bold" style="font-size: 1rem;">
                    Foto saat ini: <a href="{{ asset('storage/' . $room->image) }}" target="_blank" class="text-primary font-weight-bold">Lihat Foto</a>
                </small>
            @endif
        </div>
    </div>
</div>

<div class="form-group mt-2">
    <label class="font-weight-bold text-dark" style="font-size: 1.1rem;">Deskripsi Ruangan</label>
    <textarea name="description" class="form-control" rows="3" style="font-size: 1.1rem;">{{ old('description', $room->description ?? '') }}</textarea>
</div>

<div class="form-group">
    <label class="font-weight-bold text-dark" style="font-size: 1.1rem;">Fasilitas</label>
    <div class="row mt-2">
        @php
            $currentRoom = isset($room) ? $room : null;
            $selected = old('facilities', $currentRoom ? $currentRoom->facilityList->pluck('id')->all() : []);
            if (empty($selected) && $currentRoom && $currentRoom->facilities) {
                $selected = \App\Models\Facility::whereIn('name', $currentRoom->facilities)->pluck('id')->all();
            }
        @endphp
        @foreach($facilities as $f)
        <div class="col-6 mb-3">
            <div class="custom-control custom-checkbox" style="font-size: 1.1rem;">
                <input type="checkbox" name="facilities[]" value="{{ $f->id }}" class="custom-control-input"
                       id="fac_{{ $f->id }}_{{ isset($room) ? $room->id : 'new' }}"
                       {{ in_array($f->id, $selected) ? 'checked' : '' }}>
                <label class="custom-control-label text-dark font-weight-bold" for="fac_{{ $f->id }}_{{ isset($room) ? $room->id : 'new' }}">{{ $f->name }}</label>
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- Script agar nama file muncul pada label bootstrap custom-file --}}
<script>
    function updateFileName(input) {
        if (input.files && input.files[0]) {
            let fileName = input.files[0].name;
            let label = input.nextElementSibling;
            label.textContent = fileName;
        }
    }
</script>