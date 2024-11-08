<?php
include __DIR__ . '../../../../public/views/partials/header.php';
?>

<div class="main-content">
    <div class="container mt-4">
        <div class="row d-flex justify-content-between align-items-center mb-4">
            <h3>Data Kue</h3>
            <div>
                <a href="/cake-shop/?act=input-kue" class="btn btn-primary">Tambah Kue</a>
                <a href="/cake-shop/?act=show-category" class="btn btn-success">Lihat Kategori</a>
            </div>
        </div>

        <div class="form-group">
            <label for="categorySelect">Kategori Kue</label>
            <select id="categorySelect" class="form-control mb-4">
                <option value="">Pilih Kategori</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= htmlspecialchars($category['id']); ?>">
                        <?= htmlspecialchars($category['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Input Pencarian -->
        <input type="text" id="searchInput" class="form-control mb-4" placeholder="Cari berdasarkan nama kue...">

        <!-- Menampilkan Data Kue -->
        <div class="row" id="cakeContainer">
            <?php foreach ($cakes as $cake): ?>
                <div class="col-md-6 mb-4 cake-item" data-category-id="<?= htmlspecialchars($cake['category_id']); ?>">
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
                                <p><strong>Kategori:</strong> <?= htmlspecialchars($cake['category_name']); ?></p>
                                <p style="display: none;"><strong>Kategori Id:</strong> <?= htmlspecialchars($cake['category_id']); ?></p> <!-- ID Kategori Tersembunyi -->
                                <p><strong>Stok:</strong> <?= $cake['stock']; ?></p>

                                <!-- Bagian Tombol Aksi -->
                                <div class="mt-2">
                                    <a href="?act=edit-kue&i=<?= $cake['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                                    <a href="?act=tampil-kue&i=<?= $cake['id']; ?>" class="btn btn-info btn-sm">Detail</a>
                                    <a onclick="return confirm('Apakah anda yakin ingin menghapus Kue ini?')"
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
    // Fungsi untuk melakukan filtering berdasarkan kategori dan nama kue
    document.getElementById('categorySelect').addEventListener('change', function() {
        const selectedCategoryId = this.value; // Dapatkan ID kategori yang dipilih
        const searchValue = document.getElementById('searchInput').value.toLowerCase(); // Ambil nilai pencarian

        const cakes = document.querySelectorAll('.cake-item');

        cakes.forEach(function(cake) {
            const cakeName = cake.querySelector('.cake-name').textContent.toLowerCase();
            const cakeCategoryId = cake.getAttribute('data-category-id'); // Ambil kategori ID dari atribut data

            // Filter berdasarkan kategori dan nama kue
            const isCategoryMatch = selectedCategoryId === "" || cakeCategoryId === selectedCategoryId;
            const isNameMatch = cakeName.includes(searchValue);

            if (isCategoryMatch && isNameMatch) {
                cake.style.display = '';
            } else {
                cake.style.display = 'none';
            }
        });
    });

    // Fungsi untuk pencarian berdasarkan nama kue
    document.getElementById('searchInput').addEventListener('input', function() {
        const searchValue = this.value.toLowerCase();
        const selectedCategoryId = document.getElementById('categorySelect').value; // Ambil nilai kategori yang dipilih

        const cakes = document.querySelectorAll('.cake-item');

        cakes.forEach(function(cake) {
            const cakeName = cake.querySelector('.cake-name').textContent.toLowerCase();
            const cakeCategoryId = cake.getAttribute('data-category-id'); // Ambil kategori ID dari atribut data

            // Filter berdasarkan kategori dan nama kue
            const isCategoryMatch = selectedCategoryId === "" || cakeCategoryId === selectedCategoryId;
            const isNameMatch = cakeName.includes(searchValue);

            if (isCategoryMatch && isNameMatch) {
                cake.style.display = '';
            } else {
                cake.style.display = 'none';
            }
        });
    });
</script>

<?php include __DIR__ . '../../../../public/views/partials/footer.php' ?>