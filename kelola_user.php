<?php
session_start();
if(!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

// Cek role user (hanya admin yang boleh akses)
 $user_role = $_SESSION['user']['Role'];
if($user_role !== 'admin') {
    $_SESSION['error'] = "Anda tidak memiliki izin untuk mengakses halaman tersebut.";
    header("Location: dashboard.php");
    exit;
}

 $pageTitle = "Kelola User";
require_once "inc/Auth.php";
 $auth = new Auth();
 $message = '';

// Proses tambah user
if(isset($_POST['add_user'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $nama = $_POST['nama'];
    $role = $_POST['role'];
    
    if($auth->addUser($username, $password, $email, $nama, $role)){
        $message = "User berhasil ditambahkan!";
    } else {
        $message = "Gagal menambahkan user!";
    }
}

 $users = $auth->getAllUsers();
include 'inc/header.php';
?>

<div class="hero">
    <h1>Kelola User</h1>
    <p>Tambahkan dan kelola akun pengguna sistem</p>
</div>

<section class="add-user-section">
    <h2>Tambah User Baru</h2>
    <?php if($message): ?>
        <div class="alert alert-success"><?= $message ?></div>
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
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>
        </div>
        <div class="form-group">
            <label for="nama">Nama Lengkap</label>
            <input type="text" name="nama" id="nama" required>
        </div>
        <div class="form-group">
            <label for="role">Role</label>
            <select name="role" id="role" required>
                <option value="user">User</option>
                <option value="petugas">Petugas</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <button type="submit" name="add_user" class="btn">Tambah User</button>
    </form>
</section>

<section class="user-list">
    <h2>Daftar User</h2>
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Nama Lengkap</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($users)): foreach($users as $user): ?>
                <tr>
                    <td><?= $user['UserID'] ?></td>
                    <td><?= htmlspecialchars($user['Username']) ?></td>
                    <td><?= htmlspecialchars($user['Email']) ?></td>
                    <td><?= htmlspecialchars($user['NamaLengkap']) ?></td>
                    <td>
                        <span class="status" style="padding: 4px 8px; border-radius: 12px; font-size: 0.8rem; color: white; background: 
                            <?= $user['Role'] == 'admin' ? 'var(--primary-color)' : 
                               ($user['Role'] == 'petugas' ? 'var(--secondary-color)' : 'var(--accent-color)') ?>;">
                            <?= ucfirst($user['Role']) ?>
                        </span>
                    </td>
                </tr>
            <?php endforeach; else: ?>
                <tr>
                    <td colspan="5" style="text-align:center;">Belum ada user yang terdaftar.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>

<?php include 'inc/footer.php'; ?>