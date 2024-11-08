<?php 
include __DIR__ . '../../../../public/views/partials/header.php' ?>

<!-- Konten Utama -->
<div class="main-content">
    <div class="container mt-5">
        <h3>Laporan Kue dan Penjualan</h3>
        <!-- Input pilih laporan -->
        <form action="/cake-shop/?act=laporan" method="POST">
            <div class="form-group">
                <label for="report_type">Pilih Jenis Laporan</label>
                <select name="report_type" id="report_type" class="form-control" required>
                    <option value="">Pilih Laporan</option>
                    <option value="sales">Laporan Penjualan</option>
                    <option value="cakes">Laporan Kue</option>
                </select>
            </div>
    
            <div id="sales_date_range" style="display: none;">
                <div class="form-group">
                    <label for="start_date">Tanggal Mulai</label>
                    <input type="date" name="start_date" class="form-control">
                </div>
                <div class="form-group">
                    <label for="end_date">Tanggal Selesai</label>
                    <input type="date" name="end_date" class="form-control">
                </div>
            </div>
    
            <button type="submit" class="btn btn-primary">Lihat Laporan</button>
        </form>
    </div>
</div>

<script>
    document.getElementById('report_type').addEventListener('change', function() {
        var salesDateRange = document.getElementById('sales_date_range');
        if (this.value === 'sales') {
            salesDateRange.style.display = 'block';
        } else {
            salesDateRange.style.display = 'none';
        }
    });
</script>

<?php include __DIR__ . '../../../../public/views/partials/footer.php' ?>
