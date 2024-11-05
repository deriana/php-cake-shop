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
    public function index()
    {
        require_once 'app/Views/index.php';
    }

    public function input()
    {
        require_once 'app/Views/cake/index.php';
    }

    public function users()
    {
        // Fetch users from the model
        $users = $this->cake->lihat_user()->fetchAll(\PDO::FETCH_ASSOC); // Fetch all users as an associative array
        require_once 'app/Views/user/index.php'; // Load the user view
    }

    public function laporan()
    {
        require_once 'app/Views/laporan/index.php';
    }

    function show_data()
    {
        if (!isset($_GET['i'])) {
            $rs = $this->cake->lihatData();
            require_once('app/Views/cake/list.php');
        } else {
            $rs = $this->cake->lihatDataDetail($_GET['i']);
            require_once('app/Views/cake/detail.php');
        }
    }

    function save()
    {
        $name = $_POST['name'];
        $price = str_replace(['Rp ', ' '], '', $_POST['price']);
        $price = (float)$price;

        $stock = $_POST['stock'];

        $imgurl = $this->uploadImage($_FILES['imgurl']);

        if ($imgurl) {
            $this->cake->simpanData($name, $price, $stock, $imgurl);
        }

        $this->index();
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
        header("Location: /mvc-example/?act=tampil-kue");
        exit;
    }

    $cake = $this->cake->lihatDataDetail($_GET['i']);
    require_once 'app/Views/cake/edit.php'; 
}

function update()
{
    $id = $_POST['id']; // Mendapatkan ID kue yang akan diupdate
    $name = $_POST['name']; // Mendapatkan nama kue
    $price = str_replace(['Rp ', ' '], '', $_POST['price']); // Menghapus format Rp dan spasi dari harga
    $stock = $_POST['stock']; // Mendapatkan stok

    // Ambil data kue saat ini untuk mendapatkan imgurl yang sudah ada
    $currentCake = $this->cake->lihatDataDetail($id);
    $imgurl = $currentCake['imgurl']; // Simpan gambar yang sudah ada

    // Cek apakah ada file gambar baru
    if (!empty($_FILES['imgurl']['name'])) {
        // Jika ada gambar baru, upload gambar dan simpan URL-nya
        $imgurl = $this->uploadImage($_FILES['imgurl']);
    }

    // Lakukan update data dengan URL gambar yang sesuai
    $this->cake->updateData($id, $name, $price, $stock, $imgurl);

    // Redirect atau tampilkan kembali daftar kue
    header("Location: /mvc-example/?act=tampil-kue");
}

}
