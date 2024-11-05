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
    public function index() {
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
        $price = $_POST['price'];
        $stock = $_POST['stock'];

        // Menghandle upload file
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
}
