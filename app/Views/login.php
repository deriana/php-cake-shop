<!-- views/login.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Cake Shop</title>
    <link rel="stylesheet" href="/cake-shop/assets/css/bootstrap.css" />
</head>
<body>
<div class="container">
    <h3>Login Pengguna</h3>
    <form action="/cake-shop/?act=login-auth" method="POST">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</div>
</body>
</html>
