<html>

<head>
    <title>Cake Shop - Input Kue</title>
    <link rel="stylesheet" href="/mvc-example/assets/css/bootstrap.css" />
</head>

<body>
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-4">&nbsp;</div>
            <div class="col-md-4">
                <h3>Isikan data Kue di sini</h3>
                <form method="post" action="/mvc-example/?act=simpan-kue" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputName">Nama Kue</label>
                        <input type="text" class="form-control" name="name" placeholder="Nama Kue" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPrice">Harga</label>
                        <div class="input-group">
                            <span class="input-group-addon">Rp</span>
                            <input type="text" class="form-control" name="price" placeholder="Harga" onkeyup="formatCurrency(this)" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputStock">Stok</label>
                        <input type="number" class="form-control" name="stock" placeholder="Stok" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputImgUrl">Upload Gambar Kue</label>
                        <input type="file" class="form-control" name="imgurl" required>
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>
                <br />
                <a href="/mvc-example/?act=tampil-kue">Lihat Hasil Input Kue</a>
            </div>
            <div class="col-md-4">&nbsp;</div>
        </div>
    </div>
</body>
<script>
    function formatCurrency(input) {
        let value = input.value.replace(/[^0-9]/g, '');
        if (value) {
            input.value = 'Rp ' + parseInt(value).toLocaleString('id-ID');
        } else {
            input.value = '';
        }
    }
</script>

</html>