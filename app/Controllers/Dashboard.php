<?php

namespace Controllers;
require_once __DIR__ . '/../Models/model_cake.php';
require_once __DIR__ . '/../Models/model_sales.php';


use Models\Model_cake;
use Models\Model_sales;

class Dashboard
{
    private $dashCake; // Menyimpan instance Model_cake untuk interaksi dengan data kue
    private $dashSale; // Menyimpan instance Model_sales untuk interaksi dengan data penjualan

    // Konstruktor untuk menginisialisasi objek Model_cake dan Model_sales
    public function __construct()
    {
        $this->dashCake = new Model_cake(); // Menginisialisasi Model_cake
        $this->dashSale = new Model_sales(); // Menginisialisasi Model_sales
    }

    // Menampilkan halaman dashboard dengan data penjualan dan kue
    public function dashboardPage()
    {
        // Mendapatkan data penjualan dan kue
        $sales = $this->dashSale->lihatSales(); // Mengambil seluruh data penjualan
        $cakes = $this->dashCake->lihatData(); // Mengambil seluruh data kue

        // Menghitung total keuntungan, jumlah kue, kue paling sering terjual, dan penjualan berdasarkan tanggal/bulan
        $totalKeuntungan = $this->dashSale->totalKeuntungan(); // Menghitung total keuntungan dari penjualan
        $jumlahKue = $this->dashCake->jumlahKue(); // Menghitung jumlah total kue yang ada
        $kuePalingSering = $this->dashSale->kuePalingSering(); // Mendapatkan kue yang paling sering terjual
        $penjualanTanggal = $this->dashSale->penjualanPerTanggal(); // Mendapatkan data penjualan per tanggal
        $penjualanBulan = $this->dashSale->penjualanPerBulan(); // Mendapatkan data penjualan per bulan

        // Memuat halaman dashboard dan mengirimkan data untuk ditampilkan
        require_once "app/Views/dashboard.php";
    }
    
    // Menampilkan halaman utama index
    public function index()
    {
        // Melakukan pengecekan autentikasi untuk memastikan user sudah login
        $this->authGuard();
        
        // Mengambil data kue secara acak (6 kue)
        $cakes = $this->dashCake->lihatDataRandom(6);
        
        // Memuat halaman index dan mengirimkan data kue untuk ditampilkan
        require_once 'app/Views/index.php';
    }

    // Melakukan pengecekan autentikasi, memastikan pengguna sudah login
    public function authGuard()
    {
        // Jika tidak ada session yang menyimpan ID pengguna (artinya pengguna belum login), redirect ke halaman login
        if (!isset($_SESSION['id'])) {
            header("Location: /cake-shop/?act=login"); // Redirect ke halaman login
            exit(); // Menghentikan eksekusi lebih lanjut
        }
    }
}
