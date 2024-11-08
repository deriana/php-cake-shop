<?php
include __DIR__ . '../../../../public/views/partials/header.php' ?>

<div class="main-content">
    <div class="container mt-5">
        <h3 class="mb-4">Tambah Penjualan</h3>

        <!-- Menampilkan pesan error jika ada -->
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error_message); ?></div>
        <?php endif; ?>

        <form action="/cake-shop/?act=sales-save" method="POST">
            <!-- Pilih Kue -->
            <div class="form-group">
                <label for="cake_id">Pilih Kue</label>
                <select name="cake_id" class="form-control" required>
                    <?php if (empty($cakes)): ?>
                        <option value="">Tidak ada kue tersedia</option>
                    <?php else: ?>
                        <?php foreach ($cakes as $cake): ?>
                            <?php if ($cake['stock'] > 0): ?>
                                <option value="<?= htmlspecialchars($cake['id']); ?>" data-price="<?= htmlspecialchars($cake['price']); ?>">
                                    <?= htmlspecialchars($cake['name']); ?> - Stok: <?= htmlspecialchars($cake['stock']); ?> - Harga: Rp <?= number_format($cake['price'], 2, ',', '.'); ?>
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <!-- Jumlah -->
            <div class="form-group">
                <label for="quantity">Jumlah</label>
                <input type="number" name="quantity" class="form-control" min="1" required>
            </div>

            <!-- Nama Pembeli -->
            <div class="form-group">
                <label for="pembeli">Nama Pembeli</label>
                <input type="text" name="pembeli" class="form-control" placeholder="Masukkan nama pembeli" maxlength="255" required>
            </div>

            <!-- Diskon -->
            <div class="form-group">
                <label for="discount">Diskon (%)</label>
                <div class="input-group">
                    <input type="number" name="discount" class="form-control" value="0" min="0" max="100" id="discount">
                    <div class="input-group-append">
                        <span class="input-group-text">%</span>
                    </div>
                </div>
            </div>

            <!-- Metode Pembayaran -->
            <div class="form-group">
                <label for="payment_method">Metode Pembayaran</label>
                <select name="payment_method" class="form-control" required>
                    <option value="cash">Tunai</option>
                    <option value="rek">Rekening</option>
                </select>
            </div>

            <!-- Tombol Submit dan Kembali -->
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="/cake-shop/?act=sales-manage" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '../../../../public/views/partials/footer.php' ?>