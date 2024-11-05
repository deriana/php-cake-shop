<?php

namespace Models;

class Model_user
{
    private $dbh;

    public function __construct()
    {
        $this->dbh = new \PDO('mysql:host=localhost;dbname=db_cake', 'root', 'root');
    }

    public function lihat_user()
    {
        $stmt = $this->dbh->prepare("SELECT * FROM users");
        $stmt->execute();
        return $stmt;
    }
    
    public function deleteData($id)
    {
        $stmt = $this->dbh->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);
    }
}
