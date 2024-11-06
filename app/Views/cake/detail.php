<html>
<head>
    <title>Cake Shop - Detail Kue</title>
    <link rel="stylesheet" href="/cake-shop/assets/css/bootstrap.css" />
</head>
<body>
<div class="row">
    <div class="col-md-12">
        <div class="col-md-4">&nbsp;</div>
        <div class="col-md-4">
            <h3>Detail Kue</h3>
            <p>ID: <?= $rs['id']; ?></p>
            <p>Nama: <?= $rs['name']; ?></p>
            <p>Harga: <?= $rs['price'], 0; ?></p>
            <p>Stok: <?= $rs['stock']; ?></p>
            <?php 
                $imgPath = '/cake-shop/' . $rs['imgurl'];
            ?>
            <img src="<?= $imgPath; ?>" alt="Gambar Kue" style="max-width: 100%;"/>
        </div>
        <div class="col-md-4">&nbsp;</div>
    </div>
</div>
</body>
</html>
