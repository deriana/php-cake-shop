<?php
include __DIR__ . '../../../../public/views/partials/header.php' ?>

<div class="main-content">
    <div class="container mt-5">
        <h3>Edit Pengguna</h3>
        <form action="/cake-shop/?act=update-user" method="post">
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
</div>

<?php 
include __DIR__ . '../../../../public/views/partials/footer.php' ?>