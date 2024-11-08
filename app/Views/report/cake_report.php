<?php
include __DIR__ . '../../../../public/views/partials/header.php' ?>

<div class="main-content">
    <div class="container mt-5">
        <h3>Laporan Kue dan Penjualan</h3>

        <?php if (isset($report) && count($report) > 0): ?>
            <div class="form-group">
                <select id="categorySelect" class="form-control mb-4">
                    <option value="">Pilih Kategori</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= htmlspecialchars($category['id']); ?>">
                            <?= htmlspecialchars($category['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Input pencarian -->
            <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Cari berdasarkan nama kue..." class="form-control mb-4">

            <!-- Tabel Laporan Kue -->
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="cakeTable">
                    <thead>
                        <tr>
                            <th>Nama Kue</th>
                            <th style="display: none;">Id Kategori</th> <!-- Kolom ID Kategori yang disembunyikan -->
                            <th>Kategori</th>
                            <th>Unit Terjual</th>
                            <th>Harga</th>
                            <th>Penjualan (Unit Terjual x Harga)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($report as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['name']); ?></td>
                                <td style="display: none;"><?= htmlspecialchars($row['category_id']); ?></td> <!-- Tampilkan ID Kategori yang disembunyikan -->
                                <td><?= htmlspecialchars($row['category_name']); ?></td>
                                <td><?= htmlspecialchars($row['units_sold']); ?></td>
                                <td>Rp <?= number_format($row['price'], 3, ',', '.'); ?></td>
                                <td>Rp <?= number_format($row['total_sales'], 3, ',', '.'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p>Tidak ada data penjualan yang tersedia.</p>
        <?php endif; ?>

        <a href="/cake-shop/?act=laporan" class="btn btn-primary mt-4">Kembali ke Laporan</a>
    </div>
</div>

<script>
    // Fungsi untuk filter berdasarkan kategori ID dan nama kue
    function filterTable() {
        const select = document.getElementById('categorySelect');
        const filterCategoryId = select.value; // Ambil nilai kategori ID yang dipilih
        const input = document.getElementById('searchInput');
        const filterName = input.value.toLowerCase(); // Ambil nilai pencarian nama kue
        const table = document.getElementById('cakeTable');
        const rows = table.getElementsByTagName('tr');

        // Loop melalui semua baris tabel dan sembunyikan baris yang tidak sesuai
        for (let i = 1; i < rows.length; i++) { // Mulai dari 1 untuk mengabaikan header
            const cells = rows[i].getElementsByTagName('td');
            const categoryId = cells[1].innerText; // Ambil category_id dari kolom kedua yang disembunyikan
            const categoryName = cells[2].innerText.toLowerCase(); // Ambil nama kategori dari kolom yang ditampilkan
            const name = cells[0].innerText.toLowerCase(); // Ambil nama kue dari kolom pertama

            // Tampilkan atau sembunyikan baris berdasarkan kategori ID dan nama kue yang dipilih
            const showRow = (filterCategoryId === "" || categoryId === filterCategoryId) &&
                            (filterName === "" || name.indexOf(filterName) > -1);

            rows[i].style.display = showRow ? '' : 'none'; // Tampilkan jika cocok
        }
    }

    // Event listener untuk dropdown kategori, agar filter langsung terupdate saat kategori berubah
    document.getElementById('categorySelect').addEventListener('change', filterTable);
    document.getElementById('searchInput').addEventListener('keyup', filterTable);
</script>

<?php include __DIR__ . '../../../../public/views/partials/footer.php' ?>
