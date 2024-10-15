<?php
include '../database/koneksi.php'; // Pastikan koneksi database sudah ada

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $tujuan = $_POST['tujuan'];
    $nope = $_POST['nope'];

    // Query untuk memperbarui data
    $query = "UPDATE ttamu SET nama='$nama', alamat='$alamat', tujuan='$tujuan', nope='$nope' WHERE id='$id'";
    
    if (mysqli_query($koneksi, $query)) {
        // Redirect atau pesan sukses
        echo "<script>
                alert('Data berhasil diperbarui!');
                document.location= '../page/daftar-pengunjung.php';
              </script>";
    } else {
        // Redirect atau pesan error
        echo "<script>
                alert('Terjadi kesalahan saat memperbarui data.');
                document.location= '../page/daftar-pengunjung.php';
              </script>";   
    }
}
?>

<?php foreach ($tampil as $data): ?>
<div class="modal fade" id="updateModal<?= $data['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Update Data Pengunjung</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="../controller/update.php" method="POST">
                    <input type="hidden" name="id" value="<?= $data['id'] ?>">
                    <div class="form-group">
                        <label for="nama">Nama Pengunjung</label>
                        <input type="text" class="form-control" name="nama" value="<?= $data['nama'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" name="alamat" required><?= $data['alamat'] ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="tujuan">Tujuan</label>
                        <input type="text" class="form-control" name="tujuan" value="<?= $data['tujuan'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="nope">No. HP</label>
                        <input type="text" class="form-control" name="nope" value="<?= $data['nope'] ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>