<?php
session_start();
// Cek apakah user sudah login
if(!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

 $pageTitle = "Riwayat Peminjaman";
require_once "inc/Borrow.php";

 $borrow = new Borrow();
 $user = $_SESSION['user'];
 $user_role = $user['Role'];

// Logika untuk menentukan query berdasarkan role
if ($user_role === 'admin' || $user_role === 'petugas') {
    // Admin & Petugas lihat semua data
    $pinjaman_result = $borrow->semua();
} else {
    // User biasa hanya lihat datanya sendiri
    $pinjaman_result = $borrow->riwayatByUser($user['UserID']);
}

include 'inc/header.php';
?>

<div class="hero">
    <h1>Riwayat Peminjaman <?= $user_role === 'user' ? 'Saya' : '' ?></h1>
    <p>Lihat semua buku yang pernah <?= $user_role === 'user' ? 'Anda' : 'pengguna' ?> pinjam atau kelola.</p>
</div>

<section class="peminjaman-list">
    <h2>Daftar Peminjaman</h2>
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Judul Buku</th>
                <?php if($user_role === 'admin' || $user_role === 'petugas'): ?>
                    <th>Peminjam</th>
                <?php endif; ?>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if($pinjaman_result && mysqli_num_rows($pinjaman_result) > 0): 
                while($row = mysqli_fetch_assoc($pinjaman_result)): 
            ?>
                <tr>
                    <td><?= $row['PeminjamanID'] ?></td>
                    <td><?= htmlspecialchars($row['Judul']) ?></td>
                    <?php if($user_role === 'admin' || $user_role === 'petugas'): ?>
                        <td><?= htmlspecialchars($row['NamaLengkap']) ?></td>
                    <?php endif; ?>
                    <td><?= $row['TanggalPeminjaman'] ?></td>
                    <td><?= $row['TanggalPengembalian'] ?? '-' ?></td>
                    <td>
                        <span class="status <?= $row['StatusPeminjaman'] == 'Dipinjam' ? 'dipinjam' : 'dikembalikan' ?>" style="padding: 4px 8px; border-radius: 12px; font-size: 0.8rem; color: white; background: <?= $row['StatusPeminjaman'] == 'Dipinjam' ? 'var(--accent-color)' : 'var(--secondary-color)' ?>;">
                            <?= $row['StatusPeminjaman'] ?>
                        </span>
                    </td>
                </tr>
            <?php endwhile; else: ?>
                <tr>
                    <td colspan="<?= $user_role === 'admin' || $user_role === 'petugas' ? '6' : '5' ?>" style="text-align:center;">Belum ada data peminjaman.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>

<?php include 'inc/footer.php'; ?>