<?php
require_once "Database.php";
class Book {
    private $conn;
    public function __construct(){
        $db = new Database();
        $this->conn = $db->connect();
    }
    public function all(){
        $sql = "SELECT b.*, AVG(u.Rating) as AvgRating, COUNT(u.UlasanID) as ReviewCount 
                FROM buku b 
                LEFT JOIN ulasanbuku u ON b.BukuID = u.BukuID 
                GROUP BY b.BukuID 
                ORDER BY b.Judul ASC";
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    public function find($id){
        $stmt = mysqli_prepare($this->conn, "SELECT b.*, AVG(u.Rating) as AvgRating, COUNT(u.UlasanID) as ReviewCount 
                                            FROM buku b 
                                            LEFT JOIN ulasanbuku u ON b.BukuID = u.BukuID 
                                            WHERE b.BukuID=? 
                                            GROUP BY b.BukuID");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_assoc($result);
    }
    public function add($judul, $penulis, $penerbit, $tahun, $gambar = 'default.jpg', $halaman = 0, $konten = ''){
        $sql = "INSERT INTO buku (Judul, Penulis, Penerbit, TahunTerbit, Gambar, Halaman, Konten) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssisis", $judul, $penulis, $penerbit, $tahun, $gambar, $halaman, $konten);
        return mysqli_stmt_execute($stmt);
    }
    // Fungsi untuk mendapatkan rating buku
    public function getBookRating($id){
        $stmt = mysqli_prepare($this->conn, "SELECT AVG(Rating) as AvgRating, COUNT(UlasanID) as ReviewCount FROM ulasanbuku WHERE BukuID=?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_assoc($result);
    }
}
?>