<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <link rel="stylesheet" href="/mvc-example/assets/css/bootstrap.css" />
</head>
<body>
<div class="container">
    <h3>Laporan Penjualan</h3>

    <?php if ($salesData && count($salesData) > 0): ?>
        <table class="table table-responsive table-bordered">
            <thead>
                <tr>
                    <th>Nomor Faktur</th>
                    <th>Tanggal</th>
                    <th>Pelanggan</th>
                    <th>Penjualan</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($salesData as $sale): ?>
                    <tr>
                        <td><?= htmlspecialchars($sale['id']); ?></td>
                        <td><?= htmlspecialchars(date('Y-m-d', strtotime($sale['created_at']))); ?></td>
                        <td><?= htmlspecialchars($sale['pembeli']); ?></td>
                        <td>Rp <?= number_format($sale['total_price'], 2, ',', '.'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p><strong>Total Penjualan: Rp <?= number_format(array_sum(array_column($salesData, 'total_price')), 2, ',', '.'); ?></strong></p>
    <?php else: ?>
        <p>Tidak ada data penjualan yang ditemukan untuk periode ini.</p>
    <?php endif; ?>

    <a href="/mvc-example/?act=laporan" class="btn btn-secondary">Kembali ke Laporan</a>
</div>
</body>
</html>
