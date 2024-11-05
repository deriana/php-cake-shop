<html>

<head>
    <title>Daftar Penjualan - Cake Shop</title>
    <link rel="stylesheet" href="/mvc-example/assets/css/bootstrap.css" />
</head>

<body>
    <div class="container">
        <h3>Daftar Penjualan</h3>
        <a href="/mvc-example/?act=sales-create" class="btn btn-primary mb-3">Tambah Penjualan</a>
        <table class="table table-responsive table-bordered table-striped">
            <tr>
                <th>ID</th>
                <th>Kue</th>
                <th>Jumlah</th>
                <th>Diskon (Rp)</th>
                <th>Total Harga (Rp)</th>
                <th>Metode Pembayaran</th>
                <th>Waktu</th>
            </tr>
            <?php foreach ($sales as $sale): ?>
                <tr>
                    <td><?= htmlspecialchars($sale['id']); ?></td>
                    <td><?= htmlspecialchars($sale['cake_name']); ?></td>
                    <td><?= htmlspecialchars($sale['quantity']); ?></td>
                    <td>Rp <?= number_format($sale['discount'], 3, ',', '.'); ?></td>
                    <td>Rp <?= number_format($sale['total_price'], 3, ',', '.'); ?></td>
                    <td><?= htmlspecialchars($sale['payment_method']); ?></td>
                    <td><?= htmlspecialchars($sale['created_at']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>

</html>