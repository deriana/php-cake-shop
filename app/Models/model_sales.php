<?php

namespace Models;

class Model_sales
{
    private $dbh;

    public function __construct()
    {
        $this->dbh = new \PDO('mysql:host=localhost;dbname=db_cake', 'root', 'root');
    }

    public function simpanData($cake_id, $quantity, $discount, $total_price, $payment_method)
    {
        // Validasi input
        if ($quantity <= 0) {
            return false; // Jumlah tidak boleh negatif atau nol
        }
        if ($discount < 0) {
            $discount = 0; // Diskon tidak boleh negatif
        }
    
        try {
            // Simpan data penjualan
            $stmt = $this->dbh->prepare("INSERT INTO sales (cake_id, quantity, discount, total_price, payment_method) VALUES (?, ?, ?, ?, ?)");
            if ($stmt->execute([$cake_id, $quantity, $discount, $total_price, $payment_method])) {
                return true; // Transaksi berhasil
            }
        } catch (\PDOException $e) {
            // Log error or handle it appropriately
            error_log("Database error: " . $e->getMessage());
            return false; // Mengembalikan false jika terjadi kesalahan
        }
    
        return false; // Jika kue tidak dapat disimpan
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
}
