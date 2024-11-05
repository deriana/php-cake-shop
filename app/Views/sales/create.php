<html>

<head>
    <title>Tambah Penjualan - Cake Shop</title>
    <link rel="stylesheet" href="/mvc-example/assets/css/bootstrap.css" />
</head>

<body>
    <div class="container">
        <h3>Tambah Penjualan</h3>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error_message); ?></div>
        <?php endif; ?>

        <form action="/mvc-example/?act=sales-save" method="POST">
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

            <div class="form-group">
                <label for="quantity">Jumlah</label>
                <input type="number" name="quantity" class="form-control" min="1" required>
            </div>

            <div class="form-group">
                <label for="pembeli">Nama Pembeli</label>
                <input type="text" name="pembeli" class="form-control" placeholder="Masukkan nama pembeli" maxlength="255">
            </div>

            <div class="form-group">
                <label for="discount">Diskon (%)</label>
                <input type="number" name="discount" class="form-control" value="0" min="0" max="100">
            </div>

            <div class="form-group">
                <label for="payment_method">Metode Pembayaran</label>
                <select name="payment_method" class="form-control" required>
                    <option value="cash">Tunai</option>
                    <option value="rek">Rekening</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="/mvc-example/?act=sales-manage" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>

</html>