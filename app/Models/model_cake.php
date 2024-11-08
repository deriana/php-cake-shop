<?php

namespace Models;

use Libraries\Database;
use PDO;

class Model_cake
{
    private $dbh;

    // Konstruktor: Menginisialisasi koneksi database
    public function __construct()
    {
        $db = new Database();
        $this->dbh = $db->getInstance(); // Mendapatkan instance PDO tunggal
    }

    // Menyimpan data kue ke dalam database
    function simpanData($name, $price, $stock, $imgurl, $category_id)
    {
        // Menyiapkan query SQL untuk menyimpan data ke tabel cakes
        $rs = $this->dbh->prepare("INSERT INTO cakes (name, price, stock, imgurl, category_id) VALUES (?, ?, ?, ?, ?)");
        $rs->execute([$name, $price, $stock, $imgurl, $category_id]);
    }

    // Mengambil semua data kue beserta kategori-nya
    function lihatData()
    {
        // Menyiapkan query untuk mengambil semua data kue dan melakukan join dengan tabel kategori
        $rs = $this->dbh->query("
            SELECT cakes.*, category.id AS category_id, category.name AS category_name
            FROM cakes
            LEFT JOIN category ON cakes.category_id = category.id
        ");
        return $rs->fetchAll(\PDO::FETCH_ASSOC);
    }    

    // Mengambil data detail kue berdasarkan ID
    function LihatDataDetail($id)
    {
        // Menyiapkan query untuk mengambil data detail kue berdasarkan ID
        $rs = $this->dbh->prepare("
            SELECT cakes.*, category.name AS category_name
            FROM cakes
            LEFT JOIN category ON cakes.category_id = category.id
            WHERE cakes.id = ?
        ");
        $rs->execute([$id]);
        return $rs->fetch();
    }

    // Menghitung total nilai stok kue (stok * harga)
    public function getTotalCakeStockValue()
    {
        // Menyiapkan query untuk menghitung total nilai stok kue
        $stmt = $this->dbh->prepare("SELECT SUM(stock * price) AS total_value FROM cakes");
        $stmt->execute();
        return $stmt->fetchColumn(); // Mengembalikan nilai total
    }

    // Mengambil semua kue beserta nama kategori-nya
    public function getAllCakes()
    {
        // Menyiapkan query untuk mengambil semua kue beserta nama kategori-nya
        $stmt = $this->dbh->prepare("
            SELECT cakes.id, cakes.name, cakes.price, category.name AS category_name
            FROM cakes
            LEFT JOIN category ON cakes.category_id = category.id
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Mengembalikan data semua kue
    }

    // Mengambil data kue berdasarkan ID
    public function getCakeById($cake_id)
    {
        // Menyiapkan query untuk mengambil data kue berdasarkan ID
        $stmt = $this->dbh->prepare("
            SELECT cakes.*, category.name AS category_name
            FROM cakes
            LEFT JOIN category ON cakes.category_id = category.id
            WHERE cakes.id = ?
        ");
        $stmt->execute([$cake_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Mengembalikan data kue
    }

    // Menghitung nilai stok (stok * harga) untuk kue tertentu
    public function getCakeStockValueById($cake_id)
    {
        // Menyiapkan query untuk mengambil stok dan harga kue berdasarkan ID
        $stmt = $this->dbh->prepare("SELECT stock, price FROM cakes WHERE id = ?");
        $stmt->execute([$cake_id]);
        $cake = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($cake) {
            // Menghitung nilai stok jika kue ditemukan
            return $cake['stock'] * $cake['price'];
        }

        return 0; // Mengembalikan 0 jika kue tidak ditemukan
    }

    // Mengambil laporan penjualan semua kue
    public function getAllCakesSalesReport()
    {
        // Menyiapkan query untuk mengambil data penjualan semua kue, termasuk jumlah total terjual
        $stmt = $this->dbh->prepare("
            SELECT 
                cakes.name AS cake_name,
                cakes.price,
                category.name AS category_name,
                COALESCE(SUM(sales.quantity), 0) AS total_sold
            FROM 
                cakes
            LEFT JOIN 
                category ON cakes.category_id = category.id
            LEFT JOIN 
                sales ON cakes.id = sales.cake_id
            GROUP BY 
                cakes.id
            ORDER BY 
                total_sold DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC); // Mengembalikan laporan penjualan kue
    }

    // Mengambil laporan penjualan kue
    public function getCakeSalesReport()
    {
        // Menyiapkan query untuk mengambil laporan penjualan kue dengan kategori dan jumlah unit yang terjual
        $stmt = $this->dbh->prepare("
            SELECT 
                c.name, 
                c.price, 
                category.name AS category_name, 
                category.id AS category_id,   -- Menambahkan category_id
                COALESCE(SUM(s.quantity), 0) AS units_sold
            FROM 
                cakes c
            LEFT JOIN 
                sales s ON c.id = s.cake_id
            LEFT JOIN 
                category ON c.category_id = category.id
            GROUP BY 
                c.id, category.id  -- Jangan lupa untuk menambahkan category.id di GROUP BY
        ");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC); // Mengembalikan laporan penjualan
    }

    // Mengupdate data kue
    function updateData($id, $name, $price, $stock, $imgurl, $category_id)
    {
        // Menyiapkan query untuk memperbarui data kue berdasarkan ID
        $stmt = $this->dbh->prepare("UPDATE cakes SET name = ?, price = ?, stock = ?, imgurl = ?, category_id = ? WHERE id = ?");
        $stmt->execute([$name, $price, $stock, $imgurl, $category_id, $id]);
    }

    // Menghapus data kue dan data penjualannya
    function deleteData($id)
    {
        // Menghapus penjualan yang terkait dengan kue
        $stmt = $this->dbh->prepare("DELETE FROM sales WHERE cake_id = ?");
        $stmt->execute([$id]);

        // Menghapus data kue
        $rs = $this->dbh->prepare("DELETE FROM cakes WHERE id = ?");
        $rs->execute([$id]);
    }

    // Mengambil semua data pengguna
    function lihat_user()
    {
        $rs = $this->dbh->prepare("SELECT * FROM users");
        $rs->execute();
        return $rs;
    }

    // Mengambil data kue secara acak (misalnya untuk ditampilkan di halaman depan)
    public function lihatDataRandom($limit = 6)
    {
        // Menyiapkan query untuk mengambil kue secara acak dengan limit tertentu
        $sql = "SELECT * FROM cakes ORDER BY RAND() LIMIT :limit";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Mengembalikan data kue acak
    }

    // Menghitung jumlah total stok kue
    public function jumlahKue()
    {
        try {
            // Menyiapkan query untuk menghitung jumlah stok kue
            $stmt = $this->dbh->prepare("SELECT SUM(stock) AS jumlah_kue FROM cakes");
            $stmt->execute();
            return $stmt->fetchColumn(); // Mengembalikan jumlah stok
        } catch (\PDOException $e) {
            error_log("Error Database: " . $e->getMessage());
            return 0;   // Mengembalikan 0 jika terjadi kesalahan
        }
    }

    // Mengambil semua kategori kue
    public function getAllCategories()
    {
        $stmt = $this->dbh->prepare("SELECT * FROM category");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Mengembalikan semua kategori
    }

    // Menyimpan kategori baru
    function simpanCategory($name)
    {  
        $stmt = $this->dbh->prepare("INSERT INTO category(name) VALUES(?)");
        $stmt->execute([$name]);
    }

    // Menghapus kategori
    function hapusCategory($id)
    {
        $stmt = $this->dbh->prepare("DELETE FROM category WHERE id = ?");
        $stmt->execute([$id]);
    }

    // Mengupdate kategori
    function updateCategory($id, $name)
    {
        $stmt = $this->dbh->prepare("UPDATE category SET name = ? WHERE id = ?");
        $stmt->execute([$name, $id]);
    }
}

