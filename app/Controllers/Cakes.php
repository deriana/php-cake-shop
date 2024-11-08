<?php

namespace Controllers;

use Models\Model_cake;

class Cakes
{
    private $cake;

    public function __construct()
    {
        $this->cake = new Model_cake();
    }

    public function input()
    {
        $categories = $this->cake->getAllCategories();
        require_once 'app/Views/cake/index.php';
    }

    public function show_data()
    {
        $categories = $this->cake->getAllCategories();
        if (!isset($_GET['i'])) {
            $cakes = $this->cake->lihatData();
            require_once('app/Views/cake/list.php');
        } else {
            $cakes = $this->cake->lihatDataDetail($_GET['i']);
            require_once('app/Views/cake/detail.php');
        }
    }

    public function save()
    {
        $name = $_POST['name'];
        $price = str_replace(['Rp ', ' '], '', $_POST['price']);
        $price = (float)$price;
        $stock = $_POST['stock'];
        $category_id = $_POST['category_id'];

        $imgurl = $this->uploadImage($_FILES['imgurl']);

        if ($imgurl) {
            $this->cake->simpanData($name, $price, $stock, $imgurl, $category_id); // Kirimkan category_id ke model
        }

        $this->show_data();
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
        $categories = $this->cake->getAllCategories(); // Dapatkan semua kategori untuk dropdown di form edit
        require_once 'app/Views/cake/edit.php';
    }

    public function update()
    {
        $id = $_POST['id']; // Mendapatkan ID kue yang akan diupdate
        $name = $_POST['name']; // Mendapatkan nama kue
        $price = str_replace(['Rp ', ' '], '', $_POST['price']); // Menghapus format Rp dan spasi dari harga
        $stock = $_POST['stock']; // Mendapatkan stok
        $category_id = $_POST['category_id']; // Mengambil category_id dari input

        // Ambil data kue saat ini untuk mendapatkan imgurl yang sudah ada
        $currentCake = $this->cake->lihatDataDetail($id);
        $imgurl = $currentCake['imgurl']; // Simpan gambar yang sudah ada

        // Cek apakah ada file gambar baru
        if (!empty($_FILES['imgurl']['name'])) {
            // Jika ada gambar baru, upload gambar dan simpan URL-nya
            $imgurl = $this->uploadImage($_FILES['imgurl']);
        }

        // Lakukan update data dengan URL gambar dan category_id yang sesuai
        $this->cake->updateData($id, $name, $price, $stock, $imgurl, $category_id); // Pastikan category_id ditambahkan

        // Redirect atau tampilkan kembali daftar kue
        header("Location: /cake-shop/?act=tampil-kue");
    }

    public function delete()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $this->cake->deleteData($id);

            header("Location: /cake-shop/?act=tampil-kue");
            exit();
        }
    }

    public function getCakes()
    {
        return $this->cake->lihatData();
    }

    public function showCategory()
    {
        $categories = $this->cake->getAllCategories();
        require_once 'app/Views/cake/category.php';
    }

    public function saveCategory()
    {
        if (isset($_POST['name']) && !empty($_POST['name'])) {
            $name = trim($_POST['name']);
    
            $this->cake->simpanCategory($name);
    
            header("Location: /cake-shop/?act=show-category");
            exit;
        } else {
            echo "Nama kategori tidak boleh kosong!";
        }
    }

    public function hapusCategory()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $this->cake->hapusCategory($id);

            header("Location: /cake-shop/?act=show-category");
            exit();
        }
    }
    
    public function updateCategory()
{
    $id = $_POST['id'];
    $name = $_POST['name'];

    $this->cake->updateCategory($id, $name);

    header("Location: /cake-shop/?act=show-category");
}

}
