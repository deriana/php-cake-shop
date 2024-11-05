<?php
require_once __DIR__ . '/vendor/autoload.php';

use Controllers\Cakes;

$controller = new Cakes();

if (!isset($_GET['act'])) {
    $controller->index();
} else {
    switch ($_GET['act']) {
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

        case 'laporan':
            $controller->laporan();
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

        default:
            $controller->index();
            break;
    }
}
