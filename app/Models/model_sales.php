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
        if ($quantity <= 0) {
            return false;
        }
        if ($discount < 0) {
            $discount = 0;
        }

        try {
            $stmt = $this->dbh->prepare("SELECT price, stock FROM cakes WHERE id = ?");
            $stmt->execute([$cake_id]);
            $cake = $stmt->fetch(\PDO::FETCH_ASSOC);

            if ($cake) {
                if ($cake['stock'] < $quantity) {
                    return false;
                }

                $price_per_unit = $cake['price'];
                $total_price = ($quantity * $price_per_unit) - $discount;

                if ($total_price < 0) {
                    $total_price = 0;
                }

                $created_at = date('Y-m-d');

                $stmt = $this->dbh->prepare("INSERT INTO sales (cake_id, quantity, discount, total_price, payment_method, pembeli, created_at) VALUES (?, ?, ?, ?, ?, ?, ?)");
                if ($stmt->execute([$cake_id, $quantity, $discount, $total_price, $payment_method, $pembeli, $created_at])) {
                    $new_stock = $cake['stock'] - $quantity;
                    $this->updateStock($cake_id, $new_stock);
                    return true;
                }
            }
        } catch (\PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }

        return false;
    }


    public function getTotalSales($start_date, $end_date)
    {
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
            return [];
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

    public function totalKeuntungan()
    {
        try {
            $stmt = $this->dbh->prepare("SELECT SUM(s.total_price) AS total_keuntungan FROM sales s");
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (\PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return 0;
        }
    }

    public function kuePalingSering()
    {
        try {
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
            error_log("Database error: " . $e->getMessage());
            return [];
        }
    }

    public function penjualanPerTanggal()
    {
        try {
            $stmt = $this->dbh->prepare("
            SELECT DATE(s.created_at) AS tanggal, SUM(s.total_price) AS total 
            FROM sales s 
            GROUP BY tanggal 
            ORDER BY tanggal ASC
        ");
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return [];
        }
    }

    public function penjualanPerBulan()
    {
        try {
            $stmt = $this->dbh->prepare("
            SELECT MONTH(s.created_at) AS bulan, YEAR(s.created_at) AS tahun, SUM(s.total_price) AS total 
            FROM sales s 
            GROUP BY tahun, bulan 
            ORDER BY tahun, bulan ASC
        ");
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return [];
        }
    }
}
