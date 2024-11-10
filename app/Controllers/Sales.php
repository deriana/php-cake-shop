<?php


namespace Controllers;

use Models\Model_cake;
use Models\Model_sales;

require_once __DIR__ . '/../../vendor/autoload.php';

use TCPDF;

class Sales
{
    private $sales; // Menyimpan instance Model_sales untuk interaksi dengan data penjualan
    private $cake; // Menyimpan instance Model_cake untuk interaksi dengan data kue

    // Konstruktor untuk menginisialisasi objek Model_sales dan Model_cake
    public function __construct()
    {
        $this->sales = new Model_sales(); // Menginisialisasi Model_sales
        $this->cake = new Model_cake(); // Menginisialisasi Model_cake
    }

    // Menampilkan halaman laporan dan memproses form input untuk memilih jenis laporan (penjualan atau kue)
    public function laporan()
    {
        // Mengecek apakah permintaan adalah POST (form submit)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $report_type = $_POST['report_type']; // Jenis laporan yang dipilih (sales atau cakes)

            // Menangani laporan penjualan berdasarkan tanggal
            if ($report_type === 'sales') {
                $start_date = $_POST['start_date']; // Tanggal mulai
                $end_date = $_POST['end_date']; // Tanggal akhir
                // Redirect ke halaman laporan penjualan dengan parameter tanggal
                header("Location: /cake-shop/?act=laporan-sales&start_date={$start_date}&end_date={$end_date}");
                exit;
            }
            // Menangani laporan berdasarkan kue tertentu
            elseif ($report_type === 'cakes') {
                $cake_id = $_POST['cake_id']; // ID kue untuk laporan
                // Redirect ke halaman laporan kue dengan parameter cake_id
                header("Location: /cake-shop/?act=laporan-cakes&cake_id={$cake_id}");
                exit;
            }
        }

        // Mendapatkan semua data kue untuk ditampilkan pada form laporan
        $cakes = $this->cake->getAllCakes();
        require_once 'app/Views/report/index.php'; // Memuat halaman laporan
    }

    // Menampilkan laporan penjualan berdasarkan rentang tanggal
    public function laporanSales()
    {
        // Mendapatkan tanggal dari parameter query string atau form (POST)
        $start_date = $_GET['start_date'] ?? $_POST['start_date'] ?? null;
        $end_date = $_GET['end_date'] ?? $_POST['end_date'] ?? null;
        $salesData = []; // Menyimpan data penjualan yang akan ditampilkan
        $report = null; // Menyimpan data laporan

        // Jika rentang tanggal ada, ambil data penjualan dalam rentang tanggal tersebut
        if ($start_date && $end_date) {
            $salesData = $this->sales->getSalesByDateRange($start_date, $end_date); // Ambil data sales berdasarkan tanggal
        }

        require_once 'app/Views/report/sales_report.php'; // Memuat halaman laporan penjualan
    }

    public function handleExportPdf()
    {
        $start_date = $_GET['start_date'] ?? $_POST['start_date'] ?? null;
        $end_date = $_GET['end_date'] ?? $_POST['end_date'] ?? null;

        if ($start_date && $end_date) {
            $salesData = $this->sales->getSalesByDateRange($start_date, $end_date);

            $this->exportToPdf($salesData, $start_date, $end_date);
        } else {
            echo "Tanggal tidak valid!";
        }
    }

    function exportToPDF($salesData, $start_date, $end_date)
    {
        // Cek apakah class TCPDF sudah terinstal
        if (!class_exists('TCPDF')) {
            die('Library TCPDF belum ditemukan. Pastikan sudah terinstal dengan benar.');
        }

        // Inisiasi TCPDF
        $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Amanda Cake');
        $pdf->SetTitle('Laporan Penjualan');
        $pdf->SetSubject('Sales Report');

        // Tambahkan halaman
        $pdf->AddPage();

        // Header
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 10, "Laporan Penjualan: {$start_date} - {$end_date}", 0, 1, 'C');

        // Header Kolom
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(10, 10, 'No', 1, 0, 'C');
        $pdf->Cell(30, 10, 'Tanggal', 1, 0, 'C');
        $pdf->Cell(40, 10, 'Pembeli', 1, 0, 'C');
        $pdf->Cell(50, 10, 'Cake Name', 1, 0, 'C');
        $pdf->Cell(20, 10, 'Quantity', 1, 0, 'C');
        $pdf->Cell(20, 10, 'Discount', 1, 0, 'C');
        $pdf->Cell(40, 10, 'Total Price', 1, 1, 'C');

        // Baris Data
        $pdf->SetFont('helvetica', '', 10);
        $no = 1;

        foreach ($salesData as $sale) {
            $pdf->Cell(10, 10, $no++, 1, 0, 'C');
            $pdf->Cell(30, 10, date('Y-m-d', strtotime($sale['created_at'])), 1, 0, 'C');
            $pdf->Cell(40, 10, $sale['pembeli'], 1, 0, 'L');
            $pdf->Cell(50, 10, $sale['cake_name'], 1, 0, 'L');
            $pdf->Cell(20, 10, $sale['quantity'], 1, 0, 'C');
            $pdf->Cell(20, 10, number_format($sale['discount'], 3, ',', '.'), 1, 0, 'R');
            $pdf->Cell(40, 10, 'Rp ' . number_format($sale['total_price'], 3, ',', '.'), 1, 1, 'R');
        }

        // Menyimpan dan mengeluarkan PDF
        $filename = "Laporan_Sales_{$start_date}_to_{$end_date}.pdf";
        $pdf->Output($filename, 'I'); // 'I' untuk inline (ditampilkan di browser)
    }


    // Menampilkan laporan penjualan per kue
    public function laporanCakes()
    {
        // Mendapatkan data laporan penjualan per kue
        $report = $this->cake->getCakeSalesReport();
        // Mendapatkan semua kategori kue
        $categories = $this->cake->getAllCategories();

        // Menghitung total penjualan untuk setiap kue
        foreach ($report as &$row) {
            $row['total_sales'] = $row['units_sold'] * $row['price']; // Total penjualan = jumlah terjual * harga per unit
        }

        // Mengurutkan laporan berdasarkan total penjualan terbanyak
        usort($report, function ($a, $b) {
            return $b['total_sales'] <=> $a['total_sales'];
        });

        require_once 'app/Views/report/cake_report.php'; // Memuat halaman laporan per kue
    }

    // Menampilkan halaman untuk menambah penjualan baru
    public function createSale()
    {
        // Mendapatkan data kue untuk dropdown pilihan pada form penjualan
        $cakes = $this->cake->lihatData();
        require_once 'app/Views/sales/create.php'; // Memuat form untuk membuat penjualan baru
    }

    // Menyimpan data penjualan setelah form submit
    public function saveSale()
    {
        // Mengambil data dari form penjualan
        $cake_id = $_POST['cake_id']; // ID kue yang dibeli
        $quantity = intval($_POST['quantity']); // Jumlah kue yang dibeli
        $discount_percentage = intval($_POST['discount']); // Persentase diskon
        $payment_method = $_POST['payment_method']; // Metode pembayaran
        $pembeli = $_POST['pembeli']; // Nama pembeli

        // Validasi input
        if ($quantity <= 0) {
            echo "Jumlah tidak boleh nol atau negatif.";
            return;
        }
        if ($discount_percentage < 0 || $discount_percentage > 100) {
            echo "Diskon harus antara 0 dan 100.";
            return;
        }

        // Ambil data kue berdasarkan cake_id
        $stmt = $this->sales->getCakeById($cake_id);
        if ($stmt) {
            $cake = $stmt->fetch(\PDO::FETCH_ASSOC); // Menyimpan data kue dalam array

            // Mengecek apakah stok cukup
            if ($cake['stock'] < $quantity) {
                echo "Stok tidak mencukupi.";
                return;
            }

            // Menghitung harga total setelah diskon
            $price_per_unit = $cake['price'];
            $total_price = ($quantity * $price_per_unit);
            $discount_value = ($total_price * $discount_percentage) / 100;
            $total_price -= $discount_value;

            // Pastikan total harga tidak negatif
            if ($total_price < 0) {
                $total_price = 0;
            }

            // Menyimpan data penjualan
            if ($this->sales->simpanData($cake_id, $quantity, $discount_value, $total_price, $payment_method, $pembeli)) {
                // Mengurangi stok kue
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

    // Menghasilkan laporan berdasarkan jenis laporan yang dipilih
    public function generateReport()
    {
        // Mengecek apakah permintaan adalah POST (form submit)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $report_type = $_POST['report_type']; // Jenis laporan yang dipilih (sales atau cakes)
            $report = []; // Menyimpan data laporan

            // Menangani laporan penjualan berdasarkan tanggal
            if ($report_type === 'sales') {
                $start_date = $_POST['start_date']; // Tanggal mulai
                $end_date = $_POST['end_date']; // Tanggal akhir
                // Mengambil total penjualan dalam rentang tanggal
                $report = $this->sales->getTotalSales($start_date, $end_date);
            }
            // Menangani laporan nilai stok kue
            elseif ($report_type === 'cakes') {
                $report = $this->cake->getTotalCakeStockValue(); // Mengambil total nilai stok kue
            }

            require_once 'app/Views/report.php'; // Memuat halaman laporan
        }
    }

    // Menampilkan semua data penjualan
    public function viewSales()
    {
        // Mengambil semua data penjualan
        $sales = $this->sales->lihatSales();
        require_once 'app/Views/sales/index.php'; // Memuat halaman yang menampilkan daftar penjualan
    }

    public function deleteSales()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $this->sales->deleteSales($id);

            header("Location: /cake-shop/?act=sales-manage");
            exit();
        }
    }
}
