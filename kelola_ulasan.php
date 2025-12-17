<?php
session_start();
// Cek apakah user sudah login
if(!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

// Cek role user (hanya admin dan petugas yang boleh akses)
 $user_role = $_SESSION['user']['Role'];
if($user_role !== 'admin' && $user_role !== 'petugas') {
    $_SESSION['error'] = "Anda tidak memiliki izin untuk mengakses halaman tersebut.";
    header("Location: dashboard.php");
    exit;
}

 $pageTitle = "Kelola Ulasan";

// Koneksi ke database
require_once "inc/Database.php";
 $db = new Database();
 $conn = $db->connect();

// Query untuk mengambil semua ulasan beserta info user dan buku
 $stmt = $conn->prepare("
    SELECT u.UlasanID, u.Ulasan, u.Rating, u.Tanggal, 
           us.Username, b.Judul AS JudulBuku
    FROM ulasanbuku u
    JOIN user us ON u.UserID = us.UserID
    JOIN buku b ON u.BukuID = b.BukuID
    ORDER BY u.Tanggal DESC
");
 $stmt->execute();
 $ulasanList = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

include 'inc/header.php';
?>

<div class="hero">
    <h1>Kelola Ulasan</h1>
    <p>Lihat semua ulasan yang diberikan oleh pengguna</p>
</div>

<section class="ulasan-list-section">
    <h2>📝 Semua Ulasan Pembaca</h2>
    
    <?php if (!empty($ulasanList)): ?>
        <div class="reviews-container">
            <?php foreach ($ulasanList as $ulasan): ?>
                <div class="review-card">
                    <div class="review-header">
                        <div>
                            <strong><?= htmlspecialchars($ulasan['Username']) ?></strong>
                            <span class="review-book-title">mengulas "<i><?= htmlspecialchars($ulasan['JudulBuku']) ?></i>"</span>
                        </div>
                        <div class="review-meta">
                            <span class="rating">⭐ <?= $ulasan['Rating'] ?>/5</span>
                            <span class="date"><?= date('d M Y', strtotime($ulasan['Tanggal'])) ?></span>
                        </div>
                    </div>
                    <div class="review-content">
                        <p><?= nl2br(htmlspecialchars($ulasan['Ulasan'])) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p style="text-align: center; color: var(--text-secondary); padding: 2rem;">Belum ada ulasan yang ditulis oleh pengguna.</p>
    <?php endif; ?>
</section>

<?php include 'inc/footer.php'; ?>  