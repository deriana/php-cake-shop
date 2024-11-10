<?php

namespace Controllers;
require_once __DIR__ . '/../Models/model_cake.php';

use Models\Model_cake;

class Cakes
{
    private $cake;

    // Konstruktor untuk menginisialisasi objek Model_cake
    public function __construct()
    {
        $this->cake = new Model_cake();
    }

    // Menampilkan tampilan input dengan daftar kategori kue
    public function input()
    {
        $categories = $this->cake->getAllCategories(); // Mendapatkan semua kategori kue
        require_once 'app/Views/cake/index.php'; // Menampilkan form input kue
    }

    // Menampilkan data kue, baik dalam bentuk daftar atau detail
    public function show_data()
    {
        $categories = $this->cake->getAllCategories(); // Mendapatkan semua kategori kue
        if (!isset($_GET['i'])) {
            $cakes = $this->cake->lihatData(); // Mendapatkan semua data kue
            require_once('app/Views/cake/list.php'); // Menampilkan daftar kue
        } else {
            $cakes = $this->cake->lihatDataDetail($_GET['i']); // Mendapatkan data kue berdasarkan ID
            require_once('app/Views/cake/detail.php'); // Menampilkan detail kue
        }
    }

    // Menyimpan data kue baru
    public function save()
    {
        $name = $_POST['name']; // Mendapatkan nama kue
        $price = str_replace(['Rp ', ' '], '', $_POST['price']); // Menghapus format harga
        $price = (float)$price; // Mengubah harga menjadi tipe data float
        $stock = $_POST['stock']; // Mendapatkan jumlah stok
        $category_id = $_POST['category_id']; // Mendapatkan kategori kue

        // Menyimpan gambar dan mengambil URL-nya
        $imgurl = $this->uploadImage($_FILES['imgurl']);

        if ($imgurl) {
            // Menyimpan data kue ke database
            $this->cake->simpanData($name, $price, $stock, $imgurl, $category_id);
        }

        // Menampilkan kembali data kue setelah disimpan
        $this->show_data();
    }

    // Fungsi untuk mengupload gambar kue
    private function uploadImage($file)
    {
        $target_dir = "assets/cakeImg/"; // Direktori tujuan gambar
        $target_file = $target_dir . basename($file["name"]); // Nama file yang akan disimpan
        $uploadOk = 1; // Variabel untuk memeriksa apakah upload berhasil
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); // Menentukan ekstensi gambar

        // Cek apakah file adalah gambar
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

        // Cek apakah uploadOk diatur ke 0
        if ($uploadOk == 0) {
            echo "Maaf, file tidak diupload.";
            return false;
        } else {
            // Proses upload file jika semua cek berhasil
            if (move_uploaded_file($file["tmp_name"], $target_file)) {
                return $target_file; // Kembalikan URL gambar
            } else {
                echo "Maaf, ada kesalahan saat mengupload file.";
                return false;
            }
        }
    }

    // Menampilkan tampilan untuk mengedit kue
    public function edit()
    {
        if (!isset($_GET['i'])) {
            header("Location: /cake-shop/?act=tampil-kue"); // Redirect jika ID kue tidak ada
            exit;
        }

        // Mendapatkan data kue berdasarkan ID
        $cake = $this->cake->lihatDataDetail($_GET['i']);
        $categories = $this->cake->getAllCategories(); // Mendapatkan semua kategori untuk dropdown
        require_once 'app/Views/cake/edit.php'; // Menampilkan form edit kue
    }

    // Melakukan update data kue
    public function update()
    {
        $id = $_POST['id']; // Mendapatkan ID kue yang akan diupdate
        $name = $_POST['name']; // Mendapatkan nama kue
        $price = str_replace(['Rp ', ' '], '', $_POST['price']); // Menghapus format harga
        $stock = $_POST['stock']; // Mendapatkan stok
        $category_id = $_POST['category_id']; // Mendapatkan ID kategori

        // Mengambil data kue saat ini untuk mendapatkan gambar yang sudah ada
        $currentCake = $this->cake->lihatDataDetail($id);
        $imgurl = $currentCake['imgurl']; // Mengambil URL gambar yang sudah ada

        // Cek apakah ada gambar baru
        if (!empty($_FILES['imgurl']['name'])) {
            // Jika ada gambar baru, upload dan ambil URL-nya
            $imgurl = $this->uploadImage($_FILES['imgurl']);
        }

        // Update data kue dengan data baru dan gambar
        $this->cake->updateData($id, $name, $price, $stock, $imgurl, $category_id);

        // Redirect setelah update
        header("Location: /cake-shop/?act=tampil-kue");
    }

    // Menghapus data kue
    public function delete()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id']; // Mendapatkan ID kue yang akan dihapus
            $this->cake->deleteData($id); // Menghapus data kue berdasarkan ID

            // Redirect setelah penghapusan
            header("Location: /cake-shop/?act=tampil-kue");
            exit();
        }
    }

    // Mengambil semua data kue
    public function getCakes()
    {
        return $this->cake->lihatData(); // Mengembalikan daftar kue
    }

    // Menampilkan kategori kue
    public function showCategory()
    {
        $categories = $this->cake->getAllCategories(); // Mendapatkan semua kategori kue
        require_once 'app/Views/cake/category.php'; // Menampilkan daftar kategori
    }

    // Menyimpan kategori baru
    public function saveCategory()
    {
        if (isset($_POST['name']) && !empty($_POST['name'])) {
            $name = trim($_POST['name']); // Mengambil nama kategori yang telah di-trim
    
            // Menyimpan kategori ke dalam database
            $this->cake->simpanCategory($name);
    
            // Redirect setelah kategori disimpan
            header("Location: /cake-shop/?act=show-category");
            exit;
        } else {
            echo "Nama kategori tidak boleh kosong!"; // Menampilkan pesan error jika nama kategori kosong
        }
    }

    // Menghapus kategori
    public function hapusCategory()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id']; // Mendapatkan ID kategori yang akan dihapus
            $this->cake->hapusCategory($id); // Menghapus kategori berdasarkan ID

            // Redirect setelah kategori dihapus
            header("Location: /cake-shop/?act=show-category");
            exit();
        }
    }

    // Melakukan update kategori
    public function updateCategory()
    {
        $id = $_POST['id']; // Mendapatkan ID kategori yang akan diupdate
        $name = $_POST['name']; // Mendapatkan nama kategori yang baru

        // Melakukan update kategori
        $this->cake->updateCategory($id, $name);

        // Redirect setelah kategori diperbarui
        header("Location: /cake-shop/?act=show-category");
    }
}
