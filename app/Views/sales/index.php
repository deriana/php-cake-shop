<?php
include __DIR__ . '../../../../public/views/partials/header.php' ?>

<!-- Konten Utama -->
<div class="main-content">
    <div class="container mt-5">
        <h3 class="mb-4">Daftar Penjualan</h3>
        <a href="/cake-shop/?act=sales-create" class="btn btn-primary mb-3">Tambah Penjualan Kue</a>

        <!-- Tabel Users -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nama Pembeli</th>
                        <th>Kue</th>
                        <th>Jumlah</th>
                        <th>Diskon (Rp)</th>
                        <th>Total Harga (Rp)</th>
                        <th>Metode Pembayaran</th>
                        <th>Waktu</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($sales as $sale): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($sale['pembeli']); ?></td>
                            <td><?= htmlspecialchars($sale['cake_name']); ?></td>
                            <td><?= htmlspecialchars($sale['quantity']); ?></td>
                            <td>Rp <?= number_format($sale['discount'], 3, ',', '.'); ?></td>
                            <td>Rp <?= number_format($sale['total_price'], 3, ',', '.'); ?></td>
                            <td>
                                <?php
                                if ($sale['payment_method'] == 'cash') {
                                    echo 'Tunai';
                                } elseif ($sale['payment_method'] == 'rek') {
                                    echo 'Rekening';
                                } else {
                                    echo 'Unknown';
                                }
                                ?>
                            </td>
                            <td><?= htmlspecialchars($sale['created_at']); ?></td>
                            <td>
                                <a onclick="return confirm('Apakah anda yakin ingin menghapus Kue ini?')"
                                    href="?act=hapus-sale&id=<?= $sale['id']; ?>" class="btn btn-danger btn-sm">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '../../../../public/views/partials/footer.php' ?>