<?php
require_once "Database.php";

class Borrow {
    private $conn;

    public function __construct(){
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function pinjam($userID, $bukuID){
        // Cek role user - hanya user biasa yang bisa meminjam
        $stmt = mysqli_prepare($this->conn, "SELECT Role FROM user WHERE UserID=?");
        mysqli_stmt_bind_param($stmt, "i", $userID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);
        
        if(!$user || $user['Role'] !== 'user') {
            return false; // Admin atau petugas tidak bisa meminjam
        }
        
        $tanggal = date("Y-m-d");
        $sql = "INSERT INTO peminjaman (UserID, BukuID, TanggalPeminjaman, StatusPeminjaman) VALUES (?, ?, ?, 'Dipinjam')";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "iis", $userID, $bukuID, $tanggal);
        return mysqli_stmt_execute($stmt);
    }

    public function kembalikan($peminjamanID){
        $tanggal = date("Y-m-d");
        $sql = "UPDATE peminjaman SET TanggalPengembalian=?, StatusPeminjaman='Dikembalikan' WHERE PeminjamanID=?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "si", $tanggal, $peminjamanID);
        return mysqli_stmt_execute($stmt);
    }

    public function semua(){
        $sql = "SELECT p.*, b.Judul, u.NamaLengkap 
                FROM peminjaman p 
                JOIN buku b ON p.BukuID = b.BukuID 
                JOIN user u ON p.UserID = u.UserID 
                ORDER BY PeminjamanID DESC";
        $result = mysqli_query($this->conn, $sql);
        return $result;
    }

    public function riwayatByUser($userID) {
        $sql = "SELECT p.*, b.Judul, u.NamaLengkap 
                FROM peminjaman p 
                JOIN buku b ON p.BukuID = b.BukuID 
                JOIN user u ON p.UserID = u.UserID 
                WHERE p.UserID = ? 
                ORDER BY PeminjamanID DESC";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $userID);
        mysqli_stmt_execute($stmt);
        return $stmt->get_result();
    }

    public function hapusPeminjaman($peminjamanID) {
        $sql = "DELETE FROM peminjaman WHERE PeminjamanID = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $peminjamanID);
        return mysqli_stmt_execute($stmt);
    }

    public function paksaKembalikan($peminjamanID) {
        $tanggal = date("Y-m-d");
        $sql = "UPDATE peminjaman SET TanggalPengembalian=?, StatusPeminjaman='Dikembalikan' WHERE PeminjamanID=?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "si", $tanggal, $peminjamanID);
        return mysqli_stmt_execute($stmt);
    }
}
?>