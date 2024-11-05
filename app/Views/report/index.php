<html>
<head>
    <title>Laporan Kue dan Penjualan</title>
    <link rel="stylesheet" href="/mvc-example/assets/css/bootstrap.css" />
</head>
<body>
<div class="container">
    <h3>Laporan Kue dan Penjualan</h3>

    <form action="/mvc-example/?act=laporan" method="POST">
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

        <div id="cake_selection" style="display: none;">
            <div class="form-group">
                <label for="cake_id">Pilih Kue</label>
                <select name="cake_id" id="cake_id" class="form-control">
                    <option value="">Pilih Kue</option>
                    <?php foreach ($cakes as $cake): ?>
                        <option value="<?= $cake['id']; ?>"><?= htmlspecialchars($cake['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Lihat Laporan</button>
    </form>
</div>

<script>
    document.getElementById('report_type').addEventListener('change', function() {
        var salesDateRange = document.getElementById('sales_date_range');
        var cakeSelection = document.getElementById('cake_selection');
        if (this.value === 'sales') {
            salesDateRange.style.display = 'block';
            cakeSelection.style.display = 'none';
        } else if (this.value === 'cakes') {
            salesDateRange.style.display = 'none';
            cakeSelection.style.display = 'block';
        } else {
            salesDateRange.style.display = 'none';
            cakeSelection.style.display = 'none';
        }
    });
</script>
</body>
</html>
