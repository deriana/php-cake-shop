<?php

use Controllers\Cakes;
use Controllers\Dashboard;
use Controllers\Sales;
use Controllers\Users;

session_start();
require_once __DIR__ . '/core/Autoloader.php';
require_once __DIR__ . '/app/Controllers/Cakes.php';
require_once __DIR__ . '/app/Controllers/Users.php';
require_once __DIR__ . '/app/Controllers/Dashboard.php';
require_once __DIR__ . '/app/Controllers/Sales.php';
Autoloader::register();

$cakes = new Cakes();
$user = new Users();
$dash = new Dashboard();
$sale = new Sales();

if (!isset($_GET['act'])) {
    $dash->index();
} else {
    if ($_GET['act'] !== 'login' && $_GET['act'] !== 'login-auth') {
        if (!isset($_SESSION['id'])) {
            header("Location: /cake-shop/?act=login");
            exit();
        }
    }

    switch ($_GET['act']) {
        case 'login':
            $user->loginPage();
            break;
        case 'login-auth':
            $user->login();
            break;
        case 'logout':
            $user->logout();
            break;
        case 'dashboard':
            $dash->dashboardPage();
            break;
        case 'input-kue':
            $cakes->input();
            break;
        case 'simpan-kue':
            $cakes->save();
            break;
        case 'tampil-kue':
            $cakes->show_data();
            break;
        case 'user-manage':
            $user->users();
            break;
        case 'user-create':
            $user->createUser();
            break;
        case 'user-edit':
            $user->editUser();
            break;
        case 'update-user':
            $user->updateUser();
            break;
        case 'user-save':
            $user->saveUser();
            break;
        case 'user-delete':
            $user->deleteUser();
            break;
        case 'laporan':
            $sale->laporan();
            break;
        case 'laporan-sales':
            $sale->laporanSales();
            break;
        case 'laporan-cakes':
            $sale->laporanCakes();
            break;
        case 'edit-kue':
            $cakes->edit();
            break;
        case 'update-kue':
            $cakes->update();
            break;
        case 'hapus-kue':
            $cakes->delete();
            break;
        case 'sales-create':
            $sale->createSale();
            break;
        case 'sales-save':
            $sale->saveSale();
            break;
        case 'sales-manage':
            $sale->viewSales();
            break;
        case 'pdf-sales':
            $sale->handleExportPdf();
            break;
        case 'show-category':
            $cakes->showCategory();
            break;
        case 'save-category':
            $cakes->saveCategory();
            break;
        case 'delete-category':
            $cakes->hapusCategory();
            break;
        case 'update-category':
            $cakes->updateCategory();
            break;

        case 'hapus-sale':
            $sale->deleteSales();
            break;
            
        default:
            $dash->index();
            break;
    }
}
