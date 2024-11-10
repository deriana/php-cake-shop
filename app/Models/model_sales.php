<?php

namespace Models;

use PDO;

class Model_sales
{
    private $dbh;

    // Konstruktor: Menginisialisasi koneksi database menggunakan PDO
    public function __construct()
    {
        $this->dbh = new \PDO('mysql:host=localhost;dbname=db_cake', 'root', 'root');
    }

    // Menyimpan data penjualan kue
    public function simpanData($cake_id, $quantity, $discount, $total_price, $payment_method, $pembeli)
    {
        // Validasi kuantitas dan diskon
        if ($quantity <= 0) {
            return false;
        }
        if ($discount < 0) {
            $discount = 0;
        }

        try {
            // Ambil data harga dan stok kue dari tabel cakes
            $stmt = $this->dbh->prepare("SELECT price, stock FROM cakes WHERE id = ?");
            $stmt->execute([$cake_id]);
            $cake = $stmt->fetch(\PDO::FETCH_ASSOC);

            if ($cake) {
                // Validasi apakah stok cukup untuk penjualan
                if ($cake['stock'] < $quantity) {
                    return false;
                }

                // Hitung harga total setelah diskon
                $price_per_unit = $cake['price'];
                $total_price = ($quantity * $price_per_unit) - $discount;

                // Pastikan total harga tidak negatif
                if ($total_price < 0) {
                    $total_price = 0;
                }

                $created_at = date('Y-m-d'); // Tanggal penjualan

                // Simpan data penjualan ke dalam tabel sales
                $stmt = $this->dbh->prepare("INSERT INTO sales (cake_id, quantity, discount, total_price, payment_method, pembeli, created_at) VALUES (?, ?, ?, ?, ?, ?, ?)");
                if ($stmt->execute([$cake_id, $quantity, $discount, $total_price, $payment_method, $pembeli, $created_at])) {
                    // Update stok setelah penjualan
                    $new_stock = $cake['stock'] - $quantity;
                    $this->updateStock($cake_id, $new_stock);
                    return true;
                }
            }
        } catch (\PDOException $e) {
            // Menangani error database
            error_log("Database error: " . $e->getMessage());
            return false;
        }

        return false;
    }

    // Mengambil total penjualan dalam rentang waktu tertentu
    public function getTotalSales($start_date, $end_date)
    {
        $stmt = $this->dbh->prepare("SELECT SUM(total_price) AS total_sales FROM sales WHERE created_at BETWEEN ? AND ?");
        $stmt->execute([$start_date, $end_date]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Mengambil data harga dan stok kue berdasarkan ID
    public function getCakeById($cake_id)
    {
        $stmt = $this->dbh->prepare("SELECT price, stock FROM cakes WHERE id = ?");
        $stmt->execute([$cake_id]);
        return $stmt;
    }

    // Mengupdate stok kue setelah penjualan
    public function updateStock($cake_id, $new_stock)
    {
        try {
            // Update stok kue
            $stmt = $this->dbh->prepare("UPDATE cakes SET stock = ? WHERE id = ?");
            return $stmt->execute([$new_stock, $cake_id]);
        } catch (\PDOException $e) {
            // Menangani error database
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }

    // Menampilkan seluruh data penjualan
    public function lihatSales()
    {
        try {
            // Menyiapkan query untuk mengambil data penjualan beserta nama kue yang terjual
            $stmt = $this->dbh->prepare("SELECT s.*, c.name AS cake_name FROM sales s JOIN cakes c ON s.cake_id = c.id");
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            // Menangani error database
            error_log("Database error: " . $e->getMessage());
            return [];
        }
    }

    public function deleteSales($sale_id)
    {
        try {
            // Menyiapkan query untuk menghapus data penjualan berdasarkan ID penjualan
            $stmt = $this->dbh->prepare("DELETE FROM sales WHERE id = :sale_id");
            $stmt->bindParam(':sale_id', $sale_id, \PDO::PARAM_INT);
            $stmt->execute();
    
            // Mengembalikan hasil sukses atau tidaknya operasi
            return $stmt->rowCount() > 0; // Mengembalikan true jika ada baris yang dihapus
        } catch (\PDOException $e) {
            // Menangani error database
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }
    

    // Mengambil data penjualan berdasarkan rentang tanggal tertentu
    public function getSalesByDateRange($start_date, $end_date)
    {
        try {
            // Menyiapkan query untuk mengambil data penjualan dalam rentang tanggal tertentu
            $stmt = $this->dbh->prepare("
            SELECT s.*, c.name AS cake_name 
            FROM sales s 
            JOIN cakes c ON s.cake_id = c.id 
            WHERE DATE(s.created_at) BETWEEN ? AND ?
        ");
            $stmt->execute([$start_date, $end_date]);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            // Menangani error database
            error_log("Database error: " . $e->getMessage());
            return [];
        }
    }

    // Menghitung total keuntungan dari seluruh penjualan
    public function totalKeuntungan()
    {
        try {
            // Menyiapkan query untuk menghitung total keuntungan dari penjualan
            $stmt = $this->dbh->prepare("SELECT SUM(s.total_price) AS total_keuntungan FROM sales s");
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (\PDOException $e) {
            // Menangani error database
            error_log("Database error: " . $e->getMessage());
            return 0;
        }
    }

    // Mengambil 5 kue yang paling sering terjual
    public function kuePalingSering()
    {
        try {
            // Menyiapkan query untuk mengambil 5 kue yang paling sering terjual
            $stmt = $this->dbh->prepare("
            SELECT c.name, COUNT(s.cake_id) AS total_penjualan 
            FROM sales s 
            JOIN cakes c ON s.cake_id = c.id 
            GROUP BY c.id 
            ORDER BY total_penjualan DESC 
            LIMIT 5
        ");
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            // Menangani error database
            error_log("Database error: " . $e->getMessage());
            return [];
        }
    }

    // Mengambil data penjualan per tanggal
    public function penjualanPerTanggal()
    {
        try {
            // Menyiapkan query untuk mengambil penjualan per tanggal
            $stmt = $this->dbh->prepare("
            SELECT DATE(s.created_at) AS tanggal, SUM(s.total_price) AS total 
            FROM sales s 
            GROUP BY tanggal 
            ORDER BY tanggal ASC
        ");
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            // Menangani error database
            error_log("Database error: " . $e->getMessage());
            return [];
        }
    }

    // Mengambil data penjualan per bulan
    public function penjualanPerBulan()
    {
        try {
            // Menyiapkan query untuk mengambil penjualan per bulan
            $stmt = $this->dbh->prepare("
            SELECT MONTH(s.created_at) AS bulan, YEAR(s.created_at) AS tahun, SUM(s.total_price) AS total 
            FROM sales s 
            GROUP BY tahun, bulan 
            ORDER BY tahun, bulan ASC
        ");
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            // Menangani error database
            error_log("Database error: " . $e->getMessage());
            return [];
        }
    }

    // Mengambil semua kategori kue
    public function getAllCategories()
    {
        $stmt = $this->dbh->prepare("SELECT * FROM category");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDateSales($start_date, $end_date)
    {
        $stmt = $this->dbh->prepare("SELECT * FROM sales WHERE created_at BETWEEN :start_date AND :end_date");
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':end_date', $end_date);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
