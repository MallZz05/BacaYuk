<?php
session_start();
if(!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

 $user_role = $_SESSION['user']['Role'];
if($user_role !== 'admin' && $user_role !== 'petugas') {
    $_SESSION['error'] = "Anda tidak memiliki izin untuk mengakses halaman tersebut.";
    header("Location: dashboard.php");
    exit;
}

require_once "inc/Borrow.php";
require_once "inc/Book.php";
 $pageTitle = "Peminjaman";

 $borrow = new Borrow();
 $book = new Book();
 $message = '';

// --- LOGIKA UNTUK HAPUS DAN PAKSA KEMBALI ---
if(isset($_POST['hapus_peminjaman'])){
    if($borrow->hapusPeminjaman($_POST['peminjamanID'])){
        $message = "Data peminjaman berhasil dihapus!";
    } else {
        $message = "Gagal menghapus data peminjaman!";
    }
}

if(isset($_POST['paksa_kembalikan'])){
    if($borrow->paksaKembalikan($_POST['peminjamanID'])){
        $message = "Buku berhasil dipaksa dikembalikan!";
    } else {
        $message = "Gagal memaksa pengembalian buku!";
    }
}

// --- LOGIKA KEMBALIKAN BUKU ---
if(isset($_POST['kembalikan'])){
    if($borrow->kembalikan($_POST['peminjamanID'])){
        $message = "Buku berhasil dikembalikan!";
    } else {
        $message = "Gagal mengembalikan buku!";
    }
}

 $pinjaman_result = $borrow->semua();
 $books_list = $book->all();

include 'inc/header.php';
?>

<div class="hero">
    <h1>Kelola Peminjaman</h1>
    <p>Atur peminjaman dan pengembalian buku perpustakaan</p>
</div>

<?php if($message): ?>
    <div class="alert alert-<?= strpos($message, 'Gagal') !== false ? 'danger' : 'success' ?>">
        <?= $message ?>
    </div>
<?php endif; ?>

<section class="peminjaman-list">
    <h2>Daftar Peminjaman</h2>
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Judul Buku</th>
                <th>Peminjam</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
                <th>Aksi</th>
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
                    <td><?= htmlspecialchars($row['NamaLengkap']) ?></td>
                    <td><?= $row['TanggalPeminjaman'] ?></td>
                    <td><?= $row['TanggalPengembalian'] ?? '-' ?></td>
                    <td>
                        <span class="status <?= $row['StatusPeminjaman'] == 'Dipinjam' ? 'dipinjam' : 'dikembalikan' ?>" style="padding: 4px 8px; border-radius: 12px; font-size: 0.8rem; color: white; background: <?= $row['StatusPeminjaman'] == 'Dipinjam' ? 'var(--accent-color)' : 'var(--secondary-color)' ?>;">
                            <?= $row['StatusPeminjaman'] ?>
                        </span>
                    </td>
                    <td>
                        <?php if($row['StatusPeminjaman'] == 'Dipinjam'): ?>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="peminjamanID" value="<?= $row['PeminjamanID'] ?>">
                                <button type="submit" name="kembalikan" class="btn-small">Kembalikan</button>
                            </form>
                        <?php endif; ?>

                        <!-- --- TOMBOL KHUSUS ADMIN --- -->
                        <?php if($user_role == 'admin'): ?>
                            <form method="POST" style="display:inline; margin-left: 5px;">
                                <input type="hidden" name="peminjamanID" value="<?= $row['PeminjamanID'] ?>">
                                <button type="submit" name="paksa_kembalikan" class="btn-small" style="background-color: var(--secondary-color);">Paksa Kembali</button>
                            </form>
                            <form method="POST" style="display:inline; margin-left: 5px;">
                                <input type="hidden" name="peminjamanID" value="<?= $row['PeminjamanID'] ?>">
                                <button type="submit" name="hapus_peminjaman" class="btn-small btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">Hapus</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; else: ?>
                <tr>
                    <td colspan="7" style="text-align:center;">Belum ada data peminjaman</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>

<?php include 'inc/footer.php'; ?>