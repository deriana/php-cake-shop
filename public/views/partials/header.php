<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Cake Shop - Amanda</title>
    <link rel="icon" href="\cake-shop\assets\img\icon.png" type="image/png">

    <!-- General CSS Files -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <!-- Template CSS -->
    <link rel="stylesheet" href="\cake-shop\assets\css\style.css">
    <link rel="stylesheet" href="\cake-shop\assets\css\components.css">

</head>

<style>
    .fa-bars {
        color: black;
    }
</style>

<body>
    <div id="app">
        <div class="main-wrapper">
            <nav class="navbar navbar-expand-lg main-navbar">
                <form class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
                    </ul>
                </form>
                <ul class="navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user text-primary">
                            <img alt="image" src="\cake-shop\assets\img\avatar\avatar-1.png" class="rounded-circle mr-1">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="dropdown-divider"></div>
                            <a href="/cake-shop/?act=logout" class="dropdown-item has-icon text-primary">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
            <div class="main-sidebar">
                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand">
                        <a href="/cake-shop/">Amanda Cake</a>
                    </div>
                    <div class="sidebar-brand sidebar-brand-sm">
                        <a href="/cake-shop/">AC</a>
                    </div>
                    <ul class="sidebar-menu">
                        <li class="menu-header">Home</li>
                        <li class="nav-item">
                            <a href="/cake-shop/" class="nav-link"><i class="fas fa-home"></i><span>HomePage</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="/cake-shop/?act=dashboard" class="nav-link"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a>
                        </li>

                        <li class="menu-header">Cake</li>
                        <li class="nav-item">
                            <a href="/cake-shop/?act=tampil-kue" class="nav-link"><i class="fas fa-birthday-cake"></i> <span>Kue</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="/cake-shop/?act=input-kue" class="nav-link"><i class="fas fa-plus-circle"></i> <span>Input Kue</span></a>
                        </li>

                        <li class="menu-header">Transaksi</li>
                        <li class="nav-item">
                            <a href="/cake-shop/?act=sales-manage" class="nav-link"><i class="fas fa-shopping-cart"></i> <span>Lihat Transaksi</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="/cake-shop/?act=sales-create" class="nav-link"><i class="fas fa-credit-card"></i> <span>Transaksi</span></a>
                        </li>

                        <li class="menu-header">Laporan</li>
                        <li class="nav-item">
                            <a href="/cake-shop/?act=laporan" class="nav-link"><i class="fas fa-file-alt"></i> <span>Laporan</span></a>
                        </li>

                        <li class="menu-header">User</li>
                        <li class="nav-item">
                            <a href="/cake-shop/?act=user-manage" class="nav-link"><i class="fas fa-users-cog"></i> <span>Management Users</span></a>
                        </li>
                    </ul>
                </aside>
            </div>