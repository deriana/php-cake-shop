<?php

namespace Models;

use PDO;

class Model_user
{
    private $dbh;

    // Konstruktor: Membuat koneksi ke database menggunakan PDO
    public function __construct()
    {
        $this->dbh = new \PDO('mysql:host=localhost;dbname=db_cake', 'root', 'root');
    }

    // Mengambil data pengguna berdasarkan ID
    public function getUserById($id)
    {
        $stmt = $this->dbh->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Mengembalikan hasil sebagai array asosiatif
    }

    // Mengambil semua data pengguna
    public function lihat_user()
    {
        $stmt = $this->dbh->prepare("SELECT * FROM users");
        $stmt->execute();
        return $stmt; // Mengembalikan objek statement untuk digunakan lebih lanjut
    }

    // Menghapus data pengguna berdasarkan ID
    public function deleteData($id)
    {
        $stmt = $this->dbh->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]); // Menghapus pengguna berdasarkan ID
    }

    // Menyimpan pengguna baru dengan username dan password
    function simpanUser($username, $password)
    {
        // Meng-hash password untuk keamanan
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->dbh->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->execute([$username, $hashedPassword]); // Menyimpan data pengguna ke database
    }

    // Mengupdate data pengguna (username dan password)
    public function userUpdate($id, $username, $password = null)
    {
        if ($password) {
            // Jika password baru diberikan, hash dan perbarui
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $rs = $this->dbh->prepare("UPDATE users SET username = ?, password = ? WHERE id = ?");
            $rs->execute([$username, $hashedPassword, $id]);
        } else {
            // Jika password tidak diberikan, hanya update username
            $rs = $this->dbh->prepare("UPDATE users SET username = ? WHERE id = ?");
            $rs->execute([$username, $id]);
        }
    }

    // Mengambil data pengguna berdasarkan username
    public function getUserByUsername($username)
    {
        $stmt = $this->dbh->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Mengembalikan hasil sebagai array asosiatif
    }
}
