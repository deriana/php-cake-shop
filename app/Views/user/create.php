<html>
<head>
    <title>Tambah Pengguna - Cake Shop</title>
    <link rel="stylesheet" href="/mvc-example/assets/css/bootstrap.css" />
</head>
<body>
    <div class="container">
        <h3>Tambah Pengguna</h3>
        <form action="/mvc-example/?act=user-save" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="/mvc-example/?act=user-manage" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>
