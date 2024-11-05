<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cake Report</title>
    <link rel="stylesheet" href="/mvc-example/assets/css/bootstrap.css" />
</head>
<body>
<div class="container">
    <h3>Laporan Kue</h3>
    <?php if (isset($report['total_value'])): ?>
        <p>ID Kue: <?= htmlspecialchars($cake_id); ?></p>
        <p>Nilai Total Stok: Rp <?= number_format($report['total_value'], 2, ',', '.'); ?></p>
    <?php else: ?>
        <p>Data kue tidak ditemukan atau ID kue tidak valid.</p>
    <?php endif; ?>
    <a href="/mvc-example/?act=laporan" class="btn btn-secondary">Kembali ke Laporan</a>
</div>
</body>
</html>
