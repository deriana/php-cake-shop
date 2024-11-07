<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';

use Controllers\Cakes;
use Controllers\Dashboard;
use Controllers\Users;
use Controllers\Sales;

$controller = new Cakes();
$user = new Users();
$sale = new Sales();
$dash = new Dashboard();

if (!isset($_GET['act'])) {
    $dash->index();
} else {
    if ($_GET['act'] !== 'login' && $_GET['act'] !== 'login-auth') {
        if (!isset($_SESSION['id'])) {
            header("Location: /mvc-example/?act=login");
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
            $controller->input();
            break;

        case 'simpan-kue':
            $controller->save();
            break;

        case 'tampil-kue':
            $controller->show_data();
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
            $controller->edit();
            break;

        case 'update-kue':
            $controller->update();
            break;

        case 'hapus-kue':
            $controller->delete();
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

        default:
            $dash->index();
            break;
    }
}
