<?php 
include __DIR__ . '../../../../public/views/partials/header.php' ?>

<div class="main-content">
    <div class="container mt-4">
        <div class="row d-flex justify-content-between align-items-center mb-4">
            <h3>Data Kue</h3>
            <a href="/cake-shop/?act=input-kue" class="btn btn-primary">Tambah Kue</a>
        </div>

        <!-- Input Pencarian -->
        <input type="text" id="searchInput" class="form-control mb-4" placeholder="Cari berdasarkan nama kue...">

        <div class="row" id="cakeContainer">
            <?php foreach ($rs as $cake): ?>
                <div class="col-md-6 mb-4 cake-item">
                    <div class="p-3 border rounded bg-light">
                        <div class="row">
                            <!-- Bagian Gambar -->
                            <div class="col-4 text-center">
                                <?php if (!empty($cake['imgurl'])): ?>
                                    <img src="/cake-shop/<?= $cake['imgurl']; ?>" alt="Gambar Kue" style="width: 100%; height: auto; border-radius: 8px;" />
                                <?php else: ?>
                                    <div class="text-muted">Tidak ada gambar</div>
                                <?php endif; ?>
                            </div>

                            <!-- Bagian Detail Kue -->
                            <div class="col-8">
                                <h5 class="cake-name"><?= $cake['name']; ?></h5>
                                <p><strong>Harga:</strong> Rp<?= number_format($cake['price'], 3, ',', '.'); ?></p>
                                <p><strong>Category:</strong> <?= $cake['category']; ?></p>
                                <p><strong>Stok:</strong> <?= $cake['stock']; ?></p>

                                <!-- Bagian Tombol Aksi -->
                                <div class="mt-2">
                                    <a href="?act=edit-kue&i=<?= $cake['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                                    <a href="?act=tampil-kue&i=<?= $cake['id']; ?>" class="btn btn-info btn-sm">Detail</a>
                                    <a onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')"
                                        href="?act=hapus-kue&id=<?= $cake['id']; ?>" class="btn btn-danger btn-sm">Hapus</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<script>
    document.getElementById('searchInput').addEventListener('input', function() {
        const searchValue = this.value.toLowerCase();
        const cakes = document.querySelectorAll('.cake-item');

        cakes.forEach(function(cake) {
            const cakeName = cake.querySelector('.cake-name').textContent.toLowerCase();
            if (cakeName.includes(searchValue)) {
                cake.style.display = '';
            } else {
                cake.style.display = 'none';
            }
        });
    });
</script>

<?php include __DIR__ . '../../../../public/views/partials/footer.php' ?>