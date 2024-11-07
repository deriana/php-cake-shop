<?php 
include __DIR__ . '../../../../public/views/partials/header.php' ?>

<div class="main-content">
    <div class="container mt-5">
        <h3>Laporan Penjualan</h3>

        <?php if ($salesData && count($salesData) > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Nomor Faktur</th>
                            <th>Tanggal</th>
                            <th>Pelanggan</th>
                            <th>Penjualan (Rp)</th>
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
            </div>

            <p class="mt-3"><strong>Total Penjualan: Rp <?= number_format(array_sum(array_column($salesData, 'total_price')), 2, ',', '.'); ?></strong></p>
        <?php else: ?>
            <p>Tidak ada data penjualan yang ditemukan untuk periode ini.</p>
        <?php endif; ?>

        <a href="/cake-shop/?act=laporan" class="btn btn-primary mt-3">Kembali ke Laporan</a>
    </div>
</div>

<?php include __DIR__ . '../../../../public/views/partials/footer.php' ?>
