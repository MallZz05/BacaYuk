<?php 
require_once "inc/Auth.php"; 
 $pageTitle = "Register"; 
 $auth = new Auth(); 
 $error = '';
if(isset($_POST['register'])){
    try { 
        if($auth->register($_POST['username'], $_POST['password'], $_POST['email'], $_POST['nama'])){ 
            header("Location: login.php"); 
            exit; 
        } 
    }
    catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) { 
            $error = "Registrasi gagal! Username atau Email sudah digunakan."; 
        }
        else { 
            $error = "Registrasi gagal! Terjadi kesalahan."; 
        }
    }
}
include 'inc/header.php'; 
?>
<section class="form-section">
    <h2>Daftar Akun Baru</h2>
    <?php if(isset($error) && $error !== ''): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    <form method="POST" class="form-card">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>
        </div>
        <div class="form-group">
            <label for="nama">Nama Lengkap</label>
            <input type="text" name="nama" id="nama" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
        </div>
        <button type="submit" name="register" class="btn">Daftar</button>
    </form>
    <p style="margin-top: 15px;">Sudah punya akun? <a href="login.php">Login di sini</a></p>
</section>
<?php include 'inc/footer.php'; ?>