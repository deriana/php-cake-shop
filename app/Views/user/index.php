<html>

<head>
    <title>Pengguna - Cake Shop</title>
    <link rel="stylesheet" href="/cake-shop/assets/css/bootstrap.css" />
</head>

<body>
    <div class="container">
        <h3>Data Pengguna</h3>

        <!-- Tombol untuk menambah pengguna -->
        <a href="/cake-shop/?act=user-create" class="btn btn-primary mb-3">Tambah Pengguna</a>

        <table class="table table-responsive table-bordered table-striped">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Created At</th>
                <th>Aksi</th> <!-- Tambahkan kolom aksi -->
            </tr>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['id']); ?></td>
                    <td><?= htmlspecialchars($user['username']); ?></td>
                    <td><?= htmlspecialchars($user['created_at']); ?></td>
                    <td>
                        <!-- Tombol Edit -->
                        <a href="/cake-shop/?act=user-edit&id=<?= htmlspecialchars($user['id']); ?>" class="btn btn-warning">Edit</a>
                        <!-- Tombol Hapus -->
                        <a onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')"
                            href="/cake-shop/?act=user-delete&id=<?= htmlspecialchars($user['id']); ?>"
                            class="btn btn-danger">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>

</html>