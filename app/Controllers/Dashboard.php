<?php

namespace Controllers;

use Models\Model_cake;
use Models\Model_sales;

class Dashboard
{
    private $dashCake;
    private $dashSale;

    public function __construct()
    {
        $this->dashCake = new Model_cake();
        $this->dashSale = new Model_sales();
    }

    public function dashboardPage()
    {
        $sales = $this->dashSale->lihatSales();
        $cakes = $this->dashCake->lihatData();

        $totalKeuntungan = $this->dashSale->totalKeuntungan();
        $jumlahKue = $this->dashCake->jumlahKue();
        $kuePalingSering = $this->dashSale->kuePalingSering();
        $penjualanTanggal = $this->dashSale->penjualanPerTanggal();
        $penjualanBulan = $this->dashSale->penjualanPerBulan();

        require_once "app/Views/dashboard.php";
    }
    
    public function index()
    {
        $this->authGuard();
        $cakes = $this->dashCake->lihatDataRandom(6);
        require_once 'app/Views/index.php';
    }

    public function authGuard()
    {
        if (!isset($_SESSION['id'])) {
            header("Location: /cake-shop/?act=login");
            exit();
        }
    }
}
