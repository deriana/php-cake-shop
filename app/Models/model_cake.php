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

    function simpanData($name, $price, $stock, $imgurl, $category)
    {
        $rs = $this->dbh->prepare("INSERT INTO cakes (name, price, stock, imgurl, category) VALUES (?, ?, ?, ?, ?)");
        $rs->execute([$name, $price, $stock, $imgurl, $category]);
    }


    function lihatData()
    {
        $rs = $this->dbh->query("SELECT * FROM cakes");
        return $rs;
    }

    function lihatDataDetail($id)
    {
        $rs = $this->dbh->prepare("SELECT * FROM cakes WHERE id=?");
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
        $stmt = $this->dbh->prepare("SELECT id, name, price FROM cakes");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCakeById($cake_id)
    {
        $stmt = $this->dbh->prepare("SELECT * FROM cakes WHERE id = ?");
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
            cakes.category,
            COALESCE(SUM(sales.quantity), 0) AS total_sold
        FROM 
            cakes
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
        // Query untuk mendapatkan nama kue, harga, dan total unit terjual
        $stmt = $this->dbh->prepare("
        SELECT c.name, c.price, c.category, COALESCE(SUM(s.quantity), 0) as units_sold
        FROM cakes c
        LEFT JOIN sales s ON c.id = s.cake_id
        GROUP BY c.id
    ");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


    function updateData($id, $name, $price, $stock, $imgurl, $category)
    {
        $stmt = $this->dbh->prepare("UPDATE cakes SET name = ?, price = ?, stock = ?, imgurl = ?, category = ? WHERE id = ?");
        $stmt->execute([$name, $price, $stock, $imgurl, $category, $id]);
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
}
