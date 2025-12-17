<?php
session_start();
if(!isset($_SESSION['user'])) { header("Location: login.php"); exit; }
 $user_role = $_SESSION['user']['Role'];
if($user_role !== 'admin' && $user_role !== 'petugas') { $_SESSION['error'] = "Anda tidak memiliki izin."; header("Location: dashboard.php"); exit; }

require_once "inc/Book.php"; $pageTitle = "Kelola Buku"; $book = new Book(); $message = '';
if(isset($_POST['add'])){
    $gambar = isset($_FILES['gambar']['name']) ? $_FILES['gambar']['name'] : 'default.jpg';
    $halaman = isset($_POST['halaman']) ? (int)$_POST['halaman'] : 0;
    $konten = isset($_POST['konten']) ? $_POST['konten'] : '';
    
    // Upload gambar jika ada
    if($gambar !== 'default.jpg' && $_FILES['gambar']['error'] === 0) {
        $target_dir = "assets/css/img/buku/";
        $target_file = $target_dir . basename($gambar);
        move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file);
    }
    
    if($book->add($_POST['judul'], $_POST['penulis'], $_POST['penerbit'], $_POST['tahun'], $gambar, $halaman, $konten)){ 
        $message = "Buku berhasil ditambahkan!"; 
    }
    else { 
        $message = "Gagal menambahkan buku!"; 
    }
}
 $books = $book->all(); include 'inc/header.php';
?>
<section class="add-book-section"><h2>Tambah Buku Baru</h2>
    <?php if($message): ?><div class="alert alert-success"><?= $message ?></div><?php endif; ?>
    <form method="POST" class="form-card" enctype="multipart/form-data">
        <div class="form-group"><label for="judul">Judul Buku</label><input type="text" name="judul" id="judul" required></div>
        <div class="form-group"><label for="penulis">Penulis</label><input type="text" name="penulis" id="penulis" required></div>
        <div class="form-group"><label for="penerbit">Penerbit</label><input type="text" name="penerbit" id="penerbit" required></div>
        <div class="form-group"><label for="tahun">Tahun Terbit</label><input type="number" name="tahun" id="tahun" required></div>
        <div class="form-group"><label for="halaman">Jumlah Halaman</label><input type="number" name="halaman" id="halaman"></div>
        <div class="form-group"><label for="gambar">Gambar Cover</label><input type="file" name="gambar" id="gambar" accept="image/*"></div>
        <div class="form-group"><label for="konten">Sinopsis/Isi Buku</label><textarea name="konten" id="konten" rows="5"></textarea></div>
        <button type="submit" name="add" class="btn">Tambah Buku</button>
    </form>
</section>
<section class="book-list"><h2>Daftar Buku</h2><div class="books-container">
    <?php if(!empty($books)): foreach($books as $buku): ?>
        <a href="index.php?id=<?= $buku['BukuID']; ?>" class="book-card">
            <img src="assets/css/img/buku/<?= htmlspecialchars($buku['Gambar']); ?>" alt="<?= htmlspecialchars($buku['Judul']); ?>" class="book-cover">
            <div class="book-card-content">
                <div class="judul"><?= htmlspecialchars($buku['Judul']); ?></div>
                <div class="info">Penulis: <?= htmlspecialchars($buku['Penulis']); ?></div>
                <div class="info">Penerbit: <?= htmlspecialchars($buku['Penerbit']); ?></div>
                <div class="info">Tahun: <?= htmlspecialchars($buku['TahunTerbit']); ?></div>
                <div class="rating-display">
                    <div class="rating-stars">
                        <?php 
                        $avgRating = $buku['AvgRating'] ? round($buku['AvgRating'], 1) : 0;
                        for($i = 1; $i <= 5; $i++): ?>
                            <i class="fas fa-star <?= $i <= $avgRating ? '' : 'far' ?>"></i>
                        <?php endfor; ?>
                    </div>
                    <span class="rating-count"><?= $avgRating ?>/5 (<?= $buku['ReviewCount'] ?> ulasan)</span>
                </div>
            </div>
        </a>
    <?php endforeach; else: ?><p style='text-align:center; grid-column: 1 / -1;'>Belum ada buku yang tersedia.</p><?php endif; ?>
</div></section>
<?php include 'inc/footer.php'; ?>