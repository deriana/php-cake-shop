<html>

<head>
    <title>Cake Shop - Daftar Kue</title>
    <link rel="stylesheet" href="/mvc-example/assets/css/bootstrap.css" />
</head>

<body>
    <div class="row">
        <div class="col-md-12">
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
                            <td><?= $cake['price']; ?></td>
                            <td><?= $cake['stock']; ?></td>
                            <td>
                                <?php if (!empty($cake['imgurl'])): ?>
                                    <img src="/mvc-example/<?= $cake['imgurl']; ?>" alt="Gambar Kue" style="max-width: 100px;"/>
                                <?php else: ?>
                                    Tidak ada gambar
                                <?php endif; ?>
                            </td>
                            <td><a href="?act=tampil-kue&i=<?= $cake['id']; ?>">Detail</a></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <div class="col-md-4">&nbsp;</div>
        </div>
    </div>
</body>

</html>
