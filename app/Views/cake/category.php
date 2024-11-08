<?php
include __DIR__ . '../../../../public/views/partials/header.php';
?>
<!-- Konten Utama -->
<div class="main-content">
    <h1>Kategori Kue</h1>
    <div class="container mt-5">

        <!-- Form untuk menambah kategori baru -->
        <div class="mb-4">
            <h4>Tambah Kategori Baru</h4>
            <form action="/cake-shop/?act=save-category" method="POST">
                <div class="form-group">
                    <label for="categoryName">Nama Kategori</label>
                    <input type="text" id="categoryName" name="name" class="form-control" placeholder="Masukkan nama kategori" required>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Simpan Kategori</button>
            </form>
        </div>

        <!-- Tabel Kategori -->
        <div class="table-responsive">
            <h4>Daftar Kategori</h4>
            <table class="table table-striped table-bordered" id="cakeTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($categories as $cat): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($cat['name']); ?></td>
                            <td>
                                <!-- Tombol Edit Kategori -->
                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal"
                                    data-id="<?= $cat['id']; ?>" data-name="<?= htmlspecialchars($cat['name']); ?>">Edit</button>
                                <a onclick="return confirm('Apakah anda yakin ingin menghapus Kategori ini?')"
                                    href="?act=delete-category&id=<?= $cat['id']; ?>" class="btn btn-danger btn-sm">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Form Edit Kategori -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/cake-shop/?act=update-category" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editCategoryName">Nama Kategori</label>
                        <input type="text" id="editCategoryName" name="name" class="form-control" required>
                        <input type="hidden" id="editCategoryId" name="id">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include __DIR__ . '../../../../public/views/partials/footer.php';
?>
<!-- JavaScript Modal -->
<script>
    $('#editModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); 
        var id = button.data('id'); 
        var name = button.data('name');
        
        var modal = $(this);
        modal.find('#editCategoryName').val(name);
        modal.find('#editCategoryId').val(id);
    });
</script>
