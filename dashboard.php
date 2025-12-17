<?php 
session_start(); 
if(!isset($_SESSION['user'])) header("Location: login.php"); 
$user = $_SESSION['user']; 
$pageTitle = "Dashboard"; 
include 'inc/header.php'; 
?>

<div class="hero">
    <h1>Selamat datang, <?= htmlspecialchars($user['NamaLengkap']) ?>!</h1>
    <p>Di dashboard aplikasi BacaYuk!</p>
</div>
<!-- ======================== -->
<!-- 🔵 MENU UTAMA ROLE BASED -->
<!-- ======================== -->

<section class="dashboard-links">
    <h2>Menu Utama</h2>
    <div class="books-container">

        <?php if($user['Role'] == 'admin'): ?>

            <a href="kelola_buku.php" class="book-card">
                <i class="fas fa-book" style="font-size: 3rem; color: var(--primary-color);"></i>
                <div class="judul" style="text-align:center;">Kelola Buku</div>
                <div style="text-align:center; color: var(--text-secondary);">Tambah, edit, atau hapus data buku</div>
            </a>

            <a href="kelola_user.php" class="book-card">
                <i class="fas fa-users" style="font-size: 3rem;"></i>
                <div class="judul" style="text-align:center;">Kelola User</div>
                <div style="text-align:center; color: var(--text-secondary);">Kelola akun pengguna</div>
            </a>

            <a href="kelola_ulasan.php" class="book-card">
                <i class="fas fa-comments" style="font-size: 3rem;"></i>
                <div class="judul" style="text-align:center;">Kelola Ulasan</div>
                <div style="text-align:center; color: var(--text-secondary);">Lihat semua ulasan</div>
            </a>

            <a href="peminjaman.php" class="book-card">
                <i class="fas fa-hand-holding" style="font-size: 3rem;"></i>
                <div class="judul" style="text-align:center;">Peminjaman</div>
                <div style="text-align:center; color: var(--text-secondary);">Kelola peminjaman</div>
            </a>

        <?php elseif($user['Role'] == 'petugas'): ?>

            <a href="kelola_buku.php" class="book-card">
                <i class="fas fa-book" style="font-size: 3rem;"></i>
                <div class="judul" style="text-align:center;">Kelola Buku</div>
                <div style="text-align:center;">Tambah, edit, atau hapus data buku</div>
            </a>

            <a href="kelola_ulasan.php" class="book-card">
                <i class="fas fa-comments" style="font-size: 3rem;"></i>
                <div class="judul" style="text-align:center;">Kelola Ulasan</div>
                <div style="text-align:center;">Lihat ulasan</div>
            </a>

            <a href="peminjaman.php" class="book-card">
                <i class="fas fa-hand-holding" style="font-size: 3rem;"></i>
                <div class="judul" style="text-align:center;">Peminjaman</div>
                <div style="text-align:center;">Kelola peminjaman</div>
            </a>

        <?php else: ?>

        <?php endif; ?>

    </div>
</section>

<?php include 'inc/footer.php'; ?>