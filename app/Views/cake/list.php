<html>

<head>
    <title>Cake Shop - Daftar Kue</title>
    <link rel="stylesheet" href="/cake-shop/assets/css/bootstrap.css" />
</head>

<body>
    <div class="row">
        <div class="">
            <div class="col-md-4">&nbsp;</div>
            <div class="col-md-4">
                <h3>Data Kue</h3>
                <table class="table table-responsive table-bordered table-striped">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Img</th>
                        <th>Aksi</th>
                    </tr>
                    <?php foreach ($rs as $cake): ?>
                        <tr>
                            <td><?= $cake['id']; ?></td>
                            <td><?= $cake['name']; ?></td>
                            <td><?= $cake['price'], 0; ?></td>
                            <td><?= $cake['stock']; ?></td>
                            <td>
                                <?php if (!empty($cake['imgurl'])): ?>
                                    <img src="/cake-shop/<?= $cake['imgurl']; ?>" alt="Gambar Kue" style="max-width: 100px;" />
                                <?php else: ?>
                                    Tidak ada gambar
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="?act=edit-kue&i=<?= $cake['id']; ?>">Edit</a>
                                <a href="?act=tampil-kue&i=<?= $cake['id']; ?>">Detail</a>
                                <a onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')"
                                    href="?act=hapus-kue&id=<?= $cake['id']; ?>" class="btn btn-danger">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <div class="col-md-4">&nbsp;</div>
        </div>
    </div>
</body>

</html>