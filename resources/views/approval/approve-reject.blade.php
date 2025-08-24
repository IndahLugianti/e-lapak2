<!-- Modal atau form untuk approval -->
@if(Auth::user()->isApproval() && $ticket->status === 'proses')
<div class="card mt-3">
    <div class="card-header">Tindak Lanjut Tiket</div>
    <div class="card-body">
        <form action="{{ route('tickets.approve', $ticket) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Tindakan:</label>
                <select name="action" class="form-select" id="actionSelect" required>
                    <option value="">Pilih Tindakan</option>
                    <option value="approve">Setujui</option>
                    <option value="reject">Tolak</option>
                </select>
            </div>

            <div class="mb-3" id="notesDiv" style="display:none;">
                <label>Catatan:</label>
                <textarea name="notes" class="form-control" rows="3"
                          placeholder="Wajib diisi jika menolak"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>

<script>
document.getElementById('actionSelect').addEventListener('change', function() {
    const notesDiv = document.getElementById('notesDiv');
    const notesField = document.querySelector('[name="notes"]');

    if (this.value === 'reject') {
        notesDiv.style.display = 'block';
        notesField.required = true;
    } else {
        notesDiv.style.display = 'block';
        notesField.required = false;
    }
});
</script>
@endif
