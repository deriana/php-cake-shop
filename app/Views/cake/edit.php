<html>

<head>
    <title>Cake Shop - Edit Kue</title>
    <link rel="stylesheet" href="/mvc-example/assets/css/bootstrap.css" />
    <script>
        function formatCurrency(input) {
            // Menghilangkan karakter yang bukan angka
            let value = input.value.replace(/[^0-9]/g, '');
            if (value) {
                // Menampilkan nilai dengan format mata uang
                input.value = 'Rp ' + parseInt(value).toLocaleString('id-ID');
            } else {
                input.value = '';
            }
        }

        function prepareInputPrice(input) {
            // Menghapus awalan 'Rp ' dan format angka menjadi integer
            let value = input.value.replace(/[^0-9]/g, '');
            input.value = value; // Memastikan hanya angka yang tersimpan saat input fokus
        }
    </script>
</head>

<body>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-4">&nbsp;</div>
            <div class="col-md-4">
                <h3>Edit Data Kue</h3>
                <form method="post" action="/mvc-example/?act=update-kue" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $cake['id']; ?>" />
                    <div class="form-group">
                        <label for="exampleInputName">Nama Kue</label>
                        <input type="text" class="form-control" name="name" value="<?= $cake['name']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPrice">Harga</label>
                        <div class="input-group">
                            <span class="input-group-addon">Rp</span>
                            <input type="text" class="form-control" name="price"
                                value="<?= 'Rp ' . number_format($cake['price'], 0, ',', '.'); ?>"
                                onfocus="prepareInputPrice(this)"
                                onkeyup="formatCurrency(this)" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputStock">Stok</label>
                        <input type="number" class="form-control" name="stock" value="<?= $cake['stock']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputImgUrl">Upload Gambar Kue (Kosongkan jika tidak ingin mengubah)</label>
                        <input type="file" class="form-control" name="imgurl">
                    </div>
                    <button type="submit" class="btn btn-default">Update</button>
                </form>
                <br />
                <a href="/mvc-example/?act=tampil-kue">Kembali ke Daftar Kue</a>
            </div>
            <div class="col-md-4">&nbsp;</div>
        </div>
    </div>
</body>

</html>