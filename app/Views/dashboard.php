<?php include __DIR__ . '../../../public/views/partials/header.php' ?>

<style>
    .d-flex {
        display: flex;
        justify-content: space-around;  
        width: 100%; 
        flex-wrap: wrap;
    }

    .section {
        flex: 1; 
        min-width: 300px; 
        margin: 15px; 
    }

    #chart_div, #chart_bulan {
        width: 100%;
        height: 400px;
        margin-top: 20px;
    }

    @media (max-width: 768px) {
        .d-flex {
            flex-direction: column;
            justify-content: flex-start; 
        }

        .section {
            margin-bottom: 20px; 
        }
    }
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
    #chart_div, #chart_bulan {
        width: 100%;
        height: 400px;
        margin-top: 20px;
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
<!-- Konten Utama -->
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
    <!-- List -->
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
<!-- Chart -->
    <div class="d-flex">
        <section class="section">
            <h3>Grafik Penjualan per Tanggal</h3>
            <div id="chart_div"></div>
        </section>

        <section class="section">
            <h3>Grafik Penjualan per Bulan</h3>
            <div id="chart_bulan"></div>
        </section>
    </div>
</div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {
        packages: ['corechart', 'bar']
    });

    google.charts.setOnLoadCallback(drawCharts);

    function drawCharts() {
        var dataTanggal = google.visualization.arrayToDataTable([
            ['Tanggal', 'Total Penjualan'],
            <?php foreach ($penjualanTanggal as $item): ?>
                ['<?= $item['tanggal'] ?>', <?= $item['total'] ?>],
            <?php endforeach; ?>
        ]);

        var optionsTanggal = {
            title: 'Grafik Penjualan per Tanggal',
            titleTextStyle: {
                fontSize: 18,
                color: '#2c3e50',
                bold: true
            },
            hAxis: {
                title: 'Tanggal',
                titleTextStyle: {
                    color: '#3498db'
                },
                textStyle: {
                    fontSize: 12
                }
            },
            vAxis: {
                title: 'Total Penjualan (Rp)',
                titleTextStyle: {
                    color: '#3498db'
                },
                textStyle: {
                    fontSize: 12
                },
                gridlines: { color: '#ecf0f1' },
                baselineColor: '#ecf0f1'
            },
            backgroundColor: 'transparent',
            legend: { position: 'none' },
            curveType: 'function',
            colors: ['#3498db'],
            lineWidth: 3
        };

        var chartTanggal = new google.visualization.LineChart(document.getElementById('chart_div'));
        chartTanggal.draw(dataTanggal, optionsTanggal);

        var dataBulan = google.visualization.arrayToDataTable([
            ['Bulan-Tahun', 'Total Penjualan'],
            <?php foreach ($penjualanBulan as $item): ?>
                ['<?= $item['tahun'] . '-' . $item['bulan'] ?>', <?= $item['total'] ?>],
            <?php endforeach; ?>
        ]);

        var optionsBulan = {
            title: 'Grafik Penjualan per Bulan',
            titleTextStyle: {
                fontSize: 18,
                color: '#2c3e50',
                bold: true
            },
            hAxis: {
                title: 'Bulan-Tahun',
                titleTextStyle: {
                    color: '#3498db'
                },
                textStyle: {
                    fontSize: 12
                }
            },
            vAxis: {
                title: 'Total Penjualan (Rp)',
                titleTextStyle: {
                    color: '#3498db'
                },
                textStyle: {
                    fontSize: 12
                },
                gridlines: { color: '#ecf0f1' },
                baselineColor: '#ecf0f1'
            },
            backgroundColor: 'transparent',
            legend: { position: 'none' },
            colors: ['#2ecc71'],
            bar: { groupWidth: '75%' }
        };

        var chartBulan = new google.visualization.ColumnChart(document.getElementById('chart_bulan'));
        chartBulan.draw(dataBulan, optionsBulan);
    }
</script>

<?php include __DIR__ . '../../../public/views/partials/footer.php' ?>
