<?php 
session_start(); 
require_once "inc/Auth.php"; 
 $pageTitle = "Login"; 
 $auth = new Auth();
if(isset($_POST['login'])){
    $user = $auth->login($_POST['username'], $_POST['password']);
    if($user){ 
        $_SESSION['user'] = $user; 
        header("Location: dashboard.php"); 
        exit; 
    }
    else { 
        $error = "Login gagal! Username atau password salah."; 
    }
}
include 'inc/header.php'; 
?>
<section class="form-section">
    <h2>Login ke BacaYuk!</h2>
    <?php if(isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    <form method="POST" class="form-card">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
        </div>
        <button type="submit" name="login" class="btn">Login</button>
    </form>
    <p style="margin-top: 15px;">Belum punya akun? <a href="register.php">Daftar di sini</a></p>
</section>
<?php include 'inc/footer.php'; ?>