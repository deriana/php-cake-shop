<?php

namespace Models;

use PDO;

class Model_sales
{
    private $dbh;

    public function __construct()
    {
        $this->dbh = new \PDO('mysql:host=localhost;dbname=db_cake', 'root', 'root');
    }

    public function simpanData($cake_id, $quantity, $discount, $total_price, $payment_method, $pembeli)
    {
        // Validasi input (sama seperti sebelumnya)
        if ($quantity <= 0) {
            return false; // Jumlah tidak boleh negatif atau nol
        }
        if ($discount < 0) {
            $discount = 0; // Diskon tidak boleh negatif
        }

        try {
            // Ambil harga satuan kue dan stok berdasarkan cake_id
            $stmt = $this->dbh->prepare("SELECT price, stock FROM cakes WHERE id = ?");
            $stmt->execute([$cake_id]);
            $cake = $stmt->fetch(\PDO::FETCH_ASSOC);

            if ($cake) {
                // Cek apakah stok cukup
                if ($cake['stock'] < $quantity) {
                    return false; // Stok tidak mencukupi
                }

                $price_per_unit = $cake['price'];
                $total_price = ($quantity * $price_per_unit) - $discount;

                // Pastikan total_price tidak negatif
                if ($total_price < 0) {
                    $total_price = 0;
                }

                // Mendapatkan tanggal saat ini untuk created_at
                $created_at = date('Y-m-d'); // Format untuk DATE

                // Simpan data penjualan dengan pembeli dan waktu saat ini
                $stmt = $this->dbh->prepare("INSERT INTO sales (cake_id, quantity, discount, total_price, payment_method, pembeli, created_at) VALUES (?, ?, ?, ?, ?, ?, ?)");
                if ($stmt->execute([$cake_id, $quantity, $discount, $total_price, $payment_method, $pembeli, $created_at])) {
                    // Kurangi stok kue
                    $new_stock = $cake['stock'] - $quantity;
                    $this->updateStock($cake_id, $new_stock); // Update stok kue
                    return true; // Transaksi berhasil
                }
            }
        } catch (\PDOException $e) {
            // Log error or handle it appropriately
            error_log("Database error: " . $e->getMessage());
            return false; // Mengembalikan false jika terjadi kesalahan
        }

        return false; // Jika kue tidak ditemukan
    }


    public function getTotalSales($start_date, $end_date)
    {
        // Pastikan format tanggal adalah YYYY-MM-DD
        $stmt = $this->dbh->prepare("SELECT SUM(total_price) AS total_sales FROM sales WHERE created_at BETWEEN ? AND ?");
        $stmt->execute([$start_date, $end_date]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }



    public function getCakeById($cake_id)
    {
        $stmt = $this->dbh->prepare("SELECT price, stock FROM cakes WHERE id = ?");
        $stmt->execute([$cake_id]);
        return $stmt; // Mengembalikan statement untuk fetch
    }

    public function updateStock($cake_id, $new_stock)
    {
        try {
            // Update stok kue
            $stmt = $this->dbh->prepare("UPDATE cakes SET stock = ? WHERE id = ?");
            return $stmt->execute([$new_stock, $cake_id]);
        } catch (\PDOException $e) {
            // Log error or handle it appropriately
            error_log("Database error: " . $e->getMessage());
            return false; // Mengembalikan false jika terjadi kesalahan
        }
    }

    public function lihatSales()
    {
        try {
            $stmt = $this->dbh->prepare("SELECT s.*, c.name AS cake_name FROM sales s JOIN cakes c ON s.cake_id = c.id");
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return []; // Mengembalikan array kosong jika terjadi kesalahan
        }
    }

    public function getSalesByDateRange($start_date, $end_date)
    {
        try {
            $stmt = $this->dbh->prepare("
            SELECT s.*, c.name AS cake_name 
            FROM sales s 
            JOIN cakes c ON s.cake_id = c.id 
            WHERE DATE(s.created_at) BETWEEN ? AND ?
        ");
            $stmt->execute([$start_date, $end_date]);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return [];
        }
    }
}
