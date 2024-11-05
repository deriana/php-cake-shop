<html>

<head>
    <title>Edit Pengguna</title>
    <link rel="stylesheet" href="/mvc-example/assets/css/bootstrap.css" />
</head>

<body>
    <div class="container">
        <h3>Edit Pengguna</h3>
        <form action="/mvc-example/?act=user-update" method="post">
            <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']); ?>" />
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" name="username" value="<?= htmlspecialchars($user['username']); ?>" required />
            </div>
            <div class="form-group">
                <label for="password">Password (kosongkan jika tidak ingin mengubah):</label>
                <input type="password" class="form-control" name="password" />
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>

    </div>
</body>

</html>