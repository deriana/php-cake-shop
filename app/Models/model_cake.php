<?php

namespace Models;

use Libraries\Database;
use PDO;

class Model_cake
{
    private $dbh;

    public function __construct()
    {
        $db = new Database();
        $this->dbh = $db->getInstance();
    }

    function simpanData($name, $price, $stock, $imgurl, $category_id)
    {
        $rs = $this->dbh->prepare("INSERT INTO cakes (name, price, stock, imgurl, category_id) VALUES (?, ?, ?, ?, ?)");
        $rs->execute([$name, $price, $stock, $imgurl, $category_id]);
    }

    function lihatData()
    {
        $rs = $this->dbh->query("
            SELECT cakes.*, category.id AS category_id, category.name AS category_name
            FROM cakes
            LEFT JOIN category ON cakes.category_id = category.id
        ");
        return $rs->fetchAll(\PDO::FETCH_ASSOC);
    }    

    function LihatDataDetail($id)
    {
        $rs = $this->dbh->prepare("
            SELECT cakes.*, category.name AS category_name
            FROM cakes
            LEFT JOIN category ON cakes.category_id = category.id
            WHERE cakes.id = ?
        ");
        $rs->execute([$id]);
        return $rs->fetch();
    }

    public function getTotalCakeStockValue()
    {
        $stmt = $this->dbh->prepare("SELECT SUM(stock * price) AS total_value FROM cakes");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getAllCakes()
    {
        $stmt = $this->dbh->prepare("
            SELECT cakes.id, cakes.name, cakes.price, category.name AS category_name
            FROM cakes
            LEFT JOIN category ON cakes.category_id = category.id
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCakeById($cake_id)
    {
        $stmt = $this->dbh->prepare("
            SELECT cakes.*, category.name AS category_name
            FROM cakes
            LEFT JOIN category ON cakes.category_id = category.id
            WHERE cakes.id = ?
        ");
        $stmt->execute([$cake_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getCakeStockValueById($cake_id)
    {
        $stmt = $this->dbh->prepare("SELECT stock, price FROM cakes WHERE id = ?");
        $stmt->execute([$cake_id]);
        $cake = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($cake) {
            return $cake['stock'] * $cake['price'];
        }

        return 0;
    }

    public function getAllCakesSalesReport()
    {
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
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getCakeSalesReport()
    {
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
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    

    function updateData($id, $name, $price, $stock, $imgurl, $category_id)
    {
        $stmt = $this->dbh->prepare("UPDATE cakes SET name = ?, price = ?, stock = ?, imgurl = ?, category_id = ? WHERE id = ?");
        $stmt->execute([$name, $price, $stock, $imgurl, $category_id, $id]);
    }

    function deleteData($id)
    {
        $stmt = $this->dbh->prepare("DELETE FROM sales WHERE cake_id = ?");
        $stmt->execute([$id]);

        $rs = $this->dbh->prepare("DELETE FROM cakes WHERE id = ?");
        $rs->execute([$id]);
    }

    function lihat_user()
    {
        $rs = $this->dbh->prepare("SELECT * FROM users");
        $rs->execute();
        return $rs;
    }

    public function lihatDataRandom($limit = 6)
    {
        $sql = "SELECT * FROM cakes ORDER BY RAND() LIMIT :limit";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function jumlahKue()
    {
        try {
            $stmt = $this->dbh->prepare("SELECT SUM(stock) AS jumlah_kue FROM cakes");
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (\PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return 0;   
        }
    }

    public function getAllCategories()
    {
        $stmt = $this->dbh->prepare("SELECT * FROM category");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function simpanCategory($name)
    {  
        $stmt = $this->dbh->prepare("INSERT INTO category(name) VALUES(?)");
        $stmt->execute([$name]);
    }

    function hapusCategory($id)
    {
        $stmt = $this->dbh->prepare("DELETE FROM category WHERE id = ?");
        $stmt->execute([$id]);
    }

    function updateCategory($id, $name)
    {
        $stmt = $this->dbh->prepare("UPDATE category SET name = ? WHERE id = ?");
        $stmt->execute([$name, $id]);
    }
    
}
