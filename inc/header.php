<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) . ' - ' : '' ?>Perpursin</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="site-wrapper">
        <div class="bg-animation">
            <div class="gradient-sphere sphere-1"></div>
            <div class="gradient-sphere sphere-2"></div>
            <div class="gradient-sphere sphere-3"></div>
        </div>
        <header class="main-header">
            <div class="container header-content">
                <a href="index.php" class="logo"><i class="fas fa-book-open"></i><span>BacaYuk!</span></a>
                
                <nav class="main-nav">
                    <?php if(isset($_SESSION['user'])): $user_role = $_SESSION['user']['Role']; ?>
                        <a href="dashboard.php"><i class="fas fa-home"></i> <span>Dashboard</span></a>
                        <?php if ($user_role == 'admin' || $user_role == 'petugas'): ?>
                            <a href="kelola_buku.php"><i class="fas fa-book"></i> <span>Kelola Buku</span></a>
                            <a href="kelola_ulasan.php"><i class="fas fa-comments"></i> <span>Kelola Ulasan</span></a>
                            <a href="peminjaman.php"><i class="fas fa-hand-holding"></i> <span>Peminjaman</span></a>
                            <?php if ($user_role == 'admin'): ?>
                                <a href="kelola_user.php"><i class="fas fa-users"></i> <span>Kelola User</span></a>
                            <?php endif; ?>
                        <?php endif; ?>
                        <a href="index.php"><i class="fas fa-book-open"></i> <span>Katalog</span></a>
                        <a href="riwayat_peminjaman.php"><i class="fas fa-history"></i>Riwayat</a>
                        <a href="logout.php" class="btn-logout"><i class="fas fa-sign-out-alt"></i>Logout</a>
                    <?php else: ?>
                        <a href="index.php"><i class="fas fa-home"></i> <span>Beranda</span></a>
                        <a href="login.php"><i class="fas fa-sign-in-alt"></i> <span>Login</span></a>
                        <a href="register.php"><i class="fas fa-user-plus"></i> <span>Register</span></a>
                    <?php endif; ?>
                </nav>
            </div>
        </header>
        <main class="main-content">