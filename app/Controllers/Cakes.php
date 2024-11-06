<?php

namespace Controllers;

use Models\Model_cake;
use Models\Model_user;
use Models\Model_sales;

use PDO;

class Cakes
{
    private $cake;
    private $user;
    private $sales;

    public function __construct()
    {
        $this->cake = new Model_cake(); // Inisialisasi model kue
        $this->user = new Model_user(); // Inisialisasi model pengguna
        $this->sales = new Model_sales(); // Inisialisasi model sales
    }

    public function index()
    {
        $this->authGuard();
        require_once 'app/Views/index.php'; // Memuat tampilan utama
    }

    public function dashboard()
    {
        require_once 'app/Views/dashboard.php';
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

    public function login()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $user = $this->user->getUserByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            echo "Sesi diset dengan ID: " . $_SESSION['id'];
            header("Location: /cake-shop/?act=dashboard");
            exit();
        } else {
            echo "<div class='alert alert-danger'>Username atau password salah!</div>";
            include 'app/Views/login.php';
        }
    }

    public function authGuard()
    {
        if (!isset($_SESSION['id'])) {
            header("Location: /cake-shop/?act=login");
            exit();
        }
    }


    public function input()
    {
        require_once 'app/Views/cake/index.php'; // Memuat tampilan untuk input kue
    }

    public function users()
    {
        $users = $this->user->lihat_user(); // Mengambil data pengguna
        require_once 'app/Views/user/index.php'; // Memuat tampilan pengguna
    }

    public function editUser()
    {
        $id = $_GET['id'];
        $user = $this->user->getUserById($id); // Ambil data pengguna berdasarkan ID
        include 'app/Views/user/edit.php'; // Tampilkan form edit
    }

    public function updateUser()
    {
        // Ambil data dari form
        $id = $_POST['id'];
        $username = $_POST['username'];
        $password = $_POST['password'] ?? null; // Ambil password jika ada

        // Panggil model untuk memperbarui pengguna
        $this->user->updateUser($id, $username, $password);

        // Redirect setelah update
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

    public function laporan()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $report_type = $_POST['report_type'];

            if ($report_type === 'sales') {
                $start_date = $_POST['start_date'];
                $end_date = $_POST['end_date'];
                header("Location: /cake-shop/?act=laporan-sales&start_date={$start_date}&end_date={$end_date}");
                exit;
            } elseif ($report_type === 'cakes') {
                $cake_id = $_POST['cake_id'];
                header("Location: /cake-shop/?act=laporan-cakes&cake_id={$cake_id}");
                exit;
            }
        }

        $cakes = $this->cake->getAllCakes();
        require_once 'app/Views/report/index.php';
    }


    public function laporanSales()
    {
        // Ambil tanggal dari query string (GET) atau form (POST)
        $start_date = $_GET['start_date'] ?? $_POST['start_date'] ?? null;
        $end_date = $_GET['end_date'] ?? $_POST['end_date'] ?? null;
        $salesData = [];
        $report = null;

        if ($start_date && $end_date) {
            // Ambil data sales berdasarkan tanggal
            $salesData = $this->sales->getSalesByDateRange($start_date, $end_date);
        }

        require_once 'app/Views/report/sales_report.php';
    }


    public function laporanCakes()
    {
        // Ambil data dari model
        $report = $this->cake->getCakeSalesReport();

        // Tambahkan kolom total_penjualan ke setiap item
        foreach ($report as &$row) {
            $row['total_sales'] = $row['units_sold'] * $row['price'];
        }

        // Urutkan berdasarkan total_penjualan dari terbesar ke terkecil
        usort($report, function ($a, $b) {
            return $b['total_sales'] <=> $a['total_sales'];
        });

        require_once 'app/Views/report/cake_report.php';
    }



    public function show_data()
    {
        if (!isset($_GET['i'])) {
            $rs = $this->cake->lihatData();
            require_once('app/Views/cake/list.php'); // Memuat daftar kue
        } else {
            $rs = $this->cake->lihatDataDetail($_GET['i']);
            require_once('app/Views/cake/detail.php'); // Memuat detail kue
        }
    }

    public function save()
    {
        $name = $_POST['name'];
        $price = str_replace(['Rp ', ' '], '', $_POST['price']);
        $price = (float)$price;
        $stock = $_POST['stock'];
        $category = $_POST['category']; // Ambil kategori dari input

        $imgurl = $this->uploadImage($_FILES['imgurl']);

        if ($imgurl) {
            $this->cake->simpanData($name, $price, $stock, $imgurl, $category); // Kirimkan kategori ke model
        }

        $this->index(); // Redirect ke tampilan utama
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

    private function uploadImage($file)
    {
        $target_dir = "assets/cakeImg/";
        $target_file = $target_dir . basename($file["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Cek apakah gambar adalah gambar
        $check = getimagesize($file["tmp_name"]);
        if ($check === false) {
            echo "File bukan gambar.";
            $uploadOk = 0;
        }

        // Cek ukuran file
        if ($file["size"] > 500000) {
            echo "Maaf, ukuran file terlalu besar.";
            $uploadOk = 0;
        }

        // Cek format file
        if (!in_array($imageFileType, ["jpg", "png", "jpeg", "gif"])) {
            echo "Maaf, hanya file JPG, JPEG, PNG & GIF yang diizinkan.";
            $uploadOk = 0;
        }

        // Cek apakah $uploadOk diatur ke 0 oleh kesalahan
        if ($uploadOk == 0) {
            echo "Maaf, file tidak diupload.";
            return false;
        } else {
            if (move_uploaded_file($file["tmp_name"], $target_file)) {
                return $target_file; // Kembalikan URL gambar yang diupload
            } else {
                echo "Maaf, ada kesalahan saat mengupload file.";
                return false;
            }
        }
    }

    public function edit()
    {
        if (!isset($_GET['i'])) {
            header("Location: /cake-shop/?act=tampil-kue");
            exit;
        }

        $cake = $this->cake->lihatDataDetail($_GET['i']);
        require_once 'app/Views/cake/edit.php'; // Memuat tampilan edit kue
    }

    public function update()
    {
        $id = $_POST['id']; // Mendapatkan ID kue yang akan diupdate
        $name = $_POST['name']; // Mendapatkan nama kue
        $price = str_replace(['Rp ', ' '], '', $_POST['price']); // Menghapus format Rp dan spasi dari harga
        $stock = $_POST['stock']; // Mendapatkan stok
        $category = $_POST['category']; // Mengambil kategori dari input

        // Ambil data kue saat ini untuk mendapatkan imgurl yang sudah ada
        $currentCake = $this->cake->lihatDataDetail($id);
        $imgurl = $currentCake['imgurl']; // Simpan gambar yang sudah ada

        // Cek apakah ada file gambar baru
        if (!empty($_FILES['imgurl']['name'])) {
            // Jika ada gambar baru, upload gambar dan simpan URL-nya
            $imgurl = $this->uploadImage($_FILES['imgurl']);
        }

        // Lakukan update data dengan URL gambar dan kategori yang sesuai
        $this->cake->updateData($id, $name, $price, $stock, $imgurl, $category); // Pastikan kategori ditambahkan

        // Redirect atau tampilkan kembali daftar kue
        header("Location: /cake-shop/?act=tampil-kue");
    }


    public function delete()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $this->cake->deleteData($id);

            // Redirect atau tampilkan kembali daftar kue setelah penghapusan
            header("Location: /cake-shop/?act=tampil-kue");
            exit(); // Pastikan untuk menghentikan script setelah redirect
        }
    }

    public function createSale()
    {
        $cakes = $this->cake->lihatData(); // Ambil data kue untuk dropdown
        require_once 'app/Views/sales/create.php'; // Memuat form untuk menambah penjualan
    }

    public function saveSale()
    {
        $cake_id = $_POST['cake_id'];
        $quantity = intval($_POST['quantity']);
        $discount_percentage = intval($_POST['discount']); // Diskon dalam persen
        $payment_method = $_POST['payment_method'];
        $pembeli = $_POST['pembeli']; // Ambil data pembeli dari input

        // Validasi input (sama seperti sebelumnya)
        if ($quantity <= 0) {
            echo "Jumlah tidak boleh nol atau negatif.";
            return;
        }
        if ($discount_percentage < 0 || $discount_percentage > 100) {
            echo "Diskon harus antara 0 dan 100.";
            return;
        }

        // Ambil harga dan stok kue berdasarkan cake_id
        $stmt = $this->sales->getCakeById($cake_id);
        if ($stmt) {
            $cake = $stmt->fetch(\PDO::FETCH_ASSOC);

            // Cek apakah stok cukup
            if ($cake['stock'] < $quantity) {
                echo "Stok tidak mencukupi.";
                return;
            }

            // Hitung total harga
            $price_per_unit = $cake['price'];
            $total_price = ($quantity * $price_per_unit);
            $discount_value = ($total_price * $discount_percentage) / 100;
            $total_price -= $discount_value;

            // Pastikan total_price tidak negatif
            if ($total_price < 0) {
                $total_price = 0;
            }

            // Simpan data penjualan
            if ($this->sales->simpanData($cake_id, $quantity, $discount_value, $total_price, $payment_method, $pembeli)) {
                // Kurangi stok kue
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


    public function generateReport()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $report_type = $_POST['report_type'];
            $report = [];

            if ($report_type === 'sales') {
                $start_date = $_POST['start_date'];
                $end_date = $_POST['end_date'];
                $report = $this->sales->getTotalSales($start_date, $end_date);
            } elseif ($report_type === 'cakes') {
                $report = $this->cake->getTotalCakeStockValue();
            }

            require_once 'app/Views/report.php'; // Ganti dengan path yang sesuai untuk view
        }
    }

    public function viewSales()
    {
        $sales = $this->sales->lihatSales(); // Ambil semua data penjualan
        require_once 'app/Views/sales/index.php'; // Tampilkan semua sales
    }

    public function getCakes()
    {
        $cakeModel = new Model_cake();
        return $cakeModel->lihatData();
    }
}
