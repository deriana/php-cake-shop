<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';

use Controllers\Cakes;

$controller = new Cakes();

if (!isset($_GET['act'])) {
    $controller->index();
} else {
    if ($_GET['act'] !== 'login' && $_GET['act'] !== 'login-auth') {
        if (!isset($_SESSION['id'])) {
            header("Location: /mvc-example/?act=login");
            exit();
        }
    }

    switch ($_GET['act']) {
        case 'login':
            $controller->loginPage();
            break;
        case 'login-auth':
            $controller->login();
            break;
        case 'dashboard':
            $controller->dashboard();
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
            $controller->users();
            break;

        case 'user-create':
            $controller->createUser();
            break;

        case 'user-edit':
            $controller->editUser(); // Tampilkan form edit pengguna
            break;

        case 'user-update':
            $controller->updateUser();
            break;

        case 'user-save':
            $controller->saveUser(); // Simpan pengguna baru
            break;

        case 'user-delete':
            $controller->deleteUser();
            break;

        case 'laporan':
            $controller->laporan();
            break;

        case 'laporan-sales':
            $controller->laporanSales();
            break;
        case 'laporan-cakes':
            $controller->laporanCakes();
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
            $controller->createSale(); // Tampilkan form untuk penjualan baru
            break;
        case 'sales-save':
            $controller->saveSale(); // Simpan data penjualan
            break;
        case 'sales-manage':
            $controller->viewSales(); // Tampilkan daftar penjualan
            break;

        default:
            $controller->index();
            break;
    }
}
