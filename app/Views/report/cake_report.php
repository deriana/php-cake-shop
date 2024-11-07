<?php 
include __DIR__ . '../../../../public/views/partials/header.php' ?>

<div class="main-content">
    <div class="container mt-5">
        <h3>Laporan Kue dan Penjualan</h3>

        <?php if (isset($report) && count($report) > 0): ?>
            <!-- Dropdown untuk memilih kategori -->
            <select id="categorySelect" onchange="filterTable()" class="form-control mb-4">
                <option value="">Pilih Kategori</option>
                <option value="Kue Balok">Kue Balok</option>
                <option value="Kue Bolu">Kue Bolu</option>
                <option value="Kue Lapis Talas">Kue Lapis Talas</option>
                <option value="Brownies">Brownies</option>
            </select>

            <!-- Input pencarian -->
            <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Cari berdasarkan nama kue..." class="form-control mb-4">

            <!-- Tabel Laporan Kue -->
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="cakeTable">
                    <thead>
                        <tr>
                            <th>Nama Kue</th>
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
                                <td><?= htmlspecialchars($row['category']); ?></td>
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
    function filterTable() {
        // Ambil nilai dari dropdown kategori
        const select = document.getElementById('categorySelect');
        const filterCategory = select.value; // Dapatkan nilai kategori yang dipilih
        const input = document.getElementById('searchInput');
        const filterName = input.value.toLowerCase(); // Dapatkan nilai pencarian nama kue
        const table = document.getElementById('cakeTable');
        const rows = table.getElementsByTagName('tr');

        // Loop melalui semua baris tabel dan sembunyikan baris yang tidak sesuai
        for (let i = 1; i < rows.length; i++) { // Mulai dari 1 untuk mengabaikan header
            const cells = rows[i].getElementsByTagName('td');
            const category = cells[1].innerText; // Ambil kategori dari kolom kedua
            const name = cells[0].innerText.toLowerCase(); // Ambil nama kue dari kolom pertama

            // Tampilkan atau sembunyikan baris berdasarkan kategori dan nama kue yang dipilih
            const showRow = (filterCategory === "" || category === filterCategory) && 
                            (filterName === "" || name.indexOf(filterName) > -1);

            rows[i].style.display = showRow ? '' : 'none'; // Tampilkan jika cocok
        }
    }
</script>

<?php include __DIR__ . '../../../../public/views/partials/footer.php' ?>
