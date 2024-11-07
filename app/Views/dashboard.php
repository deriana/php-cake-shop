<?php include __DIR__ . '../../../public/views/partials/header.php' ?>

<style>
    .info-box-container {
        display: flex;
        justify-content: space-between;
        gap: 20px;
        margin: 30px 0;
    }

    .info-box {
        flex: 1;
        background-color: #eaf1f8;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        text-align: center;
        color: #34495e;
    }

    .info-box h3 {
        font-size: 1.25rem;
        margin-bottom: 10px;
    }

    .info-box p {
        font-size: 1.5rem;
        font-weight: bold;
    }

    /* Table Styling */
    .section {
        margin-top: 40px;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .table th,
    .table td {
        padding: 12px;
        text-align: center;
        border-bottom: 1px solid #ddd;
    }

    .table th {
        background-color: #3498db;
        color: white;
    }

    .table tr:hover {
        background-color: #f1f1f1;
    }

    /* Grafik Styling */
    canvas {
        display: block;
        margin: 0 auto;
        width: 100%;
        max-width: 800px;
        height: 400px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .info-box-container {
            flex-direction: column;
        }

        .info-box {
            margin-bottom: 20px;
        }
    }
</style>

<div class="main-content">
    <h1>Dashboard User</h1>
    <div class="info-box-container">
        <div class="info-box">
            <h3>Total Kue</h3>
            <p><?= htmlspecialchars($jumlahKue) ?> Kue</p>
        </div>
        <div class="info-box">
            <h3>Total Keuntungan</h3>
            <p>Rp <?= number_format($totalKeuntungan, 3) ?></p>
        </div>
    </div>

    <section class="section">
        <h3>Kue Paling Sering Dibeli</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Nama Kue</th>
                    <th>Total Penjualan</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($kuePalingSering as $kue): ?>
                    <tr>
                        <td><?= htmlspecialchars($kue['name']) ?></td>
                        <td><?= htmlspecialchars($kue['total_penjualan']) ?> Penjualan</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>

    <div class="d-flex">
        <section class="section">
            <h3>Grafik Penjualan per Tanggal</h3>
            <canvas id="chartTanggal"></canvas>
        </section>

        <section class="section">
            <h3>Grafik Penjualan per Bulan</h3>
            <canvas id="chartBulan"></canvas>
        </section>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Grafik Penjualan per Tanggal
    var ctxTanggal = document.getElementById('chartTanggal').getContext('2d');
    var chartTanggal = new Chart(ctxTanggal, {
        type: 'line',
        data: {
            labels: <?php echo json_encode(array_column($penjualanTanggal, 'tanggal')); ?>,
            datasets: [{
                label: 'Total Penjualan',
                data: <?php echo json_encode(array_column($penjualanTanggal, 'total')); ?>,
                borderColor: 'rgb(75, 192, 192)',
                fill: false
            }]
        },
        options: {
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Tanggal'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Total Penjualan (Rp)'
                    }
                }
            }
        }
    });

    // Grafik Penjualan per Bulan
    var ctxBulan = document.getElementById('chartBulan').getContext('2d');
    var chartBulan = new Chart(ctxBulan, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode(array_map(function ($item) {
                        return $item['tahun'] . '-' . $item['bulan'];
                    }, $penjualanBulan)); ?>,
            datasets: [{
                label: 'Total Penjualan per Bulan',
                data: <?php echo json_encode(array_column($penjualanBulan, 'total')); ?>,
                backgroundColor: 'rgb(54, 162, 235)',
                borderColor: 'rgb(54, 162, 235)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Bulan-Tahun'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Total Penjualan (Rp)'
                    }
                }
            }
        }
    });
</script>

<?php include __DIR__ . '../../../public/views/partials/footer.php' ?>
