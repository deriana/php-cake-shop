<?php

namespace Controllers;

use Models\Model_user;

class Users
{
    private $user;

    public function __construct()
    {
        $this->user = new Model_user();
    }

    public function users()
    {
        $users = $this->user->lihat_user();
        require_once 'app/Views/user/index.php';
    }

    public function login()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $user = $this->user->getUserByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            echo "Sesi diset dengan ID: " . $_SESSION['id'];
            header("Location: /cake-shop/");
            exit();
        } else {
            echo "<div class='alert alert-danger'>Username atau password salah!</div>";
            include 'app/Views/login.php';
        }
    }

    public function editUser()
    {
        $id = $_GET['id'];
        $user = $this->user->getUserById($id); // Ambil data pengguna berdasarkan ID
        include 'app/Views/user/edit.php'; // Tampilkan form edit
    }

    public function updateUser()
    {
        $id = $_POST['id'];
        $username = $_POST['username'];
        $password = $_POST['password'] ?? null; 

        $this->user->userUpdate($id, $username, $password);

        header("Location: /cake-shop/?act=user-manage");
        exit();
    }

    public function createUser()
    {
        require_once 'app/Views/user/create.php'; // Memuat form untuk menambah pengguna
    }

    public function deleteUser()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $this->user->deleteData($id);
            header("Location: /cake-shop/?act=user-manage"); // Redirect setelah penghapusan


            exit();
        }
    }

    public function saveUser()
    {
        // Mengambil data dari input
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Menyimpan data pengguna ke model
        $this->user->simpanUser($username, $password);

        // Redirect atau tampilkan pesan sukses
        header("Location: /cake-shop/?act=user-manage"); // Redirect ke halaman manage pengguna
        exit();
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();

        header("Location: /cake-shop/?act=login");
        exit();
    }

    public function loginPage()
    {
        require_once 'app/Views/login.php';
    }
}
