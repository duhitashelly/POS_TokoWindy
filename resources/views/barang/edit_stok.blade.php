<form action="{{ route('barang.updateStok', $barang->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="stok">Stok</label>
        <input type="number" name="stok" class="form-control" value="{{ $barang->stok }}" min="0" required>
    </div>

    <button type="submit" class="btn btn-primary">Update Stok</button>
</form>
