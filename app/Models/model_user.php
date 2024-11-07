<?php

namespace Models;

use PDO;

class Model_user
{
    private $dbh;

    public function __construct()
    {
        $this->dbh = new \PDO('mysql:host=localhost;dbname=db_cake', 'root', 'root');
    }

    public function getUserById($id)
    {
        $stmt = $this->dbh->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Mengembalikan hasil sebagai array asosiatif
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

    function simpanUser($username, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->dbh->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->execute([$username, $hashedPassword]);
    }

    public function userUpdate($id, $username, $password = null)
    {
        if ($password) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $rs = $this->dbh->prepare("UPDATE users SET username = ?, password = ? WHERE id = ?");
            $rs->execute([$username, $hashedPassword, $id]);
        } else {
            $rs = $this->dbh->prepare("UPDATE users SET username = ? WHERE id = ?");
            $rs->execute([$username, $id]);
        }
    }

    // Metode untuk mendapatkan pengguna berdasarkan username
    public function getUserByUsername($username)
    {
        $stmt = $this->dbh->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}
