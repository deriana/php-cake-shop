<?php 
include __DIR__ . '../../../../public/views/partials/header.php' ?>

<!-- Konten Utama -->
<div class="main-content">
    <div class="container mt-5">
        <!-- Form edit user -->
        <h3>Tambah Pengguna</h3>
        <form action="/cake-shop/?act=user-save" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="/cake-shop/?act=user-manage" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<?php include __DIR__ . '../../../../public/views/partials/footer.php' ?>
