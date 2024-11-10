<?php
include __DIR__ . '../../../../public/views/partials/header.php' ?>
<!-- Konten Utama -->
<div class="main-content">
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center">
            <h3>Laporan Penjualan</h3>
            <div class="d-flex">
                <a href="/cake-shop/?act=pdf-sales&start_date=<?= isset($_GET['start_date']) ? $_GET['start_date'] : '' ?>&end_date=<?= isset($_GET['end_date']) ? $_GET['end_date'] : '' ?>" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm me-3">
                    <i class="fas fa-download fa-sm text-white-50"></i> Generate Report (Pdf)
                </a>
            </div>
        </div>

        <!-- Tabel Sales -->
        <?php if ($salesData && count($salesData) > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Pelanggan</th>
                            <th>Kue</th>
                            <th>Jumlah</th>
                            <th>Diskon</th>
                            <th>Penjualan (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($salesData as $sale): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars(date('Y-m-d', strtotime($sale['created_at']))); ?></td>
                                <td><?= htmlspecialchars($sale['pembeli']); ?></td>
                                <td><?= htmlspecialchars($sale['cake_name']); ?></td>
                                <td><?= htmlspecialchars($sale['quantity']); ?></td>
                                <td><?= number_format($sale['discount'], 3, ',', '.'); ?></td>
                                <td>Rp <?= number_format($sale['total_price'], 3, ',', '.'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Menampilkan total penjualan -->
            <p class="mt-3"><strong>Total Penjualan: Rp <?= number_format(array_sum(array_column($salesData, 'total_price')), 2, ',', '.'); ?></strong></p>

        <?php else: ?>
            <p>Tidak ada data penjualan yang ditemukan untuk periode ini.</p>
        <?php endif; ?>

        <a href="/cake-shop/?act=laporan" class="btn btn-primary mt-3">Kembali ke Laporan</a>
    </div>
</div>

<?php include __DIR__ . '../../../../public/views/partials/footer.php' ?>