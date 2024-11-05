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

    function simpanData($name, $price, $stock, $imgurl)
    {
        $rs = $this->dbh->prepare("INSERT INTO cakes (name, price, stock, imgurl) VALUES (?, ?, ?, ?)");
        $rs->execute([$name, $price, $stock, $imgurl]);
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


    function updateData($id, $name, $price, $stock, $imgurl)
    {
        $rs = $this->dbh->prepare("UPDATE cakes SET name=?, price=?, stock=?, imgurl=? WHERE id=?");
        $rs->execute([$name, $price, $stock, $imgurl, $id]);
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

    public function tambah_user($username, $password)
    {
        $hashedPassword = md5($password); // Hash dengan MD5
        $stmt = $this->dbh->prepare("INSERT INTO users (username, password, created_at) VALUES (?, ?, NOW())");
        $stmt->execute([$username, $hashedPassword]);
    }
}
