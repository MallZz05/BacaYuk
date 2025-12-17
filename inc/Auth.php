<?php
require_once "Database.php";
class Auth {
    private $conn;
    public function __construct(){
        $db = new Database();
        $this->conn = $db->connect();
    }
    public function register($username, $password, $email, $nama, $role = 'user'){
        $pass = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO user (Username, Password, Email, NamaLengkap, Role) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssss", $username, $pass, $email, $nama, $role);
        return mysqli_stmt_execute($stmt);
    }
    public function login($username, $password){
        $sql = "SELECT * FROM user WHERE Username=?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);
        if(!$user) return false;
        if(password_verify($password, $user['Password'])){
            return $user;
        }
        return false;
    }
    // Fungsi baru untuk admin menambahkan user
    public function addUser($username, $password, $email, $nama, $role = 'user'){
        return $this->register($username, $password, $email, $nama, $role);
    }
    // Fungsi untuk mendapatkan semua user (untuk admin)
    public function getAllUsers(){
        $sql = "SELECT UserID, Username, Email, NamaLengkap, Role FROM user ORDER BY Username ASC";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}
?>