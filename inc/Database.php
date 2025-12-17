<?php
class Database {
    private $host = "localhost";
    private $db_name = "bacayuk"; // --> SUDAH DIPERBAIKI SESUAI NAMA DB ANDA
    private $username = "root";
    private $password = "";
    public $conn;

    public function connect(){
        $this->conn = null;
        $this->conn = mysqli_connect($this->host, $this->username, $this->password, $this->db_name);
        if (!$this->conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        return $this->conn;
    }
}
?>