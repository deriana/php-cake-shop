<?php 
include __DIR__ . '../../../../public/views/partials/header.php' ?>

<!-- Konten Utama -->
<div class="main-content">
    <div class="container mt-5">
        <h3>Data Users</h3>
        <!-- Tabel Users -->
        <a href="/cake-shop/?act=user-create" class="btn btn-primary mb-3">Tambah Pengguna</a>
        <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Created At</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['id']); ?></td>
                            <td><?= htmlspecialchars($user['username']); ?></td>
                            <td><?= htmlspecialchars($user['created_at']); ?></td>
                            <td>
                                <a href="/cake-shop/?act=user-edit&id=<?= htmlspecialchars($user['id']); ?>" class="btn btn-warning">Edit</a>
                                <a onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')"
                                    href="/cake-shop/?act=user-delete&id=<?= htmlspecialchars($user['id']); ?>"
                                    class="btn btn-danger">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '../../../../public/views/partials/footer.php' ?>