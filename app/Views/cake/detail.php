<?php 
include __DIR__ . '../../../../public/views/partials/header.php'; 
?>
<!-- Konten Utama -->
<div class="main-content">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header text-center bg-primary text-white">
                        <h4>Detail Kue</h4>
                    </div>
                    <div class="card-body">
                        <!-- Bagian Gambar -->
                        <div class="text-center mb-4">
                            <?php 
                                $imgPath = '/cake-shop/' . $cakes['imgurl'];
                            ?>
                            <img src="<?= $imgPath; ?>" alt="Gambar Kue" class="img-fluid rounded" style="max-width: 80%; height: auto; border: 1px solid #ddd; padding: 8px;" />
                        </div>
    
                        <!-- Bagian Informasi Kue -->
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>ID:</strong> <?= $cakes['id']; ?></li>
                            <li class="list-group-item"><strong>Nama:</strong> <?= htmlspecialchars($cakes['name']); ?></li>
                            <li class="list-group-item"><strong>Harga:</strong> Rp <?= number_format($cakes['price'], 3, ',', '.'); ?></li>
                            <li class="list-group-item"><strong>Stok:</strong> <?= $cakes['stock']; ?></li>
                            <li class="list-group-item"><strong>Kategori:</strong> <?= htmlspecialchars($cakes['name']); ?></li>
                        </ul>
                    </div>
                    <div class="card-footer text-center">
                        <a href="/cake-shop/?act=tampil-kue" class="btn btn-secondary">Kembali ke Daftar Kue</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '../../../../public/views/partials/footer.php'; ?>
