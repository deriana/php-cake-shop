<?php

namespace Controllers;
require_once __DIR__ . '/../Models/model_user.php';

use Models\Model_user;

class Users
{
    private $user; // Instance dari Model_user untuk berinteraksi dengan data pengguna

    // Konstruktor untuk menginisialisasi objek Model_user
    public function __construct()
    {
        $this->user = new Model_user(); // Menginisialisasi Model_user
    }

    // Menampilkan daftar pengguna
    public function users()
    {
        // Mengambil data semua pengguna
        $users = $this->user->lihat_user();
        // Memuat view untuk menampilkan daftar pengguna
        require_once 'app/Views/user/index.php';
    }

    // Menangani proses login pengguna
    public function login()
    {
        // Mengambil data username dan password dari form login
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Mencari pengguna berdasarkan username
        $user = $this->user->getUserByUsername($username);

        // Mengecek apakah pengguna ditemukan dan password valid
        if ($user && password_verify($password, $user['password'])) {
            // Menyimpan ID dan username pengguna dalam session
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            echo "Sesi diset dengan ID: " . $_SESSION['id'];
            // Redirect ke halaman utama setelah login
            header("Location: /cake-shop/");
            exit();
        } else {
            // Menampilkan pesan error jika login gagal
            echo "<div class='alert alert-danger'>Username atau password salah!</div>";
            // Memuat halaman login kembali
            include 'app/Views/login.php';
        }
    }

    // Menampilkan form untuk mengedit data pengguna
    public function editUser()
    {
        // Mengambil ID pengguna dari parameter query string
        $id = $_GET['id'];
        // Mengambil data pengguna berdasarkan ID
        $user = $this->user->getUserById($id);
        // Memuat form edit pengguna
        include 'app/Views/user/edit.php';
    }

    // Memperbarui data pengguna setelah edit
    public function updateUser()
    {
        // Mengambil data dari form edit
        $id = $_POST['id'];
        $username = $_POST['username'];
        $password = $_POST['password'] ?? null; // Password bisa null jika tidak diubah

        // Memperbarui data pengguna melalui model
        $this->user->userUpdate($id, $username, $password);

        // Redirect ke halaman manage pengguna setelah update
        header("Location: /cake-shop/?act=user-manage");
        exit();
    }

    // Menampilkan form untuk menambah pengguna baru
    public function createUser()
    {
        // Memuat form untuk membuat pengguna baru
        require_once 'app/Views/user/create.php';
    }

    // Menghapus data pengguna
    public function deleteUser()
    {
        // Mengecek apakah ada ID pengguna yang dikirimkan melalui query string
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            // Menghapus pengguna berdasarkan ID
            $this->user->deleteData($id);
            // Redirect ke halaman manage pengguna setelah penghapusan
            header("Location: /cake-shop/?act=user-manage");
            exit();
        }
    }

    // Menyimpan data pengguna baru setelah registrasi
    public function saveUser()
    {
        // Mengambil data dari form registrasi
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Menyimpan data pengguna baru ke model
        $this->user->simpanUser($username, $password);

        // Redirect ke halaman manage pengguna setelah menyimpan
        header("Location: /cake-shop/?act=user-manage");
        exit();
    }

    // Menghapus sesi dan melakukan logout pengguna
    public function logout()
    {
        session_start(); // Memulai sesi jika belum dimulai
        session_unset(); // Menghapus semua data session
        session_destroy(); // Menghancurkan sesi

        // Redirect ke halaman login setelah logout
        header("Location: /cake-shop/?act=login");
        exit();
    }

    // Menampilkan halaman login
    public function loginPage()
    {
        require_once 'app/Views/login.php'; // Memuat halaman login
    }
}
