<?php 
include __DIR__ . '../../../../public/views/partials/header.php' ?>

<div class="main-content">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h3 class="text-center mb-4">Edit Data Kue</h3>

                <!-- Form Edit Data Kue -->
                <form method="post" action="/cake-shop/?act=update-kue" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $cake['id']; ?>" />

                    <div class="form-group">
                        <label for="name">Nama Kue</label>
                        <input type="text" id="name" class="form-control" name="name" value="<?= $cake['name']; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="category">Kategori Kue</label>
                        <select id="category" class="form-control" name="category" required>
                            <option value="Kue Balok" <?= $cake['category'] == 'Kue Balok' ? 'selected' : ''; ?>>Kue Balok</option>
                            <option value="Kue Bolu" <?= $cake['category'] == 'Kue Bolu' ? 'selected' : ''; ?>>Kue Bolu</option>
                            <option value="Kue Lapis Talas" <?= $cake['category'] == 'Kue Lapis Talas' ? 'selected' : ''; ?>>Kue Lapis Talas</option>
                            <option value="Brownies" <?= $cake['category'] == 'Brownies' ? 'selected' : ''; ?>>Brownies</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="price">Harga</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input type="text" id="price" class="form-control" name="price"
                                value="<?= 'Rp ' . number_format($cake['price'], 0, ',', '.'); ?>"
                                onfocus="prepareInputPrice(this)"
                                onkeyup="formatCurrency(this)" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="stock">Stok</label>
                        <input type="number" id="stock" class="form-control" name="stock" value="<?= $cake['stock']; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="imgurl">Upload Gambar Kue (Kosongkan jika tidak ingin mengubah)</label>
                        <input type="file" id="imgurl" class="form-control-file" name="imgurl">
                    </div>

                    <button type="submit" class="btn btn-primary btn-block mt-4">Update</button>
                </form>

                <div class="mt-4 text-center">
                    <a href="/cake-shop/?act=tampil-kue" class="btn btn-secondary">Kembali ke Daftar Kue</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Fungsi untuk memformat input harga menjadi format Rupiah
    function formatCurrency(input) {
        let value = input.value.replace(/[^0-9]/g, ''); // Hanya angka
        if (value) {
            input.value = 'Rp ' + parseInt(value).toLocaleString('id-ID'); // Format ke Rupiah
        } else {
            input.value = '';
        }
    }

    // Fungsi untuk mempersiapkan input harga saat mendapatkan fokus
    function prepareInputPrice(input) {
        let value = input.value.replace(/[^0-9]/g, ''); // Hapus "Rp" dan format angka menjadi integer
        input.value = value; // Hanya angka yang tersimpan saat input fokus
    }
</script>

<?php include __DIR__ . '../../../../public/views/partials/footer.php' ?>