<?php
session_start();
require_once "inc/Database.php";
 $pageTitle = "Katalog Buku";

 $db = new Database();
 $conn = $db->connect();
 $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// --- LOGIKA PEMINJAMAN LANGSUNG UNTUK USER ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pinjam_buku_dari_detail']) && isset($_SESSION['user'])) {
    $user_role = $_SESSION['user']['Role'];
    
    // Hanya user biasa yang bisa meminjam
    if ($user_role === 'user') {
        require_once "inc/Borrow.php";
        $borrow = new Borrow();
        $userID = $_SESSION['user']['UserID'];
        $bukuID = $_POST['bukuID'];

        if ($borrow->pinjam($userID, $bukuID)) {
            $message = "Buku berhasil dipinjam!";
        } else {
            $message = "Gagal meminjam buku! Mungkin buku ini sudah Anda pinjam.";
        }
        echo "<script>alert('$message'); window.location='index.php?id=$bukuID';</script>";
        exit;
    }
}

// --- LOGIKA ULASAN ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user']) && isset($_POST['ulasan']) && $id > 0) {
    // Cek role user - hanya user biasa yang bisa memberikan ulasan
    $user_role = $_SESSION['user']['Role'];
    if($user_role !== 'user') {
        echo "<script>alert('Hanya user biasa yang bisa memberikan ulasan!');window.location='index.php?id=$id';</script>";
        exit;
    }
    
    $ulasan = $_POST['ulasan'];
    $rating = $_POST['rating'];
    $userID = $_SESSION['user']['UserID'];
    
    $stmt = $conn->prepare("INSERT INTO ulasanbuku (UserID, BukuID, Ulasan, Rating) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iisi", $userID, $id, $ulasan, $rating);
    
    if($stmt->execute()){
        echo "<script>alert('Ulasan berhasil dikirim!');window.location='index.php?id=$id';</script>";
    } else {
        echo "<script>alert('Gagal mengirim ulasan.');</script>";
    }
    exit;
}

include 'inc/header.php';
?>

<?php if ($id === 0): ?>
    <div class="hero">
        <h1>Selamat Datang di BacaYuk!</h1>
        <p>Menjelajah Dunia Melalui Membaca</p>
    </div>

    <section class="book-section">
        <h2>📚 Katalog Buku</h2>
        <div class="books-container">
        <?php
        $result = mysqli_query($conn, "SELECT b.*, AVG(u.Rating) as AvgRating, COUNT(u.UlasanID) as ReviewCount 
                                     FROM buku b 
                                     LEFT JOIN ulasanbuku u ON b.BukuID = u.BukuID 
                                     GROUP BY b.BukuID 
                                     ORDER BY b.Judul ASC");
        if ($result && mysqli_num_rows($result) > 0):
            while ($buku = mysqli_fetch_assoc($result)):
                $avgRating = $buku['AvgRating'] ? round($buku['AvgRating'], 1) : 0;
                $reviewCount = $buku['ReviewCount'] ? $buku['ReviewCount'] : 0;
        ?>
            <a href="index.php?id=<?= $buku['BukuID']; ?>" class="book-card">
                <img src="assets/css/img/buku/<?= htmlspecialchars($buku['Gambar']); ?>" alt="<?= htmlspecialchars($buku['Judul']); ?>" class="book-cover">
                <div class="book-card-content">
                    <div class="judul"><?= htmlspecialchars($buku['Judul']); ?></div>
                    <div class="info">Penulis: <?= htmlspecialchars($buku['Penulis']); ?></div>
                    <div class="info">Penerbit: <?= htmlspecialchars($buku['Penerbit']); ?></div>
                    <div class="info">Tahun: <?= htmlspecialchars($buku['TahunTerbit']); ?></div>
                    <div class="rating-display">
                        <div class="rating-stars">
                            <?php for($i = 1; $i <= 5; $i++): ?>
                                <i class="fas fa-star <?= $i <= $avgRating ? '' : 'far' ?>"></i>
                            <?php endfor; ?>
                        </div>
                        <span class="rating-count"><?= $avgRating ?>/5 (<?= $reviewCount ?> ulasan)</span>
                    </div>
                </div>
            </a>
        <?php
            endwhile;
        else:
            echo "<p style='text-align:center; grid-column: 1/-1;'>Belum ada buku yang tersedia.</p>";
        endif;
        ?>
        </div>
    </section>

<?php else: ?>
    <?php
    $stmt = $conn->prepare("SELECT b.*, AVG(u.Rating) as AvgRating, COUNT(u.UlasanID) as ReviewCount 
                           FROM buku b 
                           LEFT JOIN ulasanbuku u ON b.BukuID = u.BukuID 
                           WHERE b.BukuID = ? 
                           GROUP BY b.BukuID");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = mysqli_fetch_assoc($result);

    if ($data):
        $avgRating = $data['AvgRating'] ? round($data['AvgRating'], 1) : 0;
        $reviewCount = $data['ReviewCount'] ? $data['ReviewCount'] : 0;
    ?>
    <section class="book-detail-section">
        <div class="book-detail" style="display: grid; grid-template-columns: 1fr 2fr; gap: 2rem; align-items: start;">
            <img src="assets/css/img/buku/<?= htmlspecialchars($data['Gambar']); ?>" alt="<?= htmlspecialchars($data['Judul']); ?>" class="book-cover-detail" style="width:100%; border-radius: var(--border-radius);">
            <div class="book-info">
                <h2><?= htmlspecialchars($data['Judul']); ?></h2>
                <p><strong>Penulis:</strong> <?= htmlspecialchars($data['Penulis']); ?></p>
                <p><strong>Penerbit:</strong> <?= htmlspecialchars($data['Penerbit']); ?></p>
                <p><strong>Tahun Terbit:</strong> <?= htmlspecialchars($data['TahunTerbit']); ?></p>
                <p><strong>Jumlah Halaman:</strong> <?= htmlspecialchars($data['Halaman']); ?> halaman</p>
                
                <div class="rating-display" style="margin: 1rem 0;">
                    <div class="rating-stars" style="font-size: 1.2rem;">
                        <?php for($i = 1; $i <= 5; $i++): ?>
                            <i class="fas fa-star <?= $i <= $avgRating ? '' : 'far' ?>"></i>
                        <?php endfor; ?>
                    </div>
                    <span class="rating-count"><?= $avgRating ?>/5 (<?= $reviewCount ?> ulasan)</span>
                </div>
                
                <div class="book-full-content">
                    <h4>Isi Buku:</h4>
                    <div class="content-box" style="background: var(--background-color); border: 1px solid var(--border-color); border-radius: 12px; padding: 1.5rem; margin-top: 1rem; max-height: 300px; overflow-y: auto;">
                        <?= $data['Konten']; ?>
                    </div>
                </div>
                
                <?php if(isset($_SESSION['user'])): 
                    $user_role = $_SESSION['user']['Role'];
                    // Hanya user biasa yang bisa meminjam buku
                    if($user_role === 'user'): ?>
                    <div class="book-actions" style="margin-top: 1.5rem;">
                        <!-- FORM PEMINJAMAN LANGSUNG -->
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="bukuID" value="<?= $data['BukuID'] ?>">
                            <input type="hidden" name="pinjam_buku_dari_detail" value="1">
                            <button type="submit" class="btn">Pinjam Buku</button>
                        </form>
                    </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="reviews-section" style="margin-top: 3rem;">
            <h3>💬 Ulasan Pembaca</h3>
            <?php
            $stmt = $conn->prepare("SELECT u.Ulasan, u.Rating, u.Tanggal, us.Username FROM ulasanbuku u JOIN user us ON u.UserID = us.UserID WHERE u.BukuID = ? ORDER BY u.Tanggal DESC");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $hasilUlasan = $stmt->get_result();

            if ($hasilUlasan && mysqli_num_rows($hasilUlasan) > 0):
            ?>
                <div class="reviews-container">
                    <?php while($row = mysqli_fetch_assoc($hasilUlasan)): ?>
                        <div class="review-card">
                            <div class="review-header">
                                <div>
                                    <strong><?= htmlspecialchars($row['Username']); ?></strong>
                                </div>
                                <div class="review-meta">
                                    <span class="rating">⭐ <?= $row['Rating']; ?>/5</span>
                                    <span class="date"><?= date('d M Y', strtotime($row['Tanggal'])) ?></span>
                                </div>
                            </div>
                            <div class="review-content">
                                <p><?= nl2br(htmlspecialchars($row['Ulasan'])); ?></p>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p>Belum ada ulasan untuk buku ini. Jadilah yang pertama!</p>
            <?php endif; ?>

            <?php if(isset($_SESSION['user'])): 
                $user_role = $_SESSION['user']['Role'];
                // Hanya user biasa yang bisa memberikan ulasan
                if($user_role === 'user'): ?>
                <div class="add-review" style="margin-top: 2rem;">
                    <h3>Tulis Ulasan Anda</h3>
                    <form method="POST">
                        <div class="form-group">
                            <label for="rating">Rating:</label>
                            <select name="rating" id="rating" required>
                                <option value="5">5 - Sangat Bagus</option>
                                <option value="4">4 - Bagus</option>
                                <option value="3">3 - Cukup</option>
                                <option value="2">2 - Kurang</option>
                                <option value="1">1 - Buruk</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="ulasan">Ulasan:</label>
                            <textarea name="ulasan" id="ulasan" rows="4" placeholder="Tulis ulasan di sini..." required></textarea>
                        </div>
                        <button type="submit" class="btn">Kirim Ulasan</button>
                    </form>
                </div>
                <?php else: ?>
                    <p style="margin-top: 2rem;">Hanya user biasa yang bisa memberikan ulasan.</p>
                <?php endif; ?>
            <?php else: ?>
                <p><a href="login.php">Login</a> untuk menulis ulasan.</p>
            <?php endif; ?>
        </div>
        
        <div class="back-button" style="margin-top: 2rem; text-align: center;">
            <a href="index.php" class="btn"><i class="fas fa-arrow-left"></i> Kembali ke Katalog</a>
        </div>
    </section>
    <?php else: ?>
        <section class="not-found">
            <p style="text-align:center;">Buku tidak ditemukan.</p>
            <div class="back-button" style="margin-top: 2rem; text-align: center;">
                <a href="index.php" class="btn"><i class="fas fa-arrow-left"></i> Kembali ke Katalog</a>
            </div>
        </section>
    <?php endif; ?>
<?php endif; ?>

<?php include 'inc/footer.php'; ?>