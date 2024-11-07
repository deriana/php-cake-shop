<?php

namespace Controllers;

use Models\Model_cake;
use Models\Model_sales;

use PDO;

class Sales
{
    private $sales;
    private $cake;

    public function __construct()
    {
        $this->sales = new Model_sales();
        $this->cake = new Model_cake();
    }

    public function laporan()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $report_type = $_POST['report_type'];

            if ($report_type === 'sales') {
                $start_date = $_POST['start_date'];
                $end_date = $_POST['end_date'];
                header("Location: /cake-shop/?act=laporan-sales&start_date={$start_date}&end_date={$end_date}");
                exit;
            } elseif ($report_type === 'cakes') {
                $cake_id = $_POST['cake_id'];
                header("Location: /cake-shop/?act=laporan-cakes&cake_id={$cake_id}");
                exit;
            }
        }

        $cakes = $this->cake->getAllCakes();
        require_once 'app/Views/report/index.php';
    }

    public function laporanSales()
    {
        // Ambil tanggal dari query string (GET) atau form (POST)
        $start_date = $_GET['start_date'] ?? $_POST['start_date'] ?? null;
        $end_date = $_GET['end_date'] ?? $_POST['end_date'] ?? null;
        $salesData = [];
        $report = null;

        if ($start_date && $end_date) {
            // Ambil data sales berdasarkan tanggal
            $salesData = $this->sales->getSalesByDateRange($start_date, $end_date);
        }

        require_once 'app/Views/report/sales_report.php';
    }


    public function laporanCakes()
    {
        // Ambil data dari model
        $report = $this->cake->getCakeSalesReport();

        // Tambahkan kolom total_penjualan ke setiap item
        foreach ($report as &$row) {
            $row['total_sales'] = $row['units_sold'] * $row['price'];
        }

        // Urutkan berdasarkan total_penjualan dari terbesar ke terkecil
        usort($report, function ($a, $b) {
            return $b['total_sales'] <=> $a['total_sales'];
        });

        require_once 'app/Views/report/cake_report.php';
    }

    public function createSale()
    {
        $cakes = $this->cake->lihatData(); // Ambil data kue untuk dropdown
        require_once 'app/Views/sales/create.php'; // Memuat form untuk menambah penjualan
    }

    public function saveSale()
    {
        $cake_id = $_POST['cake_id'];
        $quantity = intval($_POST['quantity']);
        $discount_percentage = intval($_POST['discount']); // Diskon dalam persen
        $payment_method = $_POST['payment_method'];
        $pembeli = $_POST['pembeli']; // Ambil data pembeli dari input

        // Validasi input (sama seperti sebelumnya)
        if ($quantity <= 0) {
            echo "Jumlah tidak boleh nol atau negatif.";
            return;
        }
        if ($discount_percentage < 0 || $discount_percentage > 100) {
            echo "Diskon harus antara 0 dan 100.";
            return;
        }

        // Ambil harga dan stok kue berdasarkan cake_id
        $stmt = $this->sales->getCakeById($cake_id);
        if ($stmt) {
            $cake = $stmt->fetch(\PDO::FETCH_ASSOC);

            // Cek apakah stok cukup
            if ($cake['stock'] < $quantity) {
                echo "Stok tidak mencukupi.";
                return;
            }

            // Hitung total harga
            $price_per_unit = $cake['price'];
            $total_price = ($quantity * $price_per_unit);
            $discount_value = ($total_price * $discount_percentage) / 100;
            $total_price -= $discount_value;

            // Pastikan total_price tidak negatif
            if ($total_price < 0) {
                $total_price = 0;
            }

            // Simpan data penjualan
            if ($this->sales->simpanData($cake_id, $quantity, $discount_value, $total_price, $payment_method, $pembeli)) {
                // Kurangi stok kue
                $new_stock = $cake['stock'] - $quantity;
                if ($this->sales->updateStock($cake_id, $new_stock)) { // Update stok kue
                    header("Location: /cake-shop/?act=sales-manage"); // Redirect setelah penyimpanan
                } else {
                    echo "Error updating stock.";
                }
            } else {
                echo "Error saving sale.";
            }
        } else {
            echo "Kue tidak ditemukan.";
        }
    }

    public function generateReport()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $report_type = $_POST['report_type'];
            $report = [];

            if ($report_type === 'sales') {
                $start_date = $_POST['start_date'];
                $end_date = $_POST['end_date'];
                $report = $this->sales->getTotalSales($start_date, $end_date);
            } elseif ($report_type === 'cakes') {
                $report = $this->cake->getTotalCakeStockValue();
            }

            require_once 'app/Views/report.php'; // Ganti dengan path yang sesuai untuk view
        }
    }

    public function viewSales()
    {
        $sales = $this->sales->lihatSales(); // Ambil semua data penjualan
        require_once 'app/Views/sales/index.php'; // Tampilkan semua sales
    }
}
