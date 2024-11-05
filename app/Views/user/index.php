<html>
<head>
    <title>Pengguna - Cake Shop</title>
    <link rel="stylesheet" href="/mvc-example/assets/css/bootstrap.css" />
</head>
<body>
<div class="container">
    <h3>Data Pengguna</h3>
    <table class="table table-responsive table-bordered table-striped">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Created At</th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['id']); ?></td>
                <td><?= htmlspecialchars($user['username']); ?></td>
                <td><?= htmlspecialchars($user['created_at']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
</body>
</html>
